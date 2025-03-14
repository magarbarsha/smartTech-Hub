<?php
session_start();
include '../includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please login to view your wishlist.'); window.location.href='../login.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$sql = "SELECT c.id AS wishlist_id, p.* FROM card_tbl c 
        JOIN prod p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";
$res = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../assets/css/productdisplay.css">
</head>
<body>
    <?php include './nav.php'; ?>
    <div class="dashboard-content">
        <h2>Your Wishlist</h2>
        <div class="product-container">
            <?php if (mysqli_num_rows($res) > 0) { 
                while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="product-card">
                    <div class="product-img-container">
                        <img src="../uploads/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-img">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $row['product_name']; ?></h3>
                        <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                    </div>
                    <div class="product-actions">
                        <form action="removeFromWishlist.php" method="post">
                            <input type="hidden" name="wishlist_id" value="<?php echo $row['wishlist_id']; ?>">
                            <button class="remove-btn" name="remove">Remove</button>
                        </form>
                    </div>
                </div>
            <?php } } else { ?>
                <p>No items in your wishlist.</p>
            <?php } ?>
        </div>
    </div>
    <?php include './footer.php'; ?>
</body>
</html>
