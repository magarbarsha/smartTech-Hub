<?php
session_start();
include '../includes/config.php';

// Get all fields from the URL
$pidx = $_GET['pidx'] ?? null;
$transaction_id = $_GET['transaction_id'] ?? null;
$amount = $_GET['amount'] ?? null;
$status = $_GET['status'] ?? null;
$purchase_order_id = $_GET['purchase_order_id'] ?? null;

if ($pidx) {
    // Verify payment with Khalti
    $postFields = ["pidx" => $pidx];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/lookup/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($postFields),
        CURLOPT_HTTPHEADER => [
            'Authorization: Key test_secret_key_3da50215902547fa9b0b928e7fe7ab7b', // replace with your test secret key
            'Content-Type: application/json',
        ],
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $responseArray = json_decode($response, true);
    
    if ($responseArray['status'] == "Completed") {
        // Update order status in database
        $order_number = str_replace("Order ", "", $responseArray['purchase_order_name']);
        $update_query = "UPDATE orders1 SET 
            order_status = 'Paid',
            payment_status = 'Completed',
            transaction_id = '$transaction_id'
            WHERE order_number = '$order_number'";
        
        mysqli_query($conn, $update_query);
        
        // Set success message
        $_SESSION['success'] = "Payment successful! Your order #$order_number has been placed.";
    } else {
        $_SESSION['error'] = "Payment verification failed. Please contact support.";
    }
} else {
    $_SESSION['error'] = "Invalid payment response.";
}

header("Location: checkoutpage.php");
exit();
?>