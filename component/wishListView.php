<?php
session_start();
include '../includes/config.php';

// Check if the user is logged in with SweetAlert
if (!isset($_SESSION['id'])) {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        title: "Login Required",
        text: "Please login to view your wishlist",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Login Now",
        cancelButtonText: "Continue Shopping",
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../login.php";
        } else {
            window.location.href = "../index.php";
        }
    });
    </script>';
    exit();
}

$user_id = $_SESSION['id'];
$sql = "SELECT c.id AS wishlist_id, p.* FROM card_tbl c 
        JOIN prod p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | TechStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --danger: #f72585;
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
        }

        .dashboard-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .wishlist-header h2 {
            font-size: 2rem;
            color: var(--dark);
            margin: 0;
        }

        .wishlist-count {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }

        .product-container {
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

        .wishlist-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--danger);
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 8px rgba(247, 37, 133, 0.3);
            z-index: 1;
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
            gap: 12px;
        }

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
            flex: 1;
        }

        .remove-btn {
            background: white;
            color: var(--danger);
            border: 2px solid #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .remove-btn:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.3);
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .add-to-cart-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), #2a3fc5);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        .empty-wishlist {
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

        .browse-btn {
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

        .browse-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
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
        }
    </style>
</head>
<body>
    <?php include './nav.php'; ?>
    <div class="dashboard-content">
        <div class="wishlist-header">
            <h2>Your Wishlist</h2>
            <div class="wishlist-count">
                <i class="fas fa-heart"></i> <?php echo mysqli_num_rows($res); ?> Items
            </div>
        </div>
        
        <div class="product-container">
            <?php if (mysqli_num_rows($res) > 0) { 
                while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="product-card">
                    <div class="wishlist-badge">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="product-img-container">
                        <img src="../uploads/<?php echo htmlspecialchars($row['product_image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                             class="product-img">
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['quantity']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <div class="product-actions">
                        <form action="addToCart.php" method="post" class="add-to-cart-form">
                            <input type="hidden" name="pid" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn add-to-cart-btn" name="addtocart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                        <form action="removeFromWishlist.php" method="post" class="remove-wishlist-form">
                            <input type="hidden" name="wishlist_id" value="<?php echo $row['wishlist_id']; ?>">
                            <button type="submit" class="action-btn remove-btn" name="remove">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
            <?php } } else { ?>
                <div class="empty-wishlist">
                    <div class="empty-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3 class="empty-text">Your wishlist is empty</h3>
                    <p>Start adding items you love!</p>
                    <a href="../products.php" class="browse-btn">
                        <i class="fas fa-search"></i> Browse Products
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include './footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle remove from wishlist with confirmation
        document.querySelectorAll('.remove-wishlist-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Remove from Wishlist?',
                    text: "Are you sure you want to remove this item from your wishlist?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f72585',
                    cancelButtonColor: '#4361ee',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if confirmed
                        this.submit();
                    }
                });
            });
        });

        // Handle add to cart with feedback
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                
                // Show loading state
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;
                
                // Submit via fetch API
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to add to cart'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while adding to cart'
                    });
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });
        });
    </script>
</body>
</html>