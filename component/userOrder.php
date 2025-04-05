<?php
session_start();
include '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../assets/css/orders.css">
</head>
<body>
    <?php include './nav.php' ?>
    
    <div class="dashboard-container">
        <div class="page-header">
            <h1><i class="fas fa-clipboard-list"></i> My Orders</h1>
            <div class="search-filter">
                <div class="search-box">
                    <input type="text" id="orderSearch" placeholder="Search orders...">
                    <i class="fas fa-search"></i>
                </div>
                <select id="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="packed">Packed</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
        </div>

        <div class="dashboard-content">
            <?php 
            $sql = "SELECT * FROM orders1 WHERE user_id = ? ORDER BY ordered_date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $num = $res->num_rows;
            
            if($num > 0): ?>
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Delivery Info</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $res->fetch_assoc()): 
                            // Set default values if array keys don't exist
                            $order_id = $row['order_id'] ?? 0;
                            $order_number = $row['order_number'] ?? 'N/A';
                            $delivery_address = $row['delivery_address'] ?? 'Not specified';
                            $delivery_phone = $row['delivery_phone'] ?? 'Not provided';
                            $delivery_email = $row['delivery_email'] ?? 'Not provided';
                            $total_amount = $row['total_amount'] ?? 0;
                            $ordered_date = $row['ordered_date'] ?? date('Y-m-d H:i:s');
                            $order_status = $row['order_status'] ?? 'pending';
                        ?>
                        <tr data-status="<?php echo strtolower($order_status); ?>">
                            <td>
                                <div class="order-number">
                                    <a href="order_details.php?id=<?php echo $order_id; ?>" class="order-link">
                                        #<?php echo htmlspecialchars($order_number); ?>
                                    </a>
                                    <small class="text-muted">ID: <?php echo $order_id; ?></small>
                                </div>
                            </td>
                            <td>
                                <div class="delivery-info">
                                    <div><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($delivery_address); ?></div>
                                    <div><i class="fas fa-phone"></i> <?php echo htmlspecialchars($delivery_phone); ?></div>
                                    <div><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($delivery_email); ?></div>
                                </div>
                            </td>
                            <td class="amount-cell">
                                <span class="badge bg-light text-dark">$<?php echo number_format($total_amount, 2); ?></span>
                            </td>
                            <td>
                                <?php 
                                $date = new DateTime($ordered_date);
                                echo $date->format('M d, Y'); 
                                ?>
                                <br>
                                <small><?php echo $date->format('h:i A'); ?></small>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($order_status); ?>">
                                    <?php echo ucfirst($order_status); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="order_details.php?id=<?php echo $order_id; ?>" class="btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if($order_status != 'delivered'): ?>
                                    <a href="#" class="btn-track" title="Track Order">
                                        <i class="fas fa-truck"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="#" class="btn-print" title="Print Invoice">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="order-stats">
                <?php
                function getOrderCount($conn, $user_id, $status) {
                    $sql = "SELECT COUNT(*) as count FROM orders1 WHERE user_id = ? AND order_status = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("is", $user_id, $status);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    return $result->fetch_assoc()['count'] ?? 0;
                }
                ?>
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo getOrderCount($conn, $user_id, 'pending'); ?></h3>
                        <p>Pending</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon packed">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo getOrderCount($conn, $user_id, 'packed'); ?></h3>
                        <p>Packed</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon shipped">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo getOrderCount($conn, $user_id, 'shipped'); ?></h3>
                        <p>Shipped</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon delivered">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo getOrderCount($conn, $user_id, 'delivered'); ?></h3>
                        <p>Delivered</p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="no-orders">
                <div class="no-orders-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>No Orders Found</h3>
                <p>You haven't placed any orders yet. Start shopping now!</p>
                <a href="../shop.php" class="btn btn-primary">Go to Shop</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard_script.js"></script>
    <script>
    $(document).ready(function() {
        $('#orderSearch').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('.order-table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        $('#statusFilter').change(function() {
            const status = $(this).val().toLowerCase();
            if(status === '') {
                $('.order-table tbody tr').show();
            } else {
                $('.order-table tbody tr').each(function() {
                    $(this).toggle($(this).data('status') === status);
                });
            }
        });
    });
    </script>
    <?php include "footer.php" ?>
</body>
</html>v