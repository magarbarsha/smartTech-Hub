<?php
include '../includes/config.php';

$brand_name = 'dell';

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
    <title>Dell Products | Premium Technology Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: #333;
            line-height: 1.6;
        }

        .container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .header .subtitle {
            font-size: 1.1rem;
            color: #666;
        }

        /* Product Grid */
        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }

        .image-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .image-container img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1.5rem;
            flex: 1;
        }

        .product-content h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 0.75rem;
        }

        .stars {
            color: #ffc107;
            font-size: 0.9rem;
        }

        .review-count {
            font-size: 0.8rem;
            color: #666;
        }

        .description {
            margin-bottom: 1rem;
            font-size: 0.95rem;
            color: #555;
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        .discount-badge {
            background: var(--danger);
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Buttons */
        .cart-btn, .wishlist-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
        }

        .cart-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .cart-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), #2a3fc5);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        .wishlist-btn {
            background: white;
            color: var(--danger);
            border: 2px solid #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .wishlist-btn:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.3);
        }

        /* Empty State */
        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .no-products img {
            max-width: 200px;
            margin-bottom: 1.5rem;
        }

        .no-products p {
            font-size: 1.25rem;
            color: #666;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .product-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 1.5rem;
            }
            
            .product-list {
                grid-template-columns: 1fr;
            }
            
            .image-container {
                height: 200px;
            }
            
            .header h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<?php include './nav.php'; ?>

<div class="container">
    <div class="header">
        <h2>Dell Premium Products</h2>
        <p class="subtitle">Innovation that matters for your business</p>
    </div>

    <div class="product-list">
        <?php if (mysqli_num_rows($productResult) > 0): ?>
            <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
                <div class="product-card">
                    <div class="product-badge">Dell Official</div>
                    <div class="image-container">
                        <img src="../uploads/<?php echo htmlspecialchars($product['product_image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="product-content">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="review-count">(42 reviews)</span>
                        </div>
                        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="price-container">
                            <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                            <?php if ($product['price'] > 500): ?>
                                <span class="discount-badge">Save 10%</span>
                            <?php endif; ?>
                        </div>
                        <div class="button-container">
                            <form action="addToCart.php" method="post" style="width: 100%;">
                                <input type="hidden" name="pid" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="cart-btn" name="addtocart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                            <form action="addToWishlist.php" method="post" style="width: 100%;">
                                <input type="hidden" name="pid" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="wishlist-btn" name="addtowishlist">
                                    <i class="fas fa-heart"></i> Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-products">
                <img src="../assets/images/no-products.svg" alt="No products found">
                <p>Currently no Dell products available. Check back soon!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include './footer.php'; ?>

<script>
    // Add animation to buttons when clicked
    document.querySelectorAll('.cart-btn, .wishlist-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });
</script>
</body>
</html>