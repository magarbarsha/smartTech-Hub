<?php
session_start();
require_once '../includes/config.php';

// Create logs directory if it doesn't exist
$logDir = '../logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

/**
 * Log payment errors with context
 */
function logPaymentError($message, $context = []) {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'error' => $message,
        'context' => $context,
        'session_id' => session_id(),
        'request_method' => $_SERVER['REQUEST_METHOD'],
        'request_data' => $_REQUEST,
        'input_data' => file_get_contents('php://input'),
        'session_data' => $_SESSION['order_details'] ?? null,
    ];
    
    $logFile = '../logs/payment_processor.log';
    if (!file_exists($logFile)) {
        file_put_contents($logFile, '');
        chmod($logFile, 0666);
    }
    
    error_log(json_encode($logData, JSON_PRETTY_PRINT) . PHP_EOL, 3, $logFile);
}

/**
 * Verify Khalti payment (Test Environment Only)
 */
function verifyKhaltiPayment($pidx) {
    // Test environment configuration only
    $apiUrl = 'https://a.khalti.com/api/v2/payment/status/';
    $secretKey = '16a9c2d3c62f447094e41784cb689de8'; // Fixed: Removed space after "test_secret_key"
   
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['pidx' => $pidx]),
        CURLOPT_HTTPHEADER => [
            'Authorization: Key ' . $secretKey,
            'Content-Type: application/json',
        ],
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        throw new RuntimeException("Khalti API connection failed: " . $error);
    }
    
    if ($httpCode !== 200) {
        $errorResponse = @json_decode($response, true);
        $errorDetail = $errorResponse['detail'] ?? $response;
        throw new RuntimeException("Khalti API error ($httpCode): " . $errorDetail);
    }
    
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Invalid Khalti response format");
    }
    
    if (!isset($data['status']) || $data['status'] !== 'Completed') {
        throw new RuntimeException("Payment not completed. Status: " . ($data['status'] ?? 'Unknown'));
    }
    
    return $data;
}

/**
 * Process the order after successful payment
 */
function processOrder($conn, $user_id, $payment_data) {
    $conn->begin_transaction();
    
    try {
        // 1. Create the order
        $order_number = 'ORD-' . time() . '-' . bin2hex(random_bytes(3));
        $stmt = $conn->prepare("INSERT INTO orders1 (
            order_number, user_id, ordered_date, order_status, 
            total_amount, payment_method, transaction_id
        ) VALUES (?, ?, NOW(), 'Pending', ?, 'Khalti', ?)");
        
        if (!$stmt) {
            throw new RuntimeException("Failed to prepare order statement: " . $conn->error);
        }
        
        $stmt->bind_param(
            "sids", 
            $order_number,
            $user_id,
            $payment_data['amount'],
            $payment_data['transaction_id']
        );
        
        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to create order: " . $stmt->error);
        }
        
        $order_id = $conn->insert_id;
        $stmt->close();
        
        // 2. Process cart items
        $cart_query = "SELECT c.*, p.price, p.product_name, p.stock_quantity 
                      FROM card_tbl c
                      JOIN prod p ON c.product_id = p.id
                      WHERE c.user_id = ?";
        
        $stmt = $conn->prepare($cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_items = $stmt->get_result();
        
        $total_items = 0;
        $item_stmt = $conn->prepare("INSERT INTO order_items1 (
            order_id, product_id, ordered_quantity, product_rate, product_name
        ) VALUES (?, ?, ?, ?, ?)");
        
        $stock_stmt = $conn->prepare("UPDATE prod SET stock_quantity = stock_quantity - ? 
                                    WHERE id = ? AND stock_quantity >= ?");
        
        while ($item = $cart_items->fetch_assoc()) {
            // Check stock
            if ($item['stock_quantity'] < $item['product_quantity']) {
                throw new RuntimeException("Insufficient stock for product: " . $item['product_name']);
            }
            
            // Add order item
            $item_stmt->bind_param(
                "iiids",
                $order_id,
                $item['product_id'],
                $item['product_quantity'],
                $item['price'],
                $item['product_name']
            );
            $item_stmt->execute();
            
            // Update stock
            $stock_stmt->bind_param(
                "iii",
                $item['product_quantity'],
                $item['product_id'],
                $item['product_quantity']
            );
            $stock_stmt->execute();
            
            $total_items++;
        }
        
        // 3. Update order with item count
        $update_stmt = $conn->prepare("UPDATE orders1 SET total_items = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $total_items, $order_id);
        $update_stmt->execute();
        
        // 4. Clear cart
        $clear_cart = $conn->prepare("DELETE FROM card_tbl WHERE user_id = ?");
        $clear_cart->bind_param("i", $user_id);
        $clear_cart->execute();
        
        $conn->commit();
        
        return [
            'order_id' => $order_id,
            'order_number' => $order_number,
            'total_amount' => $payment_data['amount'],
            'transaction_id' => $payment_data['transaction_id']
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

// Main execution
try {
    // Debugging: Log the incoming request
    error_log("Incoming payment response: " . json_encode($_REQUEST));
    
    // Validate request method
    if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'GET'])) {
        throw new RuntimeException("Invalid request method. Only POST or GET allowed.");
    }
    
    // Get input data
    $input = ($_SERVER['REQUEST_METHOD'] === 'POST') ? 
        (json_decode(file_get_contents('php://input'), true) ?: $_POST) : 
        $_GET;
    
    // Validate required fields
    $requiredFields = ['pidx', 'total_amount', 'tidx'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new RuntimeException("Missing required field: $field");
        }
    }
    
    if (!is_numeric($input['total_amount']) || $input['total_amount'] <= 0) {
        throw new RuntimeException("Invalid payment amount");
    }
    
    if (empty($_SESSION['id'])) {
        throw new RuntimeException("User session not found. Please login again.");
    }
    
    // Convert amount from paisa to rupees
    $amount = $input['total_amount'] / 100;
    
    // Verify payment with Khalti
    $verification = verifyKhaltiPayment($input['pidx']);
    
    // Process order
    $order_data = processOrder($conn, $_SESSION['id'], [
        'amount' => $amount,
        'transaction_id' => $input['tidx']
    ]);
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Payment processed successfully',
        'order_id' => $order_data['order_id'],
        'order_number' => $order_data['order_number'],
        'amount_paid' => number_format($amount, 2),
        'transaction_id' => $order_data['transaction_id'],
        'payment_status' => 'completed'
    ]);
    
} catch (Exception $e) {
    logPaymentError($e->getMessage(), [
        'trace' => $e->getTraceAsString(),
        'input' => $input ?? null,
        'session' => $_SESSION ?? null
    ]);
    
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_type' => 'payment_processing_error',
        'debug_info' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'request_method' => $_SERVER['REQUEST_METHOD']
        ]
    ]);
}