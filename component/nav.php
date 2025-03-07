<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* General Styles */






.search-bar {
    display: flex;
    align-items: center;
    background-color: #f8f9fa;
    border-radius: 25px;
    padding: 8px 15px;
    border: 1px solid #ddd;
    width: 50%;
    max-width: 1000px;
    transition: box-shadow 0.3s ease;
}

.search-bar:hover {
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

.search-bar select {
    border: none;
    outline: none;
    padding: 8px;
    background-color: transparent;
    font-size: 14px;
    margin-right: 10px;
    cursor: pointer;
}

.search-bar input {
    border: none;
    outline: none;
    padding: 8px;
    width: 100%;
    font-size: 14px;
    background-color: transparent;
}

.search-bar button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    color: #333;
    transition: color 0.3s ease;
}

.search-bar button:hover {
    color: #007BFF;
}

#voice-search-btn {
    margin-left: 10px;
}

/* .nav-icons {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-icons a {
    color: #333;
    text-decoration: none;
    font-size: 18px;
    transition: color 0.3s ease;
}

.nav-icons a:hover {
    color: #007BFF;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5em;
    color: #333;
}

/* Menu */
/* .menu {
    background-color: #333;
    padding: 10px 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
} */

/* .menu ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin: 0;
    padding: 0;
}

.menu ul li {
    margin: 0 15px;
    position: relative;
}

.menu ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: color 0.3s ease;
} */ */

/* .menu ul li a:hover {
    color: #007BFF;
} */

/* Dropdown Menu */
.dropdown-toggle::after {
    content: '▼';
    font-size: 12px;
    margin-left: 5px;
}

.dropdown {
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    min-width: 150px;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    display: block;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #f8f9fa;
}

.dropdown:hover .dropdown-content {
    display: block;
}
.menu ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px; /* Space between icon and text */
}

.menu ul li a:hover {
    color: #007BFF;
}

.menu ul li a i {
    font-size: 18px; /* Adjust icon size */
}

/* Responsive Design */
/* @media (max-width: 768px) {
    .search-bar {
        width: 100%;
        margin: 10px 0;
    }

    .menu-toggle {
        display: block;
    }

    .menu ul {
        flex-direction: column;
        align-items: center;
    }

    .menu ul li {
        margin: 10px 0;
    }

    .nav-icons {
        gap: 15px;
    }
} */

    



        </style>
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
                <i class="fa-solid fa-laptop-code" style="font-size: 2em; color: #007bff;"></i>  <span>SmartTech Hub</span>
            </div>

            <div class="search-bar" role="search">
                <select class="category" aria-label="Product Categories">
                    <option>All Categories</option>
                    <option><a href="laptops.php">Laptops</a></option>
                    <option>Accessories</option>
                    <option>Smartphones</option>
                </select>
                <input type="text" id="search-input" placeholder="Search for products, categories..." aria-label="Search">
                <button id="voice-search-btn" aria-label="Voice Search"><i class="fas fa-microphone"></i></button>
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
        <li>
            <a href="index2.php">
                <i class="fas fa-home"></i> HOME
            </a>
        </li>
        <li class="dropdown">
            <a href="dynamicproduct.php" class="dropdown-toggle">
                <i class="fas fa-box-open"></i> PRODUCTS
            </a>
        </li>
        <li>
            <a href="laptops.php">
                <i class="fas fa-laptop"></i> GAMING LAPTOPS
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-star"></i> NEW ARRIVALS
            </a>
        </li>
        <li>
            <a href="comingsoon.php">
                <i class="fas fa-clock"></i> COMING SOON
            </a>
        </li>
        <li>
            <a href="aboutus.php">
                <i class="fas fa-info-circle"></i> ABOUT US
            </a>
        </li>
        <li>
            <a href="contact.php">
                <i class="fas fa-envelope"></i> CONTACT US
            </a>
        </li>
    </ul>
</div>
    </header>

    <!-- JavaScript for Voice Search -->
    <script>
        // Voice Search Functionality
        const voiceSearchBtn = document.getElementById('voice-search-btn');
        const searchInput = document.getElementById('search-input');

        // Check if the browser supports speech recognition
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            const recognition = new SpeechRecognition();
            recognition.continuous = false; // Stop after one command
            recognition.interimResults = false; // Only final results

            voiceSearchBtn.addEventListener('click', () => {
                recognition.start();
                voiceSearchBtn.innerHTML = '<i class="fas fa-microphone-slash"></i>'; // Change icon while listening
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                searchInput.value = transcript; // Set the recognized text to the search input
                voiceSearchBtn.innerHTML = '<i class="fas fa-microphone"></i>'; // Change icon back
            };

            recognition.onerror = (event) => {
                console.error('Error occurred in recognition: ', event.error);
                voiceSearchBtn.innerHTML = '<i class="fas fa-microphone"></i>'; // Change icon back
            };
        } else {
            console.log('Speech recognition not supported in this browser.');
            voiceSearchBtn.style.display = 'none'; // Hide the button if not supported
        }
    </script>
</body>
</html>