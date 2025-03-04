<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

 
   <?php include './adminsidenav.php' ?>

    <!-- Dashboard Content Section (Cards) -->
    <div class="dashboard-content">
        <h3 style="font-size: 30px;">Dashboard</h3>
        <hr>
        <div class="card-container">
            <div class="card">
                <h3>Total Sales</h3>
                <p class="amount">$35,000</p>
                <i class="fa-solid fa-dollar-sign"></i>
            </div>

            <div class="card">
                <h3>Products Sold</h3>
                <p class="amount">1,250</p>
                <i class="fa-solid fa-box"></i>
            </div>

            <div class="card">
                <h3>Orders Pending</h3>
                <p class="amount">300</p>
                <i class="fa-solid fa-cart-arrow-down"></i>
            </div>

            <div class="card">
                <h3>Feedbacks</h3>
                <p class="amount">150</p>
                <i class="fa-regular fa-comments"></i>
            </div>
            <div class="card">
        <h3>Total Revenue</h3>
        <p class="amount">$45,000</p>
        <i class="fa-solid fa-money-bill-wave"></i>
    </div>
    <div class="card">
        <h3>Cart Abandonments</h3>
        <p class="amount">120</p>
        <i class="fa-solid fa-shopping-cart"></i>
    </div>
    <div class="card">
        <h3>Active Promotions</h3>
        <p class="amount">3</p>
        <i class="fa-solid fa-tag"></i>
    </div>

    <div class="card">
        <h3>New Reviews</h3>
        <p class="amount">200</p>
        <i class="fa-regular fa-star"></i>
    </div>
    <div class="card">
        <h3>Shipped Orders</h3>
        <p class="amount">1,800</p>
        <i class="fa-solid fa-shipping-fast"></i>
    </div>

    <div class="card">
        <h3>Returned Products</h3>
        <p class="amount">50</p>
        <i class="fa-solid fa-undo-alt"></i>
    </div>
    <div class="card">
        <h3>Total Customers</h3>
        <p class="amount">1,000</p>
        <i class="fa-solid fa-users"></i>
    </div>

    <div class="card">
        <h3>Total Orders</h3>
        <p class="amount">2,500</p>
        <i class="fa-solid fa-box-open"></i>
    </div>
            <!-- More cards can be added here -->
        </div>
        <?php
            if(isset($_REQUEST['msg'])){
                echo $_REQUEST['msg'];
            }
            ?>
    </div>

    <script src="../assets/js/dashboard_script.js"></script>
        

</body>
</html>
