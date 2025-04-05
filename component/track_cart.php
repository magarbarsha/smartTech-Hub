<?php
session_start();
include 'db_connect.php'; // Your DB connection file

if (isset($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
} else {
    $user_id = NULL;
    $email = NULL;
    $phone = NULL;
}

$cart_data = json_encode($_SESSION['cart']); // Store cart items
$session_id = session_id();

// Save to abandoned_carts table
$stmt = $conn->prepare("
    INSERT INTO abandoned_carts 
    (user_id, session_id, cart_data, email, phone, abandoned_at) 
    VALUES (?, ?, ?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE cart_data = VALUES(cart_data), abandoned_at = NOW()
");
$stmt->bind_param("issss", $user_id, $session_id, $cart_data, $email, $phone);
$stmt->execute();
?>