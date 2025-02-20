<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
    <!-- <link rel="stylesheet" href="../assets/css/navbar2.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
    width: 100%;
    height: 100vh;
    margin: 0;
    background-color: #f0f4f8;
}


/* Top Navbar */
.top-navbar {
    background-color: #007bff;
    color: white;
    padding: 5px 20px;
    text-align: center;
    font-size: 14px;
}

.top-navbar .social-icons a {
    color: white;
    margin: 0 10px;
    font-size: 18px;
    transition: color 0.3s;
}

.top-navbar .social-icons a:hover {
    color: #ff9900;
}

/* Navbar */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    padding: 15px 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.logo {
    display: flex;
    align-items: center;
}

.logo img {
    height: 40px;
    margin-right: 12px;
}

.logo span {
    font-size: 22px;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
}

/* Navbar Links and Search */
.search-bar {
    display: flex;
    align-items: center;
    border-radius: 25px;
    overflow: hidden;
    background-color: #f1f1f1;
}

.search-bar select,
.search-bar input,
.search-bar .search-btn {
    padding: 8px;
    border: none;
    outline: none;
    border-radius: 25px;
}

.search-bar select {
    background: #f8f8f8;
}

.search-bar input {
    width: 250px;
    border-left: 1px solid #ccc;
}

.search-btn {
    background: #007bff;
    color: white;
    cursor: pointer;
    border-left: 1px solid #ccc;
    border-radius: 0 25px 25px 0;
}

.nav-icons a {
    color: #333;
    text-decoration: none;
    font-size: 18px;
    margin: 0 12px;
    transition: color 0.3s;
}

.nav-icons a:hover {
    color: #007bff;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
}

/* Product Dropdown */
.product {
    position: relative;
    display: inline-block;
}

.product-button {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    cursor: pointer;
    font-size: 18px;
    border-radius: 5px;
}

.product-name {
    display: none;
    position: absolute;
    background-color: rgb(52, 101, 152);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
}

.product-name a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    transition: background 0.3s;
}

.product-name a:hover {
    background-color: #ddd;
}

/* Hero Section Styles */
.slide-container {
    position: relative;
    width: 100%;
    height: 80vh;
    overflow: hidden;
}

.slides {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 1s ease-in-out;
}

.slides img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    font-size: 2rem;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

/* Hero Content - Centered */
.hero-content {
position: absolute;
bottom: 30px;
left: 50%;
transform: translateX(-50%);
color: white;
text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
text-align: center; /* Center text */
}

.hero-content h1 {
font-size: 3rem;
font-weight: bold;
margin-bottom: 15px;
}

.hero-content p {
font-size: 1.2rem;
margin-bottom: 20px;
}

.hero-btn {
background-color: #ff9900;
color: white;
padding: 12px 20px;
border: none;
border-radius: 25px;
font-size: 1.2rem;
cursor: pointer;
text-decoration: none;
transition: background 0.3s ease;
}

.hero-btn:hover {
background-color: #e68900;
}


/* Menu */
.menu {
    background: #007bff;
    padding: 10px;
    text-align: center;
}

.menu ul {
    list-style: none;
    display: flex;
    justify-content: center;
}

.menu ul li {
    margin: 0 20px;
}

.menu ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    display: block;
    transition: background 0.3s;
}

.menu ul li a:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-bar {
        display: none;
    }

    .menu ul {
        display: none;
        flex-direction: column;
        background: #007bff;
        padding: 10px;
        position: absolute;
        width: 100%;
        left: 0;
        top: 60px;
    }

    .menu ul.show {
        display: flex;
    }

    .menu ul li {
        display: block;
        padding: 10px 0;
    }

    .menu-toggle {
        display: block;
    }
}

/* Today's Deals and Offers Section */
.deals-section {
    padding: 40px 20px;
    background-color: #ffffff;
    text-align: center;
}

.deals-section h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
}

.deals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 0 20px;
}

.deal-card {
    background-color: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.deal-card:hover {
    transform: translateY(-10px);
}

.deal-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.deal-card h3 {
    font-size: 1.5rem;
    color: #007bff;
    margin: 15px 0;
}

.deal-card p {
    font-size: 1rem;
    color: #666;
    padding: 0 15px;
}

.deal-card .price {
    font-size: 1.2rem;
    color: #ff9900;
    font-weight: bold;
    margin: 15px 0;
}

.deal-card .btn {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    margin: 15px 0;
    transition: background 0.3s ease;
}

.deal-card .btn:hover {
    background-color: #0056b3;
}


    
</head>
<body>
<div class="top-navbar">
        <div class="social-icons">
            <a href="https://www.facebook.com" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.twitter.com" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="https://www.instagram.com" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>

    <!-- Navbar Section -->
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <div class="logo">
                <img src="smarttech-logo.png" alt="SmartTech Hub Logo">
                <span>SmartTech Hub</span>
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
                <a href="signinAdd.php" aria-label="User Account"><i class="fa-regular fa-user"></i></a>
                <a href="#" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></a>
                <a href="shoppingcard.php" aria-label="Shopping Cart"><i class="fa-solid fa-cart-shopping"></i></a>
                <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
            </div>
        </nav>

        <div class="menu">
            <ul>
                <li><a href="#">HOME</a></li>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle">PRODUCTS</a>
                
            </li>
                <li><a href="#">GAMING LAPTOPS</a></li>
                <li><a href="#">NEW ARRIVALS</a></li>
                <li><a href="#">COMING SOON</a></li>
                <li><a href="#">ABOUT US</a></li>
                <li><a href="contact.php">CONTACT US</a></li>
            </ul>
        </div>
    </header>

    <div class="slide-container">
        <!-- Navigation arrows -->
        <span class="arrow prev">&#10094;</span>
        <span class="arrow next">&#10095;</span>

        <div class="slides">
            <img src="images/lenova.jpg" alt="Image 1">
            <img src="images/acer1.jpg" alt="Image 2">
            <img src="images/acer2.jpg" alt="Image 3">
            <img src="images/aspire.jpg" alt="Image 4">
            <img src="images/vostro.jpg" alt="Image 5">
            <img src="images/dell.jpg" alt="Image 6">
            <img src="images/aspire1.jpg" alt="Image 6">
            <img src="images/victus.jpg" alt="Image 6">
            <img src="images/nitro.jpg" alt="Image 6">
        </div>
    </div>

    <script>
        let index = 0;
        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const totalImages = images.length;

        // Move to the next slide
        function moveToNextSlide() {
            index = (index + 1) % totalImages; // Loop back to the first image when we reach the end
            const offset = -index * 100; // Shift by 100% per image
            slides.style.transform = `translateX(${offset}%)`;
        }

        // Move to the previous slide
        function moveToPrevSlide() {
            index = (index - 1 + totalImages) % totalImages; // Loop to the last image when moving backward
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        // Automatically change the slide every 3 seconds
        setInterval(moveToNextSlide, 3000);

        // Navigation buttons (previous and next)
        document.querySelector('.next').addEventListener('click', moveToNextSlide);
        document.querySelector('.prev').addEventListener('click', moveToPrevSlide);
    </script>
</body>
</html>
