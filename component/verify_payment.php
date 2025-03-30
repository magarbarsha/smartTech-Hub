<?php
require '../includes/config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['pidx'], $input['order_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

try {
    // Verify with Khalti
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://khalti.com/api/v2/payment/verify/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['pidx' => $input['pidx']]),
        CURLOPT_HTTPHEADER => [
            'Authorization: Key live_secret_key_your_actual_key_here', // Replace with your key
            'Content-Type: application/json'
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception('Payment verification failed');
    }

    $result = json_decode($response, true);
    if ($result['status'] !== 'Completed') {
        throw new Exception('Payment not completed');
    }

    // Update order status
    $updateOrder = "UPDATE orders1 SET 
                   order_status = 'Paid',
                   payment_status = 'Completed',
                   transaction_id = ?,
                   payment_details = ?
                   WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateOrder);
    $paymentDetails = json_encode($result);
    mysqli_stmt_bind_param($stmt, "ssi",
        $result['transaction_id'],
        $paymentDetails,
        $input['order_id']
    );
    mysqli_stmt_execute($stmt);

    echo json_encode([
        'success' => true,
        'transaction_id' => $result['transaction_id']
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>