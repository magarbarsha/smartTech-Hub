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
    <link rel="stylesheet" href="../assets/css/productdisplay.css">
    <style>
        .search-container {
            position: relative;
            top: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .search-input {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
        .search-btn {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-btn, .wishlist-btn {
            display: inline-block;
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            text-transform: uppercase;
        }
        .cart-btn {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 126, 95, 0.3);
        }
        .cart-btn:hover {
            background: linear-gradient(135deg, #ff5733, #ff9966);
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(255, 87, 51, 0.4);
        }
        .wishlist-btn {
            background: transparent;
            color: #ff4081;
            border: 2px solid black;
            box-shadow: 0 4px 10px rgba(255, 64, 129, 0.2);
        }
        .wishlist-btn:hover {
            background: orange;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(255, 64, 129, 0.4);
        }
    </style>
</head>
<body>

<?php include './nav.php'; ?>

<div class="dashboard-content">
    <!-- Search Bar -->
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Search for products..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>
    
    <div class="product-container">
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        $query = "SELECT * FROM prod";
        if (!empty($search)) {
            $query .= " WHERE product_name LIKE '%$search%'";
        }
        $res = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($res) > 0) {
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
                    </div>
                    <form action="addToCart.php" method="post">
                            <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                            <button class="cart-btn" name="addtocart">ADD TO CART</button>
                        </form>
                        <form action="addToWishlist.php" method="post">
                            <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                            <button class="wishlist-btn" name="addtowishlist">♡ Wishlist</button>
                        </form>
                </div>
        <?php
            }
        } else {
            echo "<p style='text-align:center;'>No products found.</p>";
        }
        ?>
    </div>
</div>

<?php include './footer.php'; ?>
<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
