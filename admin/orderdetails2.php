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
<style>
    /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 0;
    text-align: center;
    color: #333;
}

h1 {
    color: #222;
    margin-top: 20px;
    font-size: 32px;
    text-transform: uppercase;
    font-weight: bold;
}

.dashboard-content {
    width: 90%;
    margin: 20px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 16px;
    text-align: left;
    border-bottom: 2px solid #eee;
    font-size: 16px;
}

th {
    background-color:rgba(0, 123, 255, 0.81);
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}

td a {
    text-decoration: none;
    color: #007BFF;
    font-weight: bold;
    transition: 0.3s;
}

td a:hover {
    text-decoration: underline;
    color: #0056b3;
}

/* Status Dropdown */
select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #f8f9fa;
    cursor: pointer;
    transition: 0.3s;
    font-size: 14px;
}

select:hover {
    border-color: #007BFF;
}

/* Update Button */
input[type="submit"] {
    padding: 8px 15px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
    font-size: 14px;
}

input[type="submit"]:hover {
    background: #218838;
}

/* Back Button */
.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: orange;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    transition: 0.3s;
    font-weight: bold;
}

.back-btn:hover {
    background: #c82333;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    .dashboard-content {
        padding: 15px;
    }
    th, td {
        padding: 12px;
    }
}

</style>
</head>
<body>

<?php include 'adminsidenav.php' ?>

<div class="dashboard-content">
    <h1>Order Details</h1>
    <table>
        <tr>
            <th>Order Number</th>
            <td><?php echo $order['order_number']; ?></td>
        </tr>
        <tr>
            <th>Ordered By</th>
            <td><?php echo $order['name']; ?></td>
        </tr>
        <tr>
            <th>Delivery Address</th>
            <td><?php echo $order['delivery_address']; ?></td>
        </tr>
        <tr>
            <th>Delivery Contact</th>
            <td><?php echo $order['delivery_phone']; ?></td>
        </tr>
        <tr>
            <th>Delivery Email</th>
            <td><?php echo $order['delivery_email']; ?></td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><?php echo $order['total_amount']; ?></td>
        </tr>
        <tr>
            <th>Ordered Date</th>
            <td><?php echo $order['ordered_date']; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo $order['order_status']; ?></td>
        </tr>
    </table>

    <a href="orders.php" class="back-btn">Back to Orders</a>
</div>
<script src="../assets/js/dashboard_script.js"></script>

</body>
</html>
