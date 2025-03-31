<?php
session_start();
include '../includes/config.php';

// Validate required parameters
$requiredParams = ['pidx', 'transaction_id', 'amount', 'purchase_order_id'];
foreach ($requiredParams as $param) {
    if (empty($_GET[$param])) {
        $_SESSION['error'] = "Invalid payment response. Missing required parameter: $param";
        header("Location: checkoutpage.php");
        exit();
    }
}

// Extract and sanitize parameters
$pidx = mysqli_real_escape_string($conn, $_GET['pidx']);
$transaction_id = mysqli_real_escape_string($conn, $_GET['transaction_id']);
$amount = floatval($_GET['amount']) / 100; // Convert to rupees
$purchase_order_id = mysqli_real_escape_string($conn, $_GET['purchase_order_id']);
$order_status = $_GET['order_status'] ?? '';

// Verify session data exists and is recent (within 1 hour)
if (!isset($_SESSION['order_details']) || 
    !isset($_SESSION['order_details']['timestamp']) || 
    (time() - $_SESSION['order_details']['timestamp'] > 3600)) {
    $_SESSION['error'] = "Invalid session data. Please start checkout again.";
    header("Location: checkoutpage.php");
    exit();
}

// Verify payment with Khalti
$postFields = ["pidx" => $pidx];
$jsonData = json_encode($postFields);

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/lookup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => [
        'Authorization: key 3da50215902547fa9b0b928e7fe7ab7b',
        'Content-Type: application/json',
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode !== 200) {
    $_SESSION['error'] = "Payment verification failed. Please contact support.";
    header("Location: checkoutpage.php");
    exit();
}

$verification = json_decode($response, true);

// Verify payment status and amount
if ($verification['status'] !== 'Completed' || 
    ($verification['total_amount'] / 100) != $amount) {
    $_SESSION['error'] = "Payment verification mismatch. Please contact support.";
    header("Location: checkoutpage.php");
    exit();
}

// Process the order
mysqli_begin_transaction($conn);

try {
    // 1. Create order record
    $orderQuery = "INSERT INTO orders1 (
        user_id, 
        total_amount,
        transaction_id,
        order_status, 
        pidx,
        customer_name,
        customer_email,
        customer_phone,
        customer_address
    ) VALUES (
        {$_SESSION['order_details']['user_id']},
        $amount,
        '$transaction_id',
        'completed',
        '$pidx',
        '{$_SESSION['order_details']['customer_info']['name']}',
        '{$_SESSION['order_details']['customer_info']['email']}',
        '{$_SESSION['order_details']['customer_info']['phone']}',
        '{$_SESSION['order_details']['customer_info']['address']}'
    )";
    
    if (!mysqli_query($conn, $orderQuery)) {
        throw new Exception("Failed to create order record: " . mysqli_error($conn));
    }
    
    $order_id = mysqli_insert_id($conn);
    
    // 2. Move cart items to order items
    $cartQuery = "SELECT c.*, p.price 
                 FROM card_tbl c
                 JOIN prod p ON c.product_id = p.id
                 WHERE c.user_id = {$_SESSION['order_details']['user_id']}";
    $cartRes = mysqli_query($conn, $cartQuery);
    
    while ($item = mysqli_fetch_assoc($cartRes)) {
        $insertItem = "INSERT INTO order_items1 (
            order_id, 
            product_id, 
            orderd_quantity, 
            product_rate
        ) VALUES (
            $order_id,
            {$item['product_id']},
            {$item['product_quantity']},
            {$item['price']}
        )";
        
        if (!mysqli_query($conn, $insertItem)) {
            throw new Exception("Failed to add order items: " . mysqli_error($conn));
        }
    }
    
    // 3. Clear the cart
    $clearCart = "DELETE FROM card_tbl WHERE user_id = {$_SESSION['order_details']['user_id']}";
    if (!mysqli_query($conn, $clearCart)) {
        throw new Exception("Failed to clear cart: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    // Clear order details from session
    unset($_SESSION['order_details']);
    
    $_SESSION['success'] = "Payment successful! Your order #$order_id has been placed.";
    header("Location: orderProcess.php");
    exit();
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    $_SESSION['error'] = "Order processing failed: " . $e->getMessage();
    error_log("Order processing error: " . $e->getMessage());
    header("Location: checkoutpage.php");
exit();
}
