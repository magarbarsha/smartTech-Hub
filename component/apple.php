<?php
include '../includes/config.php';

// The brand_name is now hardcoded as 'hp', since you're fetching HP products
$brand_name = 'mac';

// Prepared statement for security
$sql = "
    SELECT prod.*, branch.brand_name 
    FROM prod
    JOIN branch ON prod.brand_id = branch.id
    WHERE branch.brand_name = ?
    ORDER BY prod.id DESC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $brand_name);
mysqli_stmt_execute($stmt);
$productResult = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mac Products | Premium Technology Solutions</title>
    <link rel="stylesheet" href="../assets/css/brand.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include './nav.php'; ?>
    <div class="container">
        <div class="header">
            <h2>Mac Premium Products</h2>
            <p class="subtitle">Innovation that matters for your business</p>
        </div>

        <div class="product-list">
            <?php if (mysqli_num_rows($productResult) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
                    <div class="product-card">
                        <div class="product-badge">Mac Official</div>
                        <div class="image-container">
                            <img src="../uploads/<?= htmlspecialchars($product['product_image']) ?>" 
                                 alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                 loading="lazy">
                        </div>
                        <div class="product-content">
                            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                            <div class="rating">
                                <span class="stars">★★★★★</span>
                                <span class="review-count">(42 reviews)</span>
                            </div>
                            <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="price-container">
                                <span class="price">$<?= number_format($product['price'], 2) ?></span>
                                <?php if ($product['price'] > 500): ?>
                                    <span class="discount-badge">Save 10%</span>
                                <?php endif; ?>
                            </div>
                            <div class="button-container">
                                <button class="cart-btn">
                                    <i class="icon-cart"></i> Add to Cart
                                </button>
                                <button class="wishlist-btn">
                                    <i class="icon-heart"></i> Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-products">
                    <img src="../assets/images/no-products.svg" alt="No products found">
                    <p>Currently no Mac products available. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include './footer.php'; ?>
</body>
</html>