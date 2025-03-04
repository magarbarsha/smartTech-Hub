<?php
session_start();
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
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
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #343a40;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: 600;
        }

        td img {
            width: 60px;
            height: 80px;
            border-radius: 5px;
            object-fit: cover;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-top:20px;
        }

        .quantity-btn {
            background-color: #f8b400;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            transition: 0.3s;
        }

        .quantity-btn:hover {
            background-color: #e0a800;
        }

        .quantity-input {
            width: 45px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            padding: 5px;
            height: 32px;
        }

        .remove-btn {
            background: none;
            border: none;
            color: red;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .remove-btn:hover {
            color: darkred;
        }

        .summary {
            margin-top: 20px;
            text-align: left;
            font-size: 16px;
            font-weight: 500;
        }

        .summary div {
            margin-bottom: 10px;
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
            transition: 0.3s;
            display: inline-block;
            margin-top: 15px;
        }

        .proceed-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
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
                                <!-- <button class="quantity-btn decrease">-</button>
                                <input type="number" class="quantity-input" value="<?php echo $row['quantity']; ?>" min="1">
                                <button class="quantity-btn increase">+</button> -->
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="number"name="product_quantity" min=1 value="<?php echo $row['product_quantity'] ?>">
                                    <input type="submit" name="updateCart" value="update">
                              </form>
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

        <!-- Cart Summary -->
        <div class="summary">
            <div>Cart Total: ₹<span id="cart-total"><?php echo number_format($totalAmount, 2); ?></span></div>
            <div>Shipping Charges: ₹<span id="shipping"><?php echo number_format($shippingCharge, 2); ?></span></div>
            <div class="total-amount">Total Amount: ₹<span id="final-total"><?php echo number_format($totalAmount + $shippingCharge, 2); ?></span></div>
            <button class="proceed-btn"><a href="checkoutpage.php">Proceed to Checkout</a></button>
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
