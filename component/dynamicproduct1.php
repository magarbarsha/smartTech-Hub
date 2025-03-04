<?php
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../assets/css/productdisplay.css">
</head>
<body>

<?php
    include './nav.php';
?>

<!-- Dashboard Content Section -->
<div class="dashboard-content">
    <!-- Add Product Button -->
    <!-- Product Display Section -->
    <div class="product-container">
        <?php
        $sql = "SELECT * FROM prod";
        $res = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($res);

        // Display the rows returned by the SQL query
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
        ?>
        <div class="product-card">
            <div class="product-img-container">
                <img src="../uploads/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-img">
            </div>
            <div class="product-info">
                <h3><?php echo $row['product_name']; ?></h3>
                <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                <form method="post" action="checkout.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="submit" value="Buy Now" class="btn-sucess">
                </form>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </div> <!-- End of Product Container -->
</div>
<?php
    include './footer.php';
?>
<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
