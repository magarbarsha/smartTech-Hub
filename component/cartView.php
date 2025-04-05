<?php
session_start();
include '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | SmartTech Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            padding: 0 20px;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border-radius: 2px;
        }

        /* Orders Table */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .orders-table th {
            background-color: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .orders-table tr:hover {
            background-color: #f8f9fa;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-cell img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .product-name {
            font-weight: 500;
        }

        /* Quantity Controls */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control input[type="number"] {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }

        .update-btn {
            padding: 8px 15px;
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

        /* Action Buttons */
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .remove-btn {
            background: var(--danger);
            color: white;
        }

        .remove-btn:hover {
            background: #c82333;
        }

        .remove-all-btn {
            background: var(--dark);
            color: white;
        }

        .remove-all-btn:hover {
            background: #23272b;
        }

        /* Order Summary */
        .summary-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            margin-top: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .total-amount {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            padding-top: 10px;
            border-top: 1px solid #ddd;
            margin-top: 10px;
        }

        .proceed-btn {
            width: 100%;
            padding: 12px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .proceed-btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .proceed-btn a {
            color: white;
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .empty-text {
            font-size: 1.2rem;
            color: var(--secondary);
            margin-bottom: 1.5rem;
        }

        .shop-btn {
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .shop-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .orders-table {
                display: block;
                overflow-x: auto;
            }
            
            .product-cell {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .product-cell img {
                width: 60px;
                height: 60px;
            }
            
            .quantity-control {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .action-btn {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-clipboard-list"></i> My Orders</h1>
        </div>

        <?php
        $user_id = $_SESSION['id'];
        $counter = 0;
        $totalAmount = 0;
        $shippingCharge = 100;
        $sql = "SELECT *, card_tbl.id AS card_id, prod.id AS product_id FROM card_tbl 
                INNER JOIN prod ON card_tbl.product_id=prod.id WHERE user_id=$user_id";
        $res = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($res);

        if ($num > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                        <th>Clear All</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php while ($row = mysqli_fetch_assoc($res)):
                        $amount = $row['price'] * $row['product_quantity'];
                        $totalAmount += $amount;
                    ?>
                        <tr data-id="<?php echo $row['card_id']; ?>" data-price="<?php echo $row['price']; ?>">
                            <td><?php echo ++$counter; ?></td>
                            <td>
                                <div class="product-cell">
                                    <img src="../uploads/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                    <span class="product-name"><?php echo $row['product_name']; ?></span>
                                </div>
                            </td>
                            <td>₹<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <form action="./updateCart.php" method="post" class="quantity-control">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <input type="number" name="product_quantity" min="1" value="<?php echo $row['product_quantity'] ?>">
                                    <button type="submit" name="updateCart" class="update-btn">Update</button>
                                </form>
                            </td>
                            <td>₹<?php echo number_format($amount, 2); ?></td>
                            <td>
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="card_id" value="<?php echo $row['card_id'] ?>">
                                    <button type="submit" name="remove" class="action-btn remove-btn">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="./updateCart.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                    <button type="submit" name="removeall" class="action-btn remove-all-btn">
                                        <i class="fas fa-broom"></i> Clear All
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="summary-card">
                <div class="summary-row">
                    <span>Cart Total:</span>
                    <span>₹<span id="cart-total"><?php echo number_format($totalAmount, 2); ?></span></span>
                </div>
                <div class="summary-row">
                    <span>Shipping Charges:</span>
                    <span>₹<span id="shipping"><?php echo number_format($shippingCharge, 2); ?></span></span>
                </div>
                <div class="summary-row total-amount">
                    <span>Total Amount:</span>
                    <span>₹<span id="final-total"><?php echo number_format($totalAmount + $shippingCharge, 2); ?></span></span>
                </div>
                <button class="proceed-btn">
                    <i class="fas fa-credit-card"></i>
                    <a href="checkoutpage.php">Proceed to Checkout</a>
                </button>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="empty-text">Your order list is empty</h3>
                <a href="dynamicproduct.php" class="shop-btn">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'footer.php'; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
            // Update totals when quantity changes
            function updateTotals() {
                let total = 0;
                document.querySelectorAll("tbody tr").forEach(row => {
                    const price = parseFloat(row.querySelector("td:nth-child(3)").innerText.replace("₹", "").replace(",", ""));
                    const quantity = parseInt(row.querySelector("input[type='number']").value);
                    const itemTotal = price * quantity;
                    row.querySelector("td:nth-child(5)").innerText = "₹" + itemTotal.toFixed(2);
                    total += itemTotal;
                });
                
                document.getElementById("cart-total").innerText = total.toFixed(2);
                const shipping = parseFloat(document.getElementById("shipping").innerText);
                document.getElementById("final-total").innerText = (total + shipping).toFixed(2);
            }
            
            // Initialize totals
            updateTotals();
            
            // Add event listeners for quantity changes
            document.querySelectorAll("input[type='number']").forEach(input => {
                input.addEventListener("change", updateTotals);
            });
        });
    </script>
</body>
</html>