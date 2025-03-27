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
    <link rel="stylesheet" href="../assets/css/cartView.css">
    <style>
        .orders-title {
    font-size: 28px;
    font-weight: bold;
    text-transform: uppercase;
    background: linear-gradient(45deg, #ff8c00, #ff0080);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
    padding: 10px;
    border-bottom: 3px solid #007bff;
    display: inline-block;
    /* position: relative;
    top:20px;
} */
        }

.orders-title::after {
    content: "";
    position: relative;
    top:100px;
    left: 50%;
    bottom: -6px;
    width: 50px;
    height: 4px;
    background-color: #007bff;
    transform: translateX(-50%);
   
    border-radius: 2px;
}



        </style>
</head>

<body>
    <?php
    include 'nav.php';
    ?>
    <div class="container">
        <h3 class="orders-title">My Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                    <th>removable</th>
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
                        $amount = $row['price'] * $row['product_quantity'];

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
                                    <input type="number" name="product_quantity" min=1
                                        value="<?php echo $row['product_quantity'] ?>">
                                    <input type="submit" name="updateCart" value="update">
                                </form>
                            </td>

                            <!-- <td class="total-price">₹<?php echo number_format($amount, 2); ?></td>
                            <td><button class="remove-btn">❌</button></td>
                        </tr> -->
                            <td class="total-price">
                                <?php

                                echo "₹" . number_format($amount, 2);
                                ?>
                            </td>
                            <td>
                            <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="submit" name="remove" value="remove">
                                </form>
                            </td>
<td>
<form action="./updateCart.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                    <input type="submit" name="removeall" value="removeall">
                                </form>
                            </td>
</td>
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
            <div class="total-amount">Total Amount: ₹<span
                    id="final-total"><?php echo number_format($totalAmount + $shippingCharge, 2); ?></span></div>
            <button class="proceed-btn"><a href="checkoutpage.php">Proceed to Checkout</a></button>
        </div>
    </div>
<?php
include 'footer.php';
?>
    <!-- <script>
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
    </script> -->
</body>

</html>