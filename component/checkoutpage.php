<?php
session_start();
include '../includes/config.php';
$selectQuery = "SELECT * FROM `user` WHERE id = $_SESSION[id]";
$res = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
    $payment_method = $row['payment_method'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout and Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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

        li {
            list-style-type: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        } ?>
        <!-- Checkout Form -->
        <div class="form-wrapper">
            <h2>Checkout Page</h2>
            <form action="orderProcess.php" method="post">
                <div class="input-group">
                    <input type="text" name="name" value="<?php echo $name ?>" placeholder="Your Name">
                </div>
                <div class="input-group">
                    <input type="email" name="email" value="<?php echo $email ?>" placeholder="Your Email">
                </div>
                <div class="input-group">
                    <input type="number" name="phone" value="<?php echo $phone ?>" placeholder="Your Phone">
                </div>
                <div class="input-group">
                    <input type="text" name="address" value="<?php echo $address ?>" placeholder="Your address">
                </div>
                <!-- <label>COD:
                    <input type="radio" name="payment_method" value="COD">
</label> -->
                <label>Pay With:

    <input type="submit" value="pay with khalti" name="pay with khalti">
  </li>
                        <li>
                            <label>COD:
                                <input type="radio" name="payment_method" value="COD">
                            </label>
                        </li>
                    </ul>
                </label>
                <div class="button-container">
                    <button type="submit" name="confirm" class="register-btn confirm-btn">Confirm Order</button>
                    <button type="reset" class="register-btn reset-btn">Reset</button>
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
                    $totalAmount = 0;
                    $shippingCharge = 100;
                    $sql = "SELECT *, card_tbl.id AS card_id, prod.id AS product_id FROM card_tbl 
                            INNER JOIN prod ON card_tbl.product_id=prod.id WHERE user_id=$user_id";
                    $res = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($res);

                    if ($num > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $amount = $row['price'] * $row['quantity'];
                            $totalAmount += $amount;
                            ?>
                            <tr data-id="<?php echo $row['card_id']; ?>" data-price="<?php echo $row['price']; ?>">
                                <td><?php echo ++$counter; ?></td>
                                <td>
                                    <img src="../uploads/<?php echo $row['product_image']; ?>" alt="Product">
                                    <p><?php echo $row['product_name']; ?></p>
                                </td>
                                <td>₹<?php echo number_format($row['price'], 2); ?></td>
                                <td class="quantity-control">
                                    <button class="quantity-btn decrease">-</button>
                                    <input type="number" class="quantity-input" value="<?php echo $row['quantity']; ?>" min="1">
                                    <button class="quantity-btn increase">+</button>
                                </td>
                                <td class="total-price">₹<?php echo number_format($amount, 2); ?></td>
                                <td><button class="remove-btn">❌</button></td>
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
                <div>Shipping Charges: ₹<span id="shipping"><?php echo number_format($shippingCharge, 2); ?></span>
                </div>
                <div class="total-amount">Total Amount: ₹<span
                        id="final-total"><?php echo number_format($totalAmount + $shippingCharge, 2); ?></span></div>
                <button class="proceed-btn">Proceed to Checkout</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cartItems = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");
            const finalTotal = document.getElementById("final-total");
            const shippingCharge = parseFloat(document.getElementById("shipping").innerText);

            function updateTotals() {
                let total = 0;
                document.querySelectorAll(".total-price").forEach(item => {
                    total += parseFloat(item.innerText.replace("₹", ""));
                });

                cartTotal.innerText = total.toFixed(2);
                finalTotal.innerText = (total + shippingCharge).toFixed(2);
            }

            cartItems.addEventListener("click", function (event) {
                const target = event.target;
                const row = target.closest("tr");
                if (!row) return;

                let quantityElem = row.querySelector(".quantity-input");
                let totalPriceElem = row.querySelector(".total-price");
                let price = parseFloat(row.dataset.price);
                let quantity = parseInt(quantityElem.value);

                if (target.classList.contains("increase")) quantity++;
                else if (target.classList.contains("decrease") && quantity > 1) quantity--;

                quantityElem.value = quantity;
                totalPriceElem.innerText = `₹${(quantity * price).toFixed(2)}`;
                updateTotals();
            });

            document.querySelectorAll(".quantity-input").forEach(input => {
                input.addEventListener("change", updateTotals);
            });

            updateTotals();
        });
    </script>
</body>

</html>