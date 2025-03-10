<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['success'])) {
    header("Location: checkoutpage.php");
    exit();
}

$order_number = $_SESSION['success'];
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
    
    
    .confirmation-message {
    text-align: center;
    background-color: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 50px auto;
    max-width: 600px;
}

.confirmation-message h2 {
    font-size: 2rem;
    color: #28a745;
    margin-bottom: 20px;
}

.confirmation-message p {
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.confirmation-message strong {
    color: #007bff;
    font-weight: bold;
}
    </style>
</head>
<body>
    <?php include './nav.php' ?>

    <main class="container">
        <div class="confirmation-message">
            <h2>Thank you for your order!</h2>
            <p>Your order number is: <strong><?php echo $order_number; ?></strong></p>
            <p>We will process your order shortly.</p>
            <a href="./shop.php" class="btn">Continue Shopping</a>
        </div>
    </main>

    <?php include './footer.php' ?>
</body>
</html>