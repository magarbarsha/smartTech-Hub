<?php
include '../includes/config.php';

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dynamicproduct.php");
    exit();
}

$product_id = intval($_GET['id']);
$product = [];

// Fetch product details
$query = "SELECT * FROM prod WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    header("Location: dynamicproduct.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> | SmartTech Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3a0ca3;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }

        .product-details-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .product-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .product-gallery {
            position: relative;
            overflow: hidden;
        }

        .main-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            background: #f9f9f9;
            padding: 2rem;
            transition: var(--transition);
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            padding: 1rem;
            overflow-x: auto;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .thumbnail:hover {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .product-info {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .product-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--warning);
            font-weight: 600;
        }

        .product-stock {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--success);
            font-weight: 500;
        }

        .product-description {
            margin-bottom: 2rem;
            color: var(--gray);
        }

        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: auto;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #e0e0e0;
            background: none;
            border-radius: var(--border-radius);
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .add-to-cart {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .add-to-cart:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
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

        .product-specs {
            margin-top: 3rem;
        }

        .specs-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        .specs-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .specs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .specs-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .specs-table th, .specs-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .specs-table th {
            width: 30%;
            color: var(--gray);
            font-weight: 500;
        }

        /* Related Products */
        .related-products {
            margin-top: 4rem;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .product-card-img {
            height: 200px;
            width: 100%;
            object-fit: contain;
            background: #f9f9f9;
            padding: 1rem;
        }

        .product-card-info {
            padding: 1.5rem;
        }

        .product-card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .product-card-price {
            font-weight: 600;
            color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .product-details {
                grid-template-columns: 1fr;
            }

            .main-image {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .product-title {
                font-size: 1.6rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .main-image {
                height: 350px;
            }
        }

        @media (max-width: 576px) {
            .product-info {
                padding: 1.5rem;
            }

            .product-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .main-image {
                height: 300px;
            }
        }
    </style>
</head>
<body>

<?php include './nav.php'; ?>

<div class="product-details-container">
    <div class="product-details">
        <div class="product-gallery">
            <img src="../uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="main-image" id="mainImage">
            <div class="thumbnail-container">
                <!-- You can add more thumbnails here if you have multiple product images -->
                <img src="../uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Thumbnail 1" class="thumbnail" onclick="changeImage(this)">
            </div>
        </div>
        
        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
            
            <div class="product-meta">
                <div class="product-rating">
                    <i class="fas fa-star"></i>
                    <span>4.8 (126 reviews)</span>
                </div>
                <div class="product-stock">
                    <i class="fas fa-check-circle"></i>
                    <span>In Stock: <?php echo htmlspecialchars($product['quantity']); ?></span>
                </div>
            </div>
            
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            
            <form action="addToCart.php" method="post" class="product-actions">
                <input type="hidden" name="pid" value="<?php echo $product['id']; ?>">
                
                <div class="quantity-selector">
                    <button type="button" class="quantity-btn minus" onclick="decreaseQuantity()">-</button>
                    <input type="number" name="quantity" class="quantity-input" value="1" min="1" max="<?php echo htmlspecialchars($product['quantity']); ?>">
                    <button type="button" class="quantity-btn plus" onclick="increaseQuantity()">+</button>
                </div>
                
                <button type="submit" class="action-btn add-to-cart" name="addtocart">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
                
                <button type="button" class="action-btn wishlist-btn">
                    <i class="fas fa-heart"></i> Add to Wishlist
                </button>
            </form>
        </div>
    </div>
    
    <div class="product-specs">
        <h2 class="specs-title">Product Specifications</h2>
        <table class="specs-table">
            <tr>
                <th>Brand</th>
                <td>SmartTech</td>
            </tr>
            <tr>
                <th>Model</th>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            </tr>
            <tr>
                <th>Weight</th>
                <td>1.5 kg</td>
            </tr>
            <tr>
                <th>Dimensions</th>
                <td>15 x 10 x 2 cm</td>
            </tr>
            <tr>
                <th>Warranty</th>
                <td>1 Year Manufacturer Warranty</td>
            </tr>
        </table>
    </div>
    
    <div class="related-products">
        <h2 class="section-title">You May Also Like</h2>
        <div class="products-grid">
            <?php
            // Fetch related products (example - you should implement your own logic)
            $related_query = "SELECT * FROM prod WHERE id != $product_id ORDER BY RAND() LIMIT 4";
            $related_result = mysqli_query($conn, $related_query);
            
            if (mysqli_num_rows($related_result) > 0) {
                while ($related = mysqli_fetch_assoc($related_result)) {
            ?>
                    <a href="productDetails.php?id=<?php echo $related['id']; ?>" class="product-card">
                        <img src="../uploads/<?php echo htmlspecialchars($related['product_image']); ?>" alt="<?php echo htmlspecialchars($related['product_name']); ?>" class="product-card-img">
                        <div class="product-card-info">
                            <h3 class="product-card-title"><?php echo htmlspecialchars($related['product_name']); ?></h3>
                            <div class="product-card-price">$<?php echo number_format($related['price'], 2); ?></div>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>

<script>
    // Change main image when thumbnail is clicked
    function changeImage(element) {
        document.getElementById('mainImage').src = element.src;
    }
    
    // Quantity controls
    function increaseQuantity() {
        const input = document.querySelector('.quantity-input');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decreaseQuantity() {
        const input = document.querySelector('.quantity-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    // Add to cart animation
    document.querySelector('.add-to-cart').addEventListener('click', function(e) {
        // Only animate if form is valid
        if (document.querySelector('form').checkValidity()) {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check"></i> Added to Cart';
            }, 800);
        }
    });
    
    // Wishlist button animation
    document.querySelector('.wishlist-btn').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-heart"></i> Added to Wishlist';
        this.style.backgroundColor = 'var(--danger)';
        this.style.color = 'white';
        this.style.borderColor = 'var(--danger)';
    });
</script>
</body>
</html>