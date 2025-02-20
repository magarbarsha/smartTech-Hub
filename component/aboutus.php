<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Smart Tech Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 15px 0;
            font-size: 1.1em;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            padding: 60px 20px;
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 3em;
            margin: 0;
            animation: fadeIn 2s ease-in-out;
        }

        .header p {
            font-size: 1.2em;
            animation: fadeIn 3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Features Section */
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 40px 0;
        }

        .feature-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .feature-card i {
            font-size: 2.5em;
            color: #2575fc;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .feature-card p {
            font-size: 1em;
            color: #666;
        }

        /* Credentials Section */
        .credentials {
            background: #fff;
            padding: 40px 20px;
            margin: 40px 0;
            text-align: center;
        }

        .credentials h2 {
            margin-bottom: 30px;
        }

        .credentials ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .credentials ul li {
            background: #f4f4f4;
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 1.1em;
            color: #333;
            transition: background 0.3s ease;
        }

        .credentials ul li:hover {
            background: #2575fc;
            color: #fff;
        }

        /* Image Section */
        .image-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
        }

        .image-section img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-section img:hover {
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        .footer a {
            color: #2575fc;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }

            .image-section {
                flex-direction: column;
                align-items: center;
            }

            .header h1 {
                font-size: 2.5em;
            }

            .header p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?php
    include './nav.php';
    ?>

    <!-- Main Content -->
    <div class="container">
        <h2>Our Mission</h2>
        <p>At <strong>Smart Tech Up</strong>, we are committed to providing the latest and most innovative laptops to enhance your productivity, creativity, and entertainment. Whether you're a gamer, a professional, or a student, we have the perfect laptop for you.</p>

        <!-- Features Section -->
        <div class="features">
            <div class="feature-card">
                <i class="fas fa-laptop"></i>
                <h3>Wide Selection</h3>
                <p>Explore a vast range of laptops from top brands like Dell, HP, Apple, and more.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-tags"></i>
                <h3>Competitive Pricing</h3>
                <p>Enjoy the best prices with exclusive discounts and special offers.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shipping-fast"></i>
                <h3>Fast Shipping</h3>
                <p>Get your laptop delivered quickly and securely to your doorstep.</p>
            </div>
        </div>
        <div class="image-section">
            <img src="./images/nitro.jpg" alt="Laptop Image 1">
            <img src="./images/vostro.jpg" alt="Laptop Image 2">
        </div>
    </div>

        <!-- Credentials Section -->
        <div class="credentials">
            <h2>Our Credentials</h2>
            <ul>
                <li>Certified Retailer for Top Brands</li>
                <li>Secure and Encrypted Shopping</li>
                <li>98% Customer Satisfaction Rate</li>
                <li>Hassle-Free Returns & Warranty</li>
            </ul>
        </div>

        <!-- Image Section -->
        <!-- <div class="image-section">
            <img src="./images/nitro.jpg" alt="Laptop Image 1">
            <img src="./images/vostro.jpg" alt="Laptop Image 2">
        </div>
    </div> -->

    <!-- Footer -->
    <?php
    include './footer.php';
    ?>
</body>
</html>