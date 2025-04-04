<?php
session_start();
require_once '../includes/config.php';

// Enhanced error reporting
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/payment_errors.log');
error_reporting(E_ALL);

/**
 * Enhanced error logging with context
 */
function logPaymentError($message, $context = []) {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'error' => $message,
        'context' => $context,
        'session_id' => session_id(),
        'request' => $_GET,
        'session_data' => $_SESSION['order_details'] ?? null,
        'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
    ];
    error_log(json_encode($logData, JSON_PRETTY_PRINT), 3, '../logs/payment_processor.log');
}

/**
 * Verify Khalti payment with retry mechanism
 */
function verifyKhaltiPayment($pidx) {
    $apiUrl = "https://a.khalti.com/api/v2/epayment/lookup/";
    $secretKey = '3da50215902547fa9b0b928e7fe7ab7b'; // Use your actual key
    
    $payload = json_encode(['pidx' => $pidx]);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Authorization: key ' . $secretKey,
            'Content-Type: application/json',
        ],
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        logPaymentError("Khalti API connection failed", ['error' => $error]);
        throw new RuntimeException("Payment verification failed: Connection error");
    }
    
    if ($httpCode !== 200) {
        logPaymentError("Khalti API returned non-200 status", [
            'code' => $httpCode, 
            'response' => $response,
            'pidx' => $pidx
        ]);
        throw new RuntimeException("Payment verification failed: API returned $httpCode");
    }
    
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logPaymentError("Failed to parse Khalti response", [
            'error' => json_last_error_msg(),
            'response' => $response
        ]);
        throw new RuntimeException("Payment verification failed: Invalid response format");
    }
    
    return $data;
}

/**
 * Validate and process payment parameters
 */
function validateAndProcessPayment($params) {
    // Required fields validation
    $requiredFields = ['pidx', 'transaction_id', 'amount', 'purchase_order_id'];
    foreach ($requiredFields as $field) {
        if (empty($params[$field])) {
            throw new InvalidArgumentException("Missing required field: $field");
        }
    }
    
    // Numeric validation for amount
    if (!is_numeric($params['amount']) || $params['amount'] <= 0) {
        throw new InvalidArgumentException("Invalid payment amount: " . $params['amount']);
    }
    
    // Return sanitized values
    return [
        'pidx' => filter_var($params['pidx'], FILTER_SANITIZE_STRING),
        'transaction_id' => filter_var($params['transaction_id'], FILTER_SANITIZE_STRING),
        'amount' => (float)($params['amount'] / 100), // Convert to rupees
        'purchase_order_id' => filter_var($params['purchase_order_id'], FILTER_SANITIZE_STRING)
    ];
}

/**
 * Process order and handle database operations
 */
function processOrder($conn, $validatedParams, $userData) {
    // Validate user data structure
    if (!isset($userData['user_id']) || !isset($userData['customer_info'])) {
        throw new RuntimeException("Invalid user data structure");
    }
    
    // Generate unique order number
    $orderNumber = 'ORD-' . time() . '-' . substr(bin2hex(random_bytes(4)), 0, 8);
    
    $conn->autocommit(FALSE);
    $conn->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");
    $conn->begin_transaction();
    
    try {
        // Insert order record
        $orderStmt = $conn->prepare("INSERT INTO orders1 (
            order_number, user_id, ordered_date, order_status,
            total_amount, delivery_name, delivery_email,
            delivery_phone, delivery_address, payment_method,
            transaction_id, pidx
        ) VALUES (?, ?, NOW(), 'Pending', ?, ?, ?, ?, ?, 'Khalti', ?, ?)");
        
        if (!$orderStmt) {
            throw new RuntimeException("Failed to prepare order statement: " . $conn->error);
        }
        
        $bindResult = $orderStmt->bind_param(
            "sidssssss",
            $orderNumber,
            $userData['user_id'],
            $validatedParams['amount'],
            $userData['customer_info']['name'],
            $userData['customer_info']['email'],
            $userData['customer_info']['phone'],
            $userData['customer_info']['address'],
            $validatedParams['transaction_id'],
            $validatedParams['pidx']
        );
        
        if (!$bindResult) {
            throw new RuntimeException("Failed to bind order parameters: " . $orderStmt->error);
        }
        
        if (!$orderStmt->execute()) {
            throw new RuntimeException("Failed to execute order statement: " . $orderStmt->error);
        }
        
        $orderId = $conn->insert_id;
        $orderStmt->close();
        
        // Process cart items with stock validation
        $cartQuery = "SELECT c.*, p.price, p.product_name, p.stock_quantity 
                     FROM card_tbl c
                     JOIN prod p ON c.product_id = p.id
                     WHERE c.user_id = ?
                     FOR UPDATE";
        
        $cartStmt = $conn->prepare($cartQuery);
        if (!$cartStmt) {
            throw new RuntimeException("Failed to prepare cart statement: " . $conn->error);
        }
        
        if (!$cartStmt->bind_param("i", $userData['user_id']) || !$cartStmt->execute()) {
            throw new RuntimeException("Failed to retrieve cart items: " . $cartStmt->error);
        }
        
        $cartItems = $cartStmt->get_result();
        $cartStmt->close();
        
        if ($cartItems->num_rows === 0) {
            throw new RuntimeException("No items found in cart for user: " . $userData['user_id']);
        }
        
        $itemStmt = $conn->prepare("
            INSERT INTO order_items1 (
                order_id, product_id, orderd_quantity,
                product_rate, product_name
            ) VALUES (?, ?, ?, ?, ?)
        ");
        
        if (!$itemStmt) {
            throw new RuntimeException("Failed to prepare item statement: " . $conn->error);
        }
        
        $stockStmt = $conn->prepare("
            UPDATE prod SET stock_quantity = stock_quantity - ? 
            WHERE id = ? AND stock_quantity >= ?
        ");
        
        if (!$stockStmt) {
            throw new RuntimeException("Failed to prepare stock statement: " . $conn->error);
        }
        
        $totalItems = 0;
        $outOfStockItems = [];
        
        while ($item = $cartItems->fetch_assoc()) {
            logPaymentError("Processing cart item", [
                'product_id' => $item['product_id'],
                'requested_quantity' => $item['product_quantity'],
                'available_stock' => $item['stock_quantity']
            ]);
            
            if ($item['stock_quantity'] < $item['product_quantity']) {
                $outOfStockItems[] = [
                    'product_id' => $item['product_id'],
                    'requested' => $item['product_quantity'],
                    'available' => $item['stock_quantity']
                ];
                continue;
            }
            
            // Insert order item
            $bindResult = $itemStmt->bind_param(
                "iiids", 
                $orderId, 
                $item['product_id'], 
                $item['product_quantity'], 
                $item['price'], 
                $item['product_name']
            );
            
            if (!$bindResult || !$itemStmt->execute()) {
                throw new RuntimeException("Failed to insert order item: " . $itemStmt->error);
            }
            
            // Update stock
            $bindResult = $stockStmt->bind_param(
                "iii", 
                $item['product_quantity'], 
                $item['product_id'], 
                $item['product_quantity']
            );
            
            if (!$bindResult || !$stockStmt->execute()) {
                throw new RuntimeException("Failed to update stock: " . $stockStmt->error);
            }
            
            if ($stockStmt->affected_rows === 0) {
                throw new RuntimeException("Stock update failed for product: " . $item['product_id']);
            }
            
            $totalItems++;
        }
        
        $itemStmt->close();
        $stockStmt->close();
        
        if (!empty($outOfStockItems)) {
            logPaymentError("Some items were out of stock", [
                'out_of_stock_items' => $outOfStockItems,
                'order_id' => $orderId
            ]);
        }
        
        if ($totalItems === 0) {
            throw new RuntimeException("No items could be processed - all out of stock");
        }
        
        // Update order with item count
        $updateStmt = $conn->prepare("UPDATE orders1 SET total_items = ? WHERE id = ?");
        if (!$updateStmt || !$updateStmt->bind_param("ii", $totalItems, $orderId) || !$updateStmt->execute()) {
            throw new RuntimeException("Failed to update order item count: " . ($updateStmt->error ?? $conn->error));
        }
        $updateStmt->close();
        
        // Clear processed cart items
        $clearCartStmt = $conn->prepare("DELETE FROM card_tbl WHERE user_id = ?");
        if (!$clearCartStmt || !$clearCartStmt->bind_param("i", $userData['user_id']) || !$clearCartStmt->execute()) {
            throw new RuntimeException("Failed to clear cart: " . ($clearCartStmt->error ?? $conn->error));
        }
        $clearCartStmt->close();
        
        if (!$conn->commit()) {
            throw new RuntimeException("Commit failed: " . $conn->error);
        }
        
        return [
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'amount' => $validatedParams['amount'],
            'transaction_id' => $validatedParams['transaction_id'],
            'total_items' => $totalItems
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        logPaymentError("Transaction rolled back", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'order_number' => $orderNumber ?? null,
            'order_id' => $orderId ?? null
        ]);
        throw $e;
    } finally {
        $conn->autocommit(TRUE);
    }
}

// Main execution flow
try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new RuntimeException("Invalid request method - expected GET");
    }
    
    // Check session data exists and has required structure
    if (empty($_SESSION['order_details'])) {
        throw new RuntimeException("Session expired or invalid - missing order_details");
    }
    
    if (!isset($_SESSION['order_details']['user_id']) || !isset($_SESSION['order_details']['customer_info'])) {
        throw new RuntimeException("Invalid session data structure");
    }
    
    // Log the incoming request for debugging
    logPaymentError("Payment response received", [
        'get_params' => $_GET,
        'session_user_id' => $_SESSION['order_details']['user_id']
    ]);
    
    // Validate and process payment parameters
    $validatedParams = validateAndProcessPayment($_GET);
    
    // Verify payment with Khalti
    $verification = verifyKhaltiPayment($validatedParams['pidx']);
    if ($verification['status'] !== 'Completed') {
        throw new RuntimeException("Payment not completed: " . ($verification['status'] ?? 'unknown'));
    }
    
    // Process the order
    $orderData = processOrder($conn, $validatedParams, $_SESSION['order_details']);
    
    // Prepare success response
    $_SESSION['order_success'] = [
        'order_id' => $orderData['order_id'],
        'order_number' => $orderData['order_number'],
        'amount' => $orderData['amount'],
        'transaction_id' => $orderData['transaction_id'],
        'payment_status' => 'Completed'
    ];
    
    // Clear session data
    unset($_SESSION['order_details']);
    
    // Log successful order processing
    logPaymentError("Order processed successfully", [
        'order_data' => $orderData,
        'verification_response' => $verification
    ]);
    
    // Redirect to success page
    header("Location: orderProcess.php");
    exit();
    
} catch (InvalidArgumentException $e) {
    logPaymentError("Validation error", [
        'error' => $e->getMessage(),
        'get_params' => $_GET,
        'session_data' => $_SESSION['order_details'] ?? null
    ]);
    $_SESSION['error'] = "Invalid payment details. Please try again.";
    header("Location: checkoutpage.php");
    exit();
    
} catch (RuntimeException $e) {
    logPaymentError("Processing error", [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'transaction_id' => $_GET['transaction_id'] ?? null,
        'session_data' => $_SESSION['order_details'] ?? null
    ]);
    $_SESSION['error'] = "Order processing failed. Reference: " . ($_GET['transaction_id'] ?? 'unknown');
    header("Location: checkoutpage.php");
    exit();
    
} catch (Exception $e) {
    logPaymentError("System error", [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'transaction_id' => $_GET['transaction_id'] ?? null
    ]);
    $_SESSION['error'] = "A system error occurred. Please contact support.";
    header("Location: checkoutpage.php");
    exit();
}