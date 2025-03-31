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
    <title>Checkout and Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <link rel="stylesheet" href="../assets/css/checkoutpage.css">
    <style>
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c62828;
        }
        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #2e7d32;
        }
        li { list-style-type: none; }
    </style>
</head>

<body>
    <div class="container">
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        } 
        ?>
        
        <!-- Checkout Form -->
        <div class="form-wrapper">
            <h2>Checkout Page</h2>
            <form action="pay.php" method="post" id="paymentForm">
                <div class="input-group">
                    <input type="text" name="name" value="<?php echo $name ?>" placeholder="Your Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" value="<?php echo $email ?>" placeholder="Your Email" required>
                </div>
                <div class="input-group">
                    <input type="number" name="phone" value="<?php echo $phone ?>" placeholder="Your Phone" required>
                </div>
                <div class="input-group">
                    <input type="text" name="address" value="<?php echo $address ?>" placeholder="Your address" required>
                </div>
                
                <input type="hidden" name="amount" value="<?php echo $finalTotal ?>">
                <input type="hidden" name="purchase_order_id" value="<?php echo uniqid() ?>">
                <input type="hidden" name="purchase_order_name" value="Order from <?php echo $name ?>">
                
                <div>
                    <h3>Pay with</h3>
                    <ul>
                        <li>
                            <button type="submit" name="submit" class="khalti-btn">Pay with Khalti</button>
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="order-wrapper">
            <h3>My Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                <?php
                $user_id = $_SESSION['id'];
                $counter = 0;
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $amount = $row['price'] * $row['product_quantity'];
                        ?>
                        <tr data-id="<?php echo $row['card_id']; ?>" data-price="<?php echo $row['price']; ?>">
                            <td><?php echo ++$counter; ?></td>
                            <td>
                                <img src="../uploads/<?php echo $row['product_image']; ?>" alt="Product">
                                <p><?php echo $row['product_name']; ?></p>
                            </td>
                            <td>₹<?php echo number_format($row['price'], 2); ?></td>
                            <td class="quantity-control">
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="number" name="product_quantity" min=1 value="<?php echo $row['product_quantity'] ?>">
                                    <input type="submit" name="updateCart" value="update">
                                </form>
                            </td>
                            <td class="total-price">₹<?php echo number_format($amount, 2); ?></td>
                            <td>
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="submit" name="remove" value="remove">
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
            <div class="summary">
                <div>Cart Total: ₹<span id="cart-total"><?php echo number_format($totalAmount, 2); ?></span></div>
                <div>Shipping Charges: ₹<span id="shipping"><?php echo number_format($shippingCharge, 2); ?></span></div>
                <div class="total-amount">Total Amount: ₹<span id="final-total"><?php echo number_format($finalTotal, 2); ?></span></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Update totals when quantity changes
            function updateTotals() {
                let total = 0;
                document.querySelectorAll(".total-price").forEach(item => {
                    total += parseFloat(item.innerText.replace("₹", ""));
                });
                document.getElementById("cart-total").innerText = total.toFixed(2);
                const shipping = parseFloat(document.getElementById("shipping").innerText);
                document.getElementById("final-total").innerText = (total + shipping).toFixed(2);
                document.querySelector("input[name='amount']").value = (total + shipping) * 100;
            }
            
            // Initialize totals
            updateTotals();
        });
    </script>
</body>
</html>
