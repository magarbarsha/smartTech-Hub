<?php
include '../includes/config.php';

if (!isset($_GET['oid'])) {
    echo "Order ID is missing!";
    exit;
}

$order_id = intval($_GET['oid']);

$sql = "SELECT *, orders1.id AS order_id FROM orders1  
        INNER JOIN user ON orders1.user_id = user.id
        WHERE orders1.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No order found!";
    exit;
}

$order = $result->fetch_assoc();

// Fetch order items
$item_sql = "SELECT order_items1.*, prod.product_name AS product_name, prod.price AS product_price 
             FROM order_items1
             INNER JOIN prod ON order_items1.product_id = prod.id 
             WHERE order_items1.order_id = ?";
$item_stmt = $conn->prepare($item_sql);
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$item_result = $item_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/orders.css">
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
</head>
<body>
<?php include 'adminsidenav.php' ?>
<div class="dashboard-content">
    <h1>Order Details</h1>
    <table>
        <tr><th>Order Number</th><td><?php echo $order['order_number']; ?></td></tr>
        <tr><th>Ordered By</th><td><?php echo $order['name']; ?></td></tr>
        <tr><th>Delivery Address</th><td><?php echo $order['delivery_address']; ?></td></tr>
        <tr><th>Delivery Contact</th><td><?php echo $order['delivery_phone']; ?></td></tr>
        <tr><th>Delivery Email</th><td><?php echo $order['delivery_email']; ?></td></tr>
        <tr><th>Total Amount</th><td><?php echo $order['total_amount']; ?></td></tr>
        <tr><th>Ordered Date</th><td><?php echo $order['ordered_date']; ?></td></tr>
        <tr><th>Status</th><td><?php echo $order['order_status']; ?></td></tr>
    </table>
    
    <h2>Order Items</h2>
    <table>
        <tr>
            <th>SN</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $counter = 0;
        while ($item = $item_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo ++$counter; ?></td>
            <td><?php echo $item['product_name']; ?></td>
            <td><?php echo $item['product_price']; ?></td>
            <td><?php echo $item['ordered_quantity']; ?></td>
            <td><?php echo $item['product_price'] * $item['ordered_quantity']; ?></td>
        </tr>
        <?php } ?>
    </table>
    
    <a href="orders.php" class="back-btn">Back to Orders</a>
</div>
<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
