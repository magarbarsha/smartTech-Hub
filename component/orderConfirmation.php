<?php
session_start();
include '../includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Get user details
$user_id = $_SESSION['id'];
$selectQuery = "SELECT * FROM user WHERE id = $user_id";
$res = mysqli_query($conn, $selectQuery);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
}

// Get the most recent order from the orders1 table
$orderQuery = "SELECT * FROM orders1 WHERE user_id = $user_id ORDER BY ordered_date DESC LIMIT 1";
$orderRes = mysqli_query($conn, $orderQuery);

if (mysqli_num_rows($orderRes) > 0) {
    $order = mysqli_fetch_assoc($orderRes);
    $order_number = $order['order_number'];
    $order_status = $order['order_status'];
    $total_amount = $order['total_amount'];
    $total_items = $order['total_items'];
    $delivery_name = $order['delivery_name'];
    $delivery_email = $order['delivery_email'];
    $delivery_phone = $order['delivery_phone'];
    $delivery_address = $order['delivery_address'];
    $payment_method = $order['payment_method'];
    $shipped_date = $order['shipped_date'];
    $delivered_date = $order['delivered_date'];
    $transaction_id = $order['transaction_id'];
} else {
    // If no order is found, redirect to order history or home
    header('Location: orderHistory.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | SmartTech Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
       <style>
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3a0ca3;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --success-dark: #38b6db;
        --danger: #f72585;
        --warning: #f8961e;
        --info: #43aa8b;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --white: #ffffff;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 15px 25px rgba(0, 0, 0, 0.15);
        --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.2);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --border-radius: 12px;
        --border-radius-sm: 8px;
        --text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #f8fafc;
        color: var(--dark);
        line-height: 1.6;
        padding: 0;
        margin: 0;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .confirmation-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0;
        background-color: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .confirmation-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 8px;
        background: linear-gradient(90deg, var(--primary), var(--secondary), var(--success));
        z-index: 2;
    }

    .confirmation-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        padding: 3rem 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        text-shadow: var(--text-shadow);
    }

    .confirmation-header::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        filter: blur(10px);
    }

    .confirmation-header::after {
        content: "";
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        filter: blur(15px);
    }

    .confirmation-header h1 {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 1;
        font-weight: 700;
    }

    .confirmation-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .confirmation-icon {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
        color: var(--white);
        position: relative;
        z-index: 1;
        animation: bounce 1.5s ease infinite, pulse 2s ease infinite;
        filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.2));
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-20px);}
        60% {transform: translateY(-10px);}
    }

    @keyframes pulse {
        0% {transform: scale(1);}
        50% {transform: scale(1.05);}
        100% {transform: scale(1);}
    }

    .confirmation-body {
        padding: 2.5rem;
        position: relative;
    }

    .order-details, .shipping-details, .order-timeline {
        margin-bottom: 3rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        color: var(--primary-dark);
        font-size: 1.5rem;
        margin-bottom: 1.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light-gray);
        font-weight: 600;
    }

    .section-title i {
        margin-right: 0.75rem;
        font-size: 1.75rem;
        color: var(--primary);
    }

    .order-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .summary-card {
        background-color: var(--white);
        border-radius: var(--border-radius-sm);
        padding: 1.75rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-light);
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(67, 97, 238, 0.2);
    }

    .summary-card h3 {
        color: var(--gray);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }

    .summary-card p {
        font-size: 1.15rem;
        font-weight: 500;
        color: var(--dark);
        margin: 0;
        line-height: 1.4;
    }

    .highlight-card {
        grid-column: 1 / -1;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        border: none;
    }

    .highlight-card::before {
        background: rgba(255, 255, 255, 0.3);
    }

    .highlight-card h3 {
        color: rgba(255, 255, 255, 0.85);
    }

    .highlight-card p {
        color: var(--white);
        font-size: 1.75rem;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: var(--shadow-sm);
    }

    .status-badge i {
        margin-right: 0.5rem;
        font-size: 0.8rem;
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

    .btn-container {
        display: flex;
        gap: 1.25rem;
        margin-top: 2.5rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 1.75rem;
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        flex: 1;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }

    .btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
        opacity: 0;
        transition: var(--transition);
    }

    .btn:hover::after {
        opacity: 1;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline {
        background-color: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-outline:hover {
        background-color: var(--primary);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .btn i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
        margin: 2.5rem 0;
    }

    .timeline::before {
        content: "";
        position: absolute;
        left: 9px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary), var(--success));
        background-color: var(--light-gray);
    }

    .timeline-step {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-step:last-child {
        padding-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--primary);
        border: 4px solid var(--white);
        box-shadow: 0 0 0 2px var(--primary);
        z-index: 2;
    }

    .timeline-content {
        padding-left: 2rem;
        background: var(--white);
        border-radius: var(--border-radius-sm);
        padding: 1.25rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .timeline-content::before {
        content: "";
        position: absolute;
        left: -8px;
        top: 20px;
        width: 16px;
        height: 16px;
        background: var(--white);
        border-left: 1px solid rgba(0, 0, 0, 0.05);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transform: rotate(45deg);
    }

    .timeline-date {
        font-size: 0.85rem;
        color: var(--gray);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .timeline-date i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .timeline-text {
        font-weight: 500;
        font-size: 1.1rem;
    }

    .completed .timeline-icon {
        background-color: var(--success);
        box-shadow: 0 0 0 2px var(--success);
    }

    .current .timeline-icon {
        background-color: var(--white);
        box-shadow: 0 0 0 2px var(--primary);
        animation: pulse 1.5s infinite;
    }

    .footer-note {
        text-align: center;
        padding: 2rem;
        background-color: var(--light);
        border-top: 1px solid var(--light-gray);
        font-size: 0.95rem;
        color: var(--gray);
        line-height: 1.7;
    }

    .footer-note p {
        margin-bottom: 0.5rem;
    }

    .footer-note a {
        color: var(--primary-dark);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        border-bottom: 1px dotted var(--primary);
        padding-bottom: 1px;
    }

    .footer-note a:hover {
        color: var(--primary);
        border-bottom-style: solid;
    }

    /* Paper-like effect for the container */
    .confirmation-container {
        background: linear-gradient(to bottom right, var(--white) 0%, #f8f9fa 100%);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Subtle texture for cards */
    .summary-card, .timeline-content {
        background-image: 
            radial-gradient(circle at 1px 1px, rgba(0, 0, 0, 0.03) 1px, transparent 0);
        background-size: 10px 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .confirmation-container {
            margin: 0;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }
        
        .confirmation-header {
            padding: 2.5rem 1.5rem;
        }
        
        .confirmation-body {
            padding: 1.75rem;
        }
        
        .btn-container {
            flex-direction: column;
        }
        
        .order-summary {
            grid-template-columns: 1fr;
        }
        
        .summary-card[style*="grid-column"] {
            grid-column: auto !important;
        }
    }

    @media (max-width: 480px) {
        .confirmation-header h1 {
            font-size: 2rem;
        }
        
        .confirmation-header p {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
        
        .highlight-card p {
            font-size: 1.5rem;
        }
    }

    /* Floating animation for the header */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .confirmation-header {
        animation: float 6s ease-in-out infinite;
    }

    /* Ripple effect for buttons */
    .btn {
        position: relative;
        overflow: hidden;
    }

    .btn span {
        position: relative;
        z-index: 1;
    }

    .btn:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .btn:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    </style>
</head>

<body>
    <?php include './nav.php' ?>

    <div class="confirmation-container">
        <div class="confirmation-header">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase, <?php echo $name; ?>! Your order #<?php echo $order_number; ?> has been successfully placed and is being processed.</p>
        </div>

        <div class="confirmation-body">
            <div class="order-details">
                <h2 class="section-title">
                    <i class="fas fa-receipt"></i> Order Summary
                </h2>
                
                <div class="order-summary">
                    <div class="summary-card">
                        <h3>Order Number</h3>
                        <p>#<?php echo $order_number; ?></p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Order Status</h3>
                        <p>
                            <span class="status-badge status-<?php echo strtolower($order_status); ?>">
                                <?php echo $order_status; ?>
                            </span>
                        </p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Total Items</h3>
                        <p><?php echo $total_items; ?></p>
                    </div>
                    
                    <div class="summary-card highlight-card">
                        <h3>Total Amount</h3>
                        <p>₹<?php echo number_format($total_amount, 2); ?></p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Payment Method</h3>
                        <p><?php echo ucfirst($payment_method); ?></p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Transaction ID</h3>
                        <p><?php echo $transaction_id ? $transaction_id : 'N/A'; ?></p>
                    </div>
                </div>
            </div>

            <div class="shipping-details">
                <h2 class="section-title">
                    <i class="fas fa-truck"></i> Shipping Details
                </h2>
                
                <div class="order-summary">
                    <div class="summary-card">
                        <h3>Delivery Name</h3>
                        <p><?php echo $delivery_name; ?></p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Delivery Email</h3>
                        <p><?php echo $delivery_email; ?></p>
                    </div>
                    
                    <div class="summary-card">
                        <h3>Delivery Phone</h3>
                        <p><?php echo $delivery_phone; ?></p>
                    </div>
                    
                    <div class="summary-card" style="grid-column: span 2;">
                        <h3>Delivery Address</h3>
                        <p><?php echo nl2br($delivery_address); ?></p>
                    </div>
                </div>
            </div>

            <div class="order-timeline">
                <h2 class="section-title">
                    <i class="fas fa-history"></i> Order Timeline
                </h2>
                
                <div class="timeline">
                    <div class="timeline-step completed">
                        <div class="timeline-icon"></div>
                        <div class="timeline-content">
                            <div class="timeline-date"><?php echo date('F j, Y g:i a', strtotime($order['ordered_date'])); ?></div>
                            <div class="timeline-text">Order Placed</div>
                        </div>
                    </div>
                    
                    <div class="timeline-step <?php echo in_array($order_status, ['Processing', 'Shipped', 'Delivered']) ? 'completed' : 'current'; ?>">
                        <div class="timeline-icon"></div>
                        <div class="timeline-content">
                            <div class="timeline-date"><?php echo $order_status === 'Pending' ? 'Expected soon' : ($order['processed_date'] ? date('F j, Y g:i a', strtotime($order['processed_date'])) : 'In progress'); ?></div>
                            <div class="timeline-text">Order Processed</div>
                        </div>
                    </div>
                    
                    <div class="timeline-step <?php echo in_array($order_status, ['Shipped', 'Delivered']) ? 'completed' : ($order_status === 'Processing' ? 'current' : ''); ?>">
                        <div class="timeline-icon"></div>
                        <div class="timeline-content">
                            <div class="timeline-date"><?php echo $shipped_date ? date('F j, Y g:i a', strtotime($shipped_date)) : ($order_status === 'Shipped' ? 'Today' : 'Not shipped yet'); ?></div>
                            <div class="timeline-text">Order Shipped</div>
                        </div>
                    </div>
                    
                    <div class="timeline-step <?php echo $order_status === 'Delivered' ? 'completed' : ''; ?>">
                        <div class="timeline-icon"></div>
                        <div class="timeline-content">
                            <div class="timeline-date"><?php echo $delivered_date ? date('F j, Y g:i a', strtotime($delivered_date)) : 'Not delivered yet'; ?></div>
                            <div class="timeline-text">Order Delivered</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <a href="orderHistory.php" class="btn btn-primary">
                    <i class="fas fa-list"></i> View Order History
                </a>
                <a href="index.php" class="btn btn-outline">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>

        <div class="footer-note">
            <p>Need help? <a href="contact.php">Contact our support team</a> or call us at <a href="tel:9703080249">9703080249</a></p>
            <p>A confirmation email has been sent to <?php echo $email; ?></p>
        </div>
    </div>
<?php include './footer.php' ?>
</body>

</html>