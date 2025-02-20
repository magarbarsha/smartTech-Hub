<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="navbar">
    <i class="fa-solid fa-bars toggle-sidebar"></i>
        <div style="display: flex; align-items: center;">
            <p>Barsha Magar</p>
            <i class="fa-regular fa-user"></i>
        </div>
       
    </div>

    <!-- Sidebar Section -->
    <div class="sidebar">
        <span class="toggle-btn" onclick="toggleSidebar()">&times;</span>
        <p>Admin Panel</p>
        <div class="links">
            <a href="#"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="categorydisplay.php"><i class="fa-solid fa-box"></i> Add category</a>
            <a href="productAdd.php"><i class="fa-regular fa-user"></i> Product Management</a>
            <a href="#"><i class="fa-solid fa-cart-arrow-down"></i> Order Management</a>
            <a href="#"><i class="fa-solid fa-chart-line"></i> Sales</a>
            <a href="#"><i class="fa-regular fa-comments"></i> Feedback</a>
            <a href="#"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
    
</body>
</html>