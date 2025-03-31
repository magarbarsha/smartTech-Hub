<?php
session_start();
require '../includes/config.php';

// Check if coming from Khalti payment
if (isset($_GET['pidx']) && isset($_SESSION['khalti_verification'])) {
    $pidx = $_GET['pidx'];
    $verification_data = $_SESSION['khalti_verification'];

    // Verify payment with Khalti using the provided URL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/lookup/', // Updated URL
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['pidx' => $pidx]),
        CURLOPT_HTTPHEADER => [
            'Authorization: Key 3da50215902547fa9b0b928e7fe7ab7b',
            'Content-Type: application/json',
        ]
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        $result = json_decode($response, true);
        if ($result['status'] === 'Completed' && $result['total_amount'] === (int)($verification_data['amount'] * 100)) {
            // Payment successful, update order status
            $stmt = $conn->prepare("UPDATE orders1 SET status = 'paid' WHERE id = ?");
            $stmt->bind_param("i", $verification_data['order_id']);
            $stmt->execute();
            $stmt->close();

            // Clear cart
            $stmt = $conn->prepare("DELETE FROM card_tbl WHERE user_id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $stmt->close();

            // Clear session data
            unset($_SESSION['khalti_verification']);
            unset($_SESSION['current_order']);
            unset($_SESSION['shipping_info']);

            echo "<h1>Payment Successful!</h1>";
            echo "<p>Your order has been placed successfully. Thank you for shopping with PharmaCare!</p>";
        } else {
            echo "<h1>Payment Verification Failed</h1>";
            echo "<p>The payment could not be verified. Please contact support.</p>";
        }
    } else {
        echo "<h1>Error</h1>";
        echo "<p>Error verifying payment with Khalti. HTTP Code: $http_code</p>";
    }
} elseif (isset($_GET['method']) && $_GET['method'] === 'cod' && isset($_SESSION['current_order'])) {
    // Handle COD order confirmation
    $order_id = $_SESSION['current_order']['id'];

    // Optionally update status to 'confirmed' or keep as 'pending'
    $stmt = $conn->prepare("UPDATE orders1 SET status = 'confirmed' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM card_tbl WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    // Clear session data
    unset($_SESSION['current_order']);
    unset($_SESSION['shipping_info']);

    echo "<h1>Order Placed Successfully!</h1>";
    echo "<p>Your order has been placed with Cash on Delivery. Thank you for shopping with PharmaCare!</p>";
} else {
    echo "<h1>Invalid Request</h1>";
    echo "<p>No valid payment or order data found. Please try again or contact support.</p>";
}
?>