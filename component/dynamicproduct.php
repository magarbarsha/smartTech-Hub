<?php
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --success-dark: #38b6db;
            --danger: #f72585;
            --danger-dark: #e5177b;
            --warning: #f8961e;
            --warning-dark: #e6860d;
            --info: #3a0ca3;
            --info-dark: #2d0985;
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

        .dashboard-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Search Bar */
        .search-container {
            margin: 2rem auto 3rem;
            max-width: 800px;
            position: relative;
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-input {
            flex: 1;
            padding: 14px 20px;
            font-size: 16px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .search-btn {
            padding: 0 25px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        /* Product Grid */
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .product-img-container {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
            flex: 1;
        }

        .product-info h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .product-info p {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: #555;
        }

        .product-info strong {
            color: var(--dark);
            font-weight: 600;
        }

        .product-actions {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Buttons */
        .action-btn {
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
        }

        /* Primary Action Button (Add to Cart) */
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

        /* Secondary Action Button (View Details) */
        .details-btn {
            background: linear-gradient(135deg, var(--info), var(--info-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(58, 12, 163, 0.3);
        }

        .details-btn:hover {
            background: linear-gradient(135deg, var(--info-dark), #250771);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(58, 12, 163, 0.4);
        }

        /* Tertiary Action Button (Wishlist) */
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

        /* Button Icons */
        .action-btn i {
            font-size: 0.9em;
            transition: var(--transition);
        } */
        /* Button Styles - Small and Equal Size */
.search-btn {
    padding: 8px 16px;
    font-size: 14px;
    min-width: 100px;
}

.action-btn {
    padding: 8px 12px;
    font-size: 13px;
    min-width: 100%;
    box-sizing: border-box;
}

.cart-btn, .details-btn, .wishlist-btn {
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-product-btn {
    padding: 8px 16px;
    font-size: 14px;
}

/* Adjust icon sizes to match */
.action-btn i {
    font-size: 0.8em;
}

/* Make search button same height as input */
.search-input {
    padding: 8px 16px;
    height: 36px;
    box-sizing: border-box;
}

/* Ensure equal width for all action buttons */
.product-actions {
    gap: 8px;
}

.product-actions form, 
.product-actions a {
    width: 100%;
}

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .empty-icon {
            font-size: 3.5rem;
            color: #e0e0e0;
            margin-bottom: 1.5rem;
        }

        .empty-text {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .add-product-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .add-product-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .search-btn {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-content {
                padding: 1.5rem;
            }
            
            .product-container {
                grid-template-columns: 1fr;
            }
            
            .product-img-container {
                height: 200px;
            }
            
            .product-actions .action-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?php include './nav.php'; ?>

<div class="dashboard-content">
    <!-- Search Bar -->
    <div class="search-container">
        <form class="search-form" action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Search products by name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>
    
    <div class="product-container">
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        $query = "SELECT * FROM prod";
        if (!empty($search)) {
            $query .= " WHERE product_name LIKE '%$search%' OR description LIKE '%$search%'";
        }
        $res = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
        ?>
                <div class="product-card">
                    <div class="product-img-container">
                        <img src="../uploads/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="product-img">
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['quantity']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <div class="product-actions">
                        <form action="addToCart.php" method="post">
                            <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="action-btn cart-btn" name="addtocart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                        <a href="productDetails.php?id=<?php echo $row['id']; ?>" class="action-btn details-btn">
                            <i class="fas fa-info-circle"></i> View Details
                        </a>
                        <form action="addToWishlist.php" method="post">
                            <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="action-btn wishlist-btn" name="addtowishlist">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="empty-text">No products found</h3>
                <a href="#" class="add-product-btn">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>';
        }
        ?>
    </div>
</div>

<?php include './footer.php'; ?>

<script>
    // Add animation to buttons when clicked
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
    });

    // Add smooth scroll to top when search is performed
    <?php if(isset($_GET['search'])): ?>
        window.addEventListener('load', function() {
            window.scrollTo({
                top: document.querySelector('.product-container').offsetTop - 100,
                behavior: 'smooth'
            });
        });
    <?php endif; ?>
</script>
</body>
</html>