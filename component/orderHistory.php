<?php
session_start();
include '../includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    echo "User is not logged in.";
    exit();
}

// Get user ID from session
$user_id = mysqli_real_escape_string($conn, $_SESSION['id']);

// Fetch user name (optional)
$selectQuery = "SELECT name FROM user WHERE id = $user_id";
$res = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($res) > 0) {
    $user = mysqli_fetch_assoc($res);
    $name = $user['name'];
}

// Get orders for the user from 'orders1' table
$ordersQuery = "SELECT * FROM orders1 WHERE user_id = '$user_id' ORDER BY ordered_date DESC";
$ordersRes = mysqli_query($conn, $ordersQuery);

// Check for query errors
if (!$ordersRes) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | SmartTech Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #43aa8b;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding-bottom: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .order-card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--light-gray);
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background-color: var(--light);
            border-bottom: 1px solid var(--light-gray);
        }

        .order-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .order-info-item {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }

        .order-info-item h3 {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .order-info-item p {
            font-weight: 500;
            color: var(--dark);
        }

        .order-number {
            font-weight: 600;
            color: var(--primary);
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-shipped {
            background-color: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-body {
            padding: 1.5rem;
        }

        .order-products {
            width: 100%;
            border-collapse: collapse;
        }

        .order-products th {
            text-align: left;
            padding: 0.75rem;
            background-color: var(--light);
            color: var(--gray);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .order-products td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid var(--light-gray);
        }

        .product-name {
            font-weight: 500;
        }

        .product-price {
            color: var(--primary);
            font-weight: 600;
        }

        .order-total {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            background-color: var(--light);
            border-top: 1px solid var(--light-gray);
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }

        .order-actions {
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--light-gray);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 0;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin: 2rem 0;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--light-gray);
            margin-bottom: 1.5rem;
        }

        .empty-text {
            font-size: 1.25rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .order-info {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .order-info-item {
                min-width: 100%;
            }

            .order-products th {
                display: none;
            }

            .order-products tr {
                display: flex;
                flex-direction: column;
                padding: 1rem 0;
                border-bottom: 1px solid var(--light-gray);
            }

            .order-products td {
                padding: 0.25rem 0;
                border: none;
                display: flex;
                justify-content: space-between;
            }

            .order-products td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
                margin-right: 1rem;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .order-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .order-actions .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1>Your Order History</h1>
                <p>View all your past orders with SmartTech Hub</p>
            </div>

            <?php if (mysqli_num_rows($ordersRes) > 0): ?>
                <?php while ($order = mysqli_fetch_assoc($ordersRes)): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <div class="order-info-item">
                                    <h3>Order Number</h3>
                                    <p class="order-number">#<?php echo $order['order_number']; ?></p>
                                </div>
                                <div class="order-info-item">
                                    <h3>Date Placed</h3>
                                    <p><?php echo date('F j, Y', strtotime($order['ordered_date'])); ?></p>
                                </div>
                                <div class="order-info-item">
                                    <h3>Total</h3>
                                    <p>₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                </div>
                                <div class="order-info-item">
                                    <h3>Status</h3>
                                    <p>
                                        <span class="status-badge status-<?php echo strtolower($order['order_status']); ?>">
                                            <?php echo $order['order_status']; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="order-body">
                            <table class="order-products">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Get order items for this order
                                    $order_id = $order['id'];
                                    $itemsQuery = "SELECT oi.*, p.product_name, p.product_image FROM order_items oi 
                                                    JOIN prod p ON oi.product_id = p.id 
                                                    WHERE oi.order_id = $order_id";
                                    $itemsRes = mysqli_query($conn, $itemsQuery);
                                    
                                    while ($item = mysqli_fetch_assoc($itemsRes)): ?>
                                        <tr>
                                            <td data-label="Product">
                                                <div class="product-info">
                                                    <img src="../admin/uploads/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" class="product-image">
                                                    <span class="product-name"><?php echo $item['product_name']; ?></span>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="product-price">₹<?php echo number_format($item['price'], 2); ?></td>
                                            <td data-label="Quantity"><?php echo $item['quantity']; ?></td>
                                            <td data-label="Subtotal" class="product-price">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="order-total">
                            <div class="total-amount">
                                Total: ₹<?php echo number_format($order['total_amount'], 2); ?>
                            </div>
                        </div>

                        <div class="order-actions">
                            <a href="orderDetails.php?order_id=<?php echo $order['id']; ?>" class="btn btn-outline">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <?php if ($order['order_status'] === 'Delivered'): ?>
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-redo"></i> Reorder
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="empty-text">You haven't placed any orders yet</h3>
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>