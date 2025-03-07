<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   
</head>
<body>
<div class="top-navbar">
        <div class="social-icons">
            <a href="https://www.facebook.com" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.twitter.com" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.instagram.com" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
        <div class="auth-links">
            <a href="signin.php">Sign In</a> |
            <a href="signup.php">Sign Up</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <!-- Navbar Section -->
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <div class="logo">
                <!-- <img src="smarttech-logo.png" alt="SmartTech Hub Logo"> -->
                <i class="fa-solid fa-laptop-code" style="font-size: 2em; color: #007bff;"></i>  <span>SmartTech Hub</span>
            </div>

            <div class="search-bar" role="search">
                <select class="category" aria-label="Product Categories">
                    <option>All Categories</option>
                    <option><a href="laptops.php">Laptops</a></option>
                    <option>Accessories</option>
                    <option>Smartphones</option>
                </select>
                <input type="text" placeholder="Search for products, categories..." aria-label="Search">
                <button class="search-btn" aria-label="Search Button"><i class="fas fa-search"></i></button>
            </div>

            <div class="nav-icons">
                <a href="../login.php" aria-label="User Account"><i class="fa-regular fa-user"></i></a>
                <a href="#" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></a>
                <a href="checkoutpage.php" aria-label="Shopping Cart"><i class="fa-solid fa-cart-shopping"></i></a>
                <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
            </div>
        </nav>

        <div class="menu">
            <ul>
                <li><a href="index2.php">HOME</a></li>
                <li class="dropdown">
                <a href="dynamicproduct.php" class="dropdown-toggle">PRODUCTS</a>
                
            </li>
                <li><a href="laptops.php">GAMING LAPTOPS</a></li>
                <li><a href="#">NEW ARRIVALS</a></li>
                <li><a href="comingsoon.php">COMING SOON</a></li>
                <li><a href="aboutus.php">ABOUT US</a></li>
                <li><a href="contact.php">CONTACT US</a></li>
            </ul>
        </div>
    </header>
</body>
</html>
