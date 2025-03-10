<?php
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../assets/css/orders.css">

   </head>
<body>

 
   <?php include './adminsidenav.php' ?>
<h1>Orders Management</h1>
    <!-- Dashboard Content Section (Cards) -->
    <div class="dashboard-content">
        <table>
<tr>
    <th>SN</th>
    <th>Order Number</th>
    <th>Ordered by</th>
    <th>Delivery Address</th>
    <th>Delivery Contact</th>
    <th>Delivery Email</th>
    <th>Total Amount</th>
    <th>Ordered Date</th>
    <th>Status</th>
</tr>
<?php 
$sql = "SELECT *, orders1.id AS order_id FROM orders1  INNER JOIN user ON orders1.user_id = user.id";
$res = mysqli_query($conn, $sql);
$num=mysqli_num_rows($res);
if($num>0){
    $counter = 0;
    while($row = mysqli_fetch_assoc($res)){
?>
<tr>
    <td><?php echo ++$counter; ?></td>
    <td><a href="orderDetails.php?oid=<?php echo $row['order_id']?>"><?php echo $row['order_number']?></a></td>
    <td><?php echo $row['name']?></td>
    <td><?php echo $row['delivery_address']; ?></td>
    <td><?php echo $row['delivery_phone']; ?></td>
    <td><?php echo $row['delivery_email']; ?></td>
    <td><?php echo $row['total_amount']; ?></td>
    <td><?php echo $row['ordered_date']; ?></td>
    <td><?php echo $row['order_status']; ?></td>
    <td><form action="orderUpdate.php" method="post">
<input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
    <select name="order_status" id="">
            <option value="pending" <?php echo $row['order_status']=='pending' ? "selected" : ""; ?>>Pending</option>
            <option value="packed" <?php echo $row['order_status']=='packed' ? "selected" : ""; ?>>Packed</option>
            <option value="shipped"<?php echo $row['order_status']=='shipped' ? "selected" : ""; ?>>shipped</option>
            <option value="delivered" <?php echo $row['order_status']=='delivered' ? "selected" : ""; ?>>delivered</option>
        </select>
<input type="submit" name="update" value="Update">
    </form></td>
</tr>
<?php }
}
?>
        </table>
    </div>

 <script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
