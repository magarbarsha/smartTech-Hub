<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Footer</title>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

        .footer {
            background: #007bff;
            /* background: white; */
            padding: 20px 0; /* Reduced from 30px */
         position:relative;
         top:170px;
            color: black;
            font-size: 30px;
            margin-top: auto;
            text-align: center;
        }

        .footer.dark-mode {
            background: linear-gradient(135deg, #333, #555);
        }

        .container {
           
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-section {
            width: 20%;
            padding: 8px; /* Reduced from 10px */
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }

        .footer-section:hover {
            transform: translateY(-5px);
        }

        .footer-section h3 {
            font-size: 18px; /* Increased from 16px */
            margin-bottom: 12px; /* Reduced from 15px */
            font-weight: bold;
            letter-spacing: 0.5px;
            color: whitesmoke;
        }

        .footer-section p,
        .footer-section ul {
            color: whitesmoke;
            margin: 4px 0; /* Reduced from 5px */
            font-size: 14px; /* Increased from 12px */
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin: 4px 0; /* Reduced from 5px */
        }

        .footer-section ul li a {
            color: whitesmoke;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: #ff5733;
        }

        .footer-section .social-icons a {
            margin: 6px; /* Reduced from 8px */
            color: #000000;
            font-size: 20px; /* Increased from 18px */
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .footer-section .social-icons a:hover {
            color: #ff5733;
            transform: scale(1.2);
        }

        .footer-section input {
            width: 80%;
            padding: 8px;
            margin-top: 8px; /* Reduced from 10px */
            border: 1px solid #cccccc;
            border-radius: 5px;
            background-color:rgb(245, 245, 245);
            color: #333333;
            transition: background-color 0.3s;
            font-size: 14px; /* Increased */
        }

        .footer-section input:focus {
            outline: none;
            border-color: #ff5733;
        }

        .footer-section button {
            background: #ff5733;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-top: 8px; /* Reduced from 10px */
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px; /* Increased */
        }

        .footer-section button:hover {
            background: #e24e29;
        }

        .footer-bottom {
            font-size: 14px; /* Increased from 12px */
            margin-top: 15px; /* Reduced from 20px */
            color: #666666;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px; /* Reduced from 15px */
        }

        .payment-methods img {
            width: 60px; /* Reduced from 70px */
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .payment-methods img:hover {
            transform: scale(1.1);
            opacity: 0.8;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #ff5733;
            color: white;
            padding: 12px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
        }

        .back-to-top:hover {
            background: #e24e29;
            transform: scale(1.1);
        }

        .dark-mode-toggle {
            position: fixed;
            bottom: 70px;
            right: 20px;
            background: #ff5733;
            color: white;
            padding: 12px;
            border-radius: 50%;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .footer-section {
                width: 45%;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .footer-section {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <footer class="footer">
        <div class="container">
            <div class="footer-section contact">
                <h3>CONTACT US</h3>
                <p><i class="fas fa-map-marker-alt"></i> Kathmandu, Nepal</p>
                <p><i class="fas fa-phone"></i> +977-1-4524327</p>
                <p><i class="fas fa-envelope"></i> info@SmartTechHub.com.np</p>
                <p><i class="fas fa-clock"></i> Sunday - Friday 11:00 AM - 7:00 PM</p>
            </div>

            <div class="footer-section about">
                <h3>ABOUT US</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Store Location</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Shipping & Delivery</a></li>
                </ul>
            </div>

            <div class="footer-section info">
                <h3>INFORMATION</h3>
                <ul>
                    <li><a href="#">Warranty</a></li>
                    <li><a href="#">Payments</a></li>
                </ul>
            </div>

            <div class="footer-section account">
                <h3>MY ACCOUNT</h3>
                <ul>
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">My Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">My Wishlist</a></li>
                </ul>
            </div>

            <div class="footer-section deals">
                <h3>GET EXCLUSIVE DEALS</h3>
                <input type="email" placeholder="Your Email Address">
                <button>SUBSCRIBE</button>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <span id="year"></span> SmartTech Hub. All Rights Reserved.</p>
            <div class="payment-methods">
                <img src="./images/cash.png" alt="Cash on Delivery">
                <img src="./images/esewa.png" alt="eSewa">
                <img src="fonepay.png" alt="FonePay">
                <img src="./images/kalti.jpeg" alt="IPS">
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div class="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" onclick="toggleDarkMode()">
        <i class="fas fa-moon"></i>
    </div>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();

        window.onscroll = function() {
            const backToTop = document.querySelector(".back-to-top");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTop.style.display = "block";
            } else {
                backToTop.style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        }

        function toggleDarkMode() {
            const footer = document.querySelector(".footer");
            footer.classList.toggle("dark-mode");
        }
    </script>
</body>
</html>