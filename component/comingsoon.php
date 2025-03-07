<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #444;
        }

        .coming-soon-container {
            text-align: center;
            padding: 20px;
        }

        .coming-soon-container h1 {
            font-size: 3rem;
            color: #ff6347;
            margin-bottom: 10px;
        }

        .coming-soon-container h2 {
            font-size: 2rem;
            color: #555;
            margin-bottom: 30px;
        }

        /* Countdown Timer */
        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
        }

        .timer-box {
            background-color: #222;
            color: white;
            padding: 20px;
            border-radius: 10px;
            font-size: 1.5rem;
            min-width: 120px;
        }

        .timer-box span {
            display: block;
            font-weight: bold;
        }

        /* Product List */
        .product-list {
            padding: 20px;
            background-color: #fff;
        }

        .product-list h3 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .product-list ul {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            list-style-type: none;
        }

        .product-list li {
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-list li:hover {
            transform: translateY(-5px);
        }

        .product-list img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-details {
            padding: 15px;
        }

        .product-details h4 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
        }

        .product-details p {
            font-size: 1rem;
            color: #666;
        }

        /* Subscription Form */
        .subscription-form {
            margin-top: 50px;
            background-color: #ff6347;
            padding: 30px;
            color: #fff;
            border-radius: 10px;
        }

        .subscription-form h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .subscription-form form {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .subscription-form input {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: none;
            width: 300px;
            max-width: 90%;
        }

        .subscription-form button {
            padding: 10px 20px;
            background-color: #fff;
            color: #ff6347;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .subscription-form button:hover {
            background-color: #ff4500;
            color: white;
        }

        .subscription-form p {
            margin-top: 20px;
            font-size: 1rem;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            .countdown-timer {
                flex-direction: column;
            }

            .timer-box {
                margin-bottom: 15px;
            }

            .product-list ul {
                grid-template-columns: 1fr 1fr;
            }

            .subscription-form input {
                width: 250px;
            }
        }

        @media (max-width: 480px) {
            .product-list ul {
                grid-template-columns: 1fr;
            }

            .subscription-form input {
                width: 100%;
            }

            .coming-soon-container h1 {
                font-size: 2.5rem;
            }

            .coming-soon-container h2 {
                font-size: 1.5rem;
            }

            .product-details h4 {
                font-size: 1.1rem;
            }

            .product-details p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <?php
    include './nav.php';
    ?>
    <div class="coming-soon-container">
        <h1>SmartTech Hub</h1>
        <h2>Exciting New Laptops Are Coming Soon!</h2>

        <!-- Countdown Timer -->
        <div class="countdown-timer">
            <div class="timer-box">
                <span id="days">00</span>
                <span>Days</span>
            </div>
            <div class="timer-box">
                <span id="hours">00</span>
                <span>Hours</span>
            </div>
            <div class="timer-box">
                <span id="minutes">00</span>
                <span>Minutes</span>
            </div>
            <div class="timer-box">
                <span id="seconds">00</span>
                <span>Seconds</span>
            </div>
        </div>

        <!-- Laptop Product List -->
        <div class="product-list">
            
            <div class="product-list">
            <h3>Upcoming Laptops</h3>
            <ul>
                <li>
                    <img src="./images/coming1.jpeg" alt="Ultra-Thin 14\" Business Laptop">
                    <div class="product-details">
                        <h4>Ultra-Thin 14" Business Laptop</h4>
                        <p>Perfect for professionals on the go. Features a sleek design and long battery life.</p>
                    </div>
                </li>
                <li>
                    <img src="./images/coming2.jpeg" alt="Gaming Laptop with RTX 4090">
                    <div class="product-details">
                        <h4>Gaming Laptop with RTX 4090</h4>
                        <p>Experience the ultimate gaming performance with RTX 4090, perfect for gaming enthusiasts.</p>
                    </div>
                </li>
                <li>
                    <img src="./images/coming3.jpeg" alt="2-in-1 Convertible Laptop">
                    <div class="product-details">
                        <h4>2-in-1 Convertible Laptop</h4>
                        <p>A versatile laptop with a touch screen, perfect for both work and play.</p>
                    </div>
                </li>
                <li>
                    <img src="./images/coming4.jpeg" alt="MacBook Pro 16\" (M3 Chip)">
                    <div class="product-details">
                        <h4>MacBook Pro 16" (M3 Chip)</h4>
                        <p>Apple's latest MacBook with M3 chip, designed for ultimate performance and efficiency.</p>
                    </div>
                </li>
                <!-- <li>
                    <img src="./images/coming5.jpeg" alt="Budget-Friendly Student Laptop">
                    <div class="product-details">
                        <h4>Budget-Friendly Student Laptop</h4>
                        <p>Affordable and powerful laptop for students, with all the necessary features for learning.</p>
                    </div>
                </li> -->
                <li>
                    <img src="./images/coming6.jpeg" alt="17\" Workstation Laptop for Creators">
                    <div class="product-details">
                        <h4>17" Workstation Laptop for Creators</h4>
                        <p>A high-performance laptop with a large screen, designed for creative professionals.</p>
                    </div>
                </li>
                <li>
                    <img src="./images/coming7.jpeg" alt="Foldable OLED Laptop">
                    <div class="product-details">
                        <h4>Foldable OLED Laptop</h4>
                        <p>Cutting-edge foldable design with an OLED display for ultimate portability and clarity.</p>
                    </div>
                </li>
                
                <li>
                    <img src="./images/coming8.jpeg" alt="Rugged Laptop for Outdoor Use">
                    <div class="product-details">
                        <h4>Rugged Laptop for Outdoor Use</h4>
                        <p>Built to withstand the elements, this rugged laptop is perfect for outdoor and field work.</p>
                    </div>
                </li>
                <li>
                    <img src="./images/coming9.jpeg" alt="SmartTech Foldable Laptop">
                    <div class="product-details">
                        <h4>SmartTech Foldable Laptop</h4>
                        <p>A futuristic foldable laptop that combines cutting-edge technology and portability.</p>
                    </div>
                </li>
         
            </ul>
        </div>

        <!-- Subscription Form -->
        <div class="subscription-form">
            <h3>Get Notified When We Launch!</h3>
            <form id="notifyForm" action="notify.php" method="POST">
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Notify Me</button>
    </form>
    <p id="message"></p>
           
        </div>
    </div>

    <script>
        // Countdown Timer
        const countdown = () => {
            const launchDate = new Date("2023-12-31T00:00:00").getTime(); // Set your launch date here
            const now = new Date().getTime();
            const timeLeft = launchDate - now;

            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days < 10 ? `0${days}` : days;
            document.getElementById("hours").innerText = hours < 10 ? `0${hours}` : hours;
            document.getElementById("minutes").innerText = minutes < 10 ? `0${minutes}` : minutes;
            document.getElementById("seconds").innerText = seconds < 10 ? `0${seconds}` : seconds;

            if (timeLeft < 0) {
                clearInterval(countdownInterval);
                document.querySelector(".countdown-timer").innerHTML = "<h3>We're Live!</h3>";
            }
        };

        const countdownInterval = setInterval(countdown, 1000);

        // Subscription Form
        // document.getElementById("subscribe-form").addEventListener("submit", function (e) {
        //     e.preventDefault();
        //     const email = document.getElementById("email").value;
        //     const message = document.getElementById("subscription-message");

        //     if (email) {
        //         message.innerText = "Thank you! We'll notify you when we launch.";
        //         document.getElementById("email").value = ""; // Clear the input field
        //     } else {
        //         message.innerText = "Please enter a valid email address.";
        //     }
        // });
        document.getElementById('notifyForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('notify.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('message').textContent = data;
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    </script>

    <?php
    include './footer.php';
    ?>
</body>
</html>
