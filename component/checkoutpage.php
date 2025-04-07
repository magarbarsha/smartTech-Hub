<?php
session_start();
include '../includes/config.php';
$selectQuery = "SELECT * FROM user WHERE id = $_SESSION[id]";
$res = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
    $payment_method = $row['payment_method'];
}

// Calculate cart total
$user_id = $_SESSION['id'];
$totalAmount = 0;
$shippingCharge = 100;
$sql = "SELECT *, card_tbl.id AS card_id, prod.id AS product_id FROM card_tbl 
        INNER JOIN prod ON card_tbl.product_id=prod.id WHERE user_id=$user_id";
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $totalAmount += $row['price'] * $row['product_quantity'];
}
$finalTotal = $totalAmount + $shippingCharge;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | SmartTech Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <style>
        /* Previous CSS remains the same, just adding new styles for COD option */
        .payment-method {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .payment-method:hover {
            border-color: var(--primary);
        }
        
        .payment-method.selected {
            border-color: var(--primary);
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .payment-method input[type="radio"] {
            margin-right: 10px;
        }
        
        .payment-method-label {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        
        .payment-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .khalti-icon {
            color: #5C2D91;
        }
        
        .cod-icon {
            color: var(--success);
        }
        :root {
            --primary: #007bff;
            --primary-dark: #0069d9;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .checkout-container {
            display: flex;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
            gap: 2rem;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            .checkout-container {
                flex-direction: row;
            }
            
            .checkout-form {
                flex: 1.5;
            }
            
            .order-summary {
                flex: 1;
            }
        }

        /* Checkout Form Styling */
        .checkout-form, .order-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
        }

        .section-title {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            position: relative;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        /* Payment Methods */
        .payment-section {
            margin-top: 2rem;
            border-top: 1px solid #eee;
            padding-top: 1.5rem;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }

        .payment-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            color: white;
            background: var(--primary);
            width: 100%;
        }

        .payment-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Order Summary Styling */
        .order-items {
            margin-bottom: 1.5rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .order-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-price {
            color: var(--primary);
            font-weight: 600;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .quantity-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }

        .update-btn {
            padding: 8px 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .update-btn:hover {
            background: var(--primary-dark);
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-btn:hover {
            color: #c82333;
        }

        /* Order Summary */
        .summary-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-top: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            padding-top: 10px;
            border-top: 1px solid #ddd;
            margin-top: 10px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 1rem;
            position: relative;
            padding-left: 50px;
        }

        .alert i {
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 1.2rem;
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        /* Empty Cart State */
        .empty-cart {
            text-align: center;
            padding: 2rem;
            color: var(--secondary);
        }

        .empty-cart i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .checkout-container {
                padding: 0 15px;
            }
            
            .checkout-form, .order-summary {
                padding: 1.5rem;
            }
            
            .order-item {
                flex-direction: column;
            }
            
            .item-image {
                width: 100%;
                height: auto;
                max-height: 200px;
            }
        }
        
        /* Rest of your existing CSS remains the same */
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    
    <div class="checkout-container">
        <!-- Checkout Form - Left Side -->
        <div class="checkout-form">
            <h2 class="section-title"><i class="fas fa-user-circle"></i> Customer Information</h2>
            
            <?php 
            if (isset($_SESSION['error'])) {
                echo "<div class='alert error-message'><i class='fas fa-exclamation-circle'></i> " . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<div class='alert success-message'><i class='fas fa-check-circle'></i> " . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            } 
            ?>
            
            <form action="pay.php" method="post" id="paymentForm">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo $phone ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Shipping Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $address ?>" required>
                </div>
                
                <input type="hidden" name="amount" value="<?php echo $finalTotal ?>">
                <input type="hidden" name="purchase_order_id" value="<?php echo uniqid() ?>">
                <input type="hidden" name="purchase_order_name" value="Order from <?php echo $name ?>">
                
                <div class="payment-section">
                    <h3 class="section-title"><i class="fas fa-credit-card"></i> Payment Method</h3>
                    
                    <div class="payment-options">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="khalti" checked>
                            <span class="payment-method-label">
                                <i class="fas fa-wallet payment-icon khalti-icon"></i>
                                <span>Pay with Khalti</span>
                            </span>
                        </label>
                        
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cod">
                            <span class="payment-method-label">
                                <i class="fas fa-money-bill-wave payment-icon cod-icon"></i>
                                <span>Cash on Delivery (COD)</span>
                            </span>
                        </label>
                    </div>
                    
                    <button type="submit" name="submit" class="payment-btn" id="submitBtn">
                        <i class="fas fa-wallet"></i> Proceed to Payment (₹<?php echo number_format($finalTotal, 2) ?>)
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary - Right Side -->
        <div class="order-summary">
            <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Your Order</h2>
            
            <?php if (mysqli_num_rows($res) > 0): ?>
                <div class="order-items">
                    <?php
                    $user_id = $_SESSION['id'];
                    mysqli_data_seek($res, 0); // Reset result pointer
                    while ($row = mysqli_fetch_assoc($res)) {
                        $amount = $row['price'] * $row['product_quantity'];
                        ?>
                        <div class="order-item" data-id="<?php echo $row['card_id']; ?>">
                            <img src="../uploads/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="item-image">
                            <div class="item-details">
                                <div class="item-name"><?php echo $row['product_name']; ?></div>
                                <div class="item-price">₹<?php echo number_format($row['price'], 2); ?></div>
                                
                                <form action="./updateCart.php" method="post" class="item-quantity">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="number" name="product_quantity" min="1" value="<?php echo $row['product_quantity'] ?>" class="quantity-input">
                                    <button type="submit" name="updateCart" class="update-btn">Update</button>
                                </form>
                                
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <button type="submit" name="remove" class="remove-btn">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>₹<span id="cart-total"><?php echo number_format($totalAmount, 2); ?></span></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>₹<span id="shipping"><?php echo number_format($shippingCharge, 2); ?></span></span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total:</span>
                        <span>₹<span id="final-total"><?php echo number_format($finalTotal, 2); ?></span></span>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>Add some products to your cart to proceed with checkout</p>
                    <a href="dynamicproduct.php" class="payment-btn" style="display: inline-flex; text-decoration: none; margin-top: 1rem;">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>

 <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Handle form submission based on payment method
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', function(e) {
        if (document.querySelectorAll(".order-item").length === 0) {
            e.preventDefault();
            alert("Your cart is empty. Please add products before checkout.");
            return;
        }
        
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const submitBtn = document.getElementById('submitBtn');
        
        if (selectedMethod === 'cod') {
            e.preventDefault(); // Prevent default form submission
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing Order...';
            
            // Create a hidden form and submit to orderConfirmation.php
            const hiddenForm = document.createElement('form');
            hiddenForm.method = 'post';
            hiddenForm.action = 'orderConfirmation.php';
            
            // Copy all input values from the original form
            const inputs = paymentForm.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                const clone = input.cloneNode();
                if (input.type !== 'radio' || input.checked) {
                    hiddenForm.appendChild(clone);
                }
            });

            // Explicitly add payment method as COD
            const paymentInput = document.createElement('input');
            paymentInput.type = 'hidden';
            paymentInput.name = 'payment_method';
            paymentInput.value = 'cod';
            hiddenForm.appendChild(paymentInput);
            
            document.body.appendChild(hiddenForm);
            hiddenForm.submit();
        } else {
            // For Khalti, proceed normally to pay.php
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Payment...';
            paymentForm.action = 'pay.php';
        }
    });
});

 </script>
</body>
</html>