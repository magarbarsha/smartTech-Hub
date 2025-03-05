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
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout and Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            padding: 20px;
            gap: 20px;
        }

        .container {
            width: 100%;
            display: flex;
            gap: 20px;
        }

        .form-wrapper,
        .order-wrapper {
            width: 50%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-wrapper h2,
        .order-wrapper h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .input-group label {
            position: absolute;
            top: 5px;
            left: 15px;
            font-size: 14px;
            color: #888;
        }

        .gender-selection {
            margin-bottom: 20px;
        }

        .gender-options input {
            margin-right: 10px;
        }

        .register-btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .register-btn:hover {
            background-color: #218838;
        }

        /* Orders Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #343a40;
            color: white;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quantity-btn {
            background-color: #f8b400;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        .quantity-btn:hover {
            background-color: #e0a800;
        }

        .remove-btn {
            background: none;
            border: none;
            color: red;
            font-size: 18px;
            cursor: pointer;
        }

        .summary {
            margin-top: 20px;
            text-align: left;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .proceed-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .proceed-btn:hover {
            background-color: #218838;
        }

        /* Container for buttons */
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .register-btn {
            width: 48%;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-align: center;
        }

        .confirm-btn {
            background-color: #28a745;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #218838;
        }

        .reset-btn {
            background-color: #f44336;
            color: white;
        }

        .reset-btn:hover {
            background-color: #e53935;
        }
        
    </style>
</head>

<body>
    <div class="container">
        <!-- Checkout Form -->
        <div class="form-wrapper">
            <h2>Checkout page</h2>
            <form action="" method="post">
                <div class="input-group">
                    <input type="text" name="name" id="name" value="<?php echo $name ?>" placeholder="Your Name" required>
                    <label for="name">Username</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" id="email" value="<?php echo $email ?>" placeholder="Your Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="number" name="phone" id="phone" value="<?php echo $phone ?>" placeholder="Your Phone" required>
                    <label for="phone">Phone</label>
                </div>

            
                </div>
                <div class="button-container">
                    <!-- Confirm Order Button (Left) -->
                    <button type="submit" name="register" class="register-btn confirm-btn">Confirm Order</button>

                    <!-- Reset Button (Right) -->
                    <button type="reset" class="register-btn reset-btn">Reset</button>
                </div>
            </form>
        </div>

        <!-- My Orders Table -->
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