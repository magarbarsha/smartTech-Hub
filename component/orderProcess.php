<?php
session_start();
require '../includes/config.php';

// Verify user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Check for order success
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $user_id = $_SESSION['id'];
    
    // Verify order belongs to user
    $stmt = $conn->prepare("SELECT * FROM orders1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    
    if ($order) {
        // Get order items
        $items_stmt = $conn->prepare("SELECT * FROM order_items1 WHERE order_id = ?");
        $items_stmt->bind_param("i", $order_id);
        $items_stmt->execute();
        $items = $items_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        // Prepare order confirmation data
        $_SESSION['order_confirmation'] = [
            'order' => $order,
            'items' => $items,
            'payment_method' => 'Khalti'
            
        ];
        
        header("Location: orderConfirmation.php");
        exit();
    }
}

// If we get here, something went wrong
$_SESSION['error'] = "Invalid order or session expired";
header("Location: checkoutpage.php");
exit();