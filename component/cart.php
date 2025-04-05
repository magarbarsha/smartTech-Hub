<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .cart-item { display: flex; margin-bottom: 15px; }
        .cart-item img { width: 80px; margin-right: 15px; }
        #checkout-btn { 
            background: #4CAF50; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            cursor: pointer; 
        }
        #checkout-btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <div id="cart-items">
        <!-- Dynamically loaded from PHP/Session -->
        <?php
        session_start();
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                echo '
                <div class="cart-item">
                    <img src="' . $item['image'] . '">
                    <div>
                        <h3>' . $item['name'] . '</h3>
                        <p>$' . $item['price'] . '</p>
                    </div>
                </div>';
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </div>
    
    <button id="checkout-btn">Proceed to Checkout</button>
    
    <!-- Track cart abandonment -->
    <script>
    window.addEventListener('beforeunload', function() {
        fetch('track_cart.php', { method: 'POST' });
    });
    </script>
</body>
</html>