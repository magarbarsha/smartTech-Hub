<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            padding-top: 0; /* Adjust this based on navbar heights */
        }

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
            <a href="userOrder.php">My Orders</a> |
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
                <select id="category-select" aria-label="Product Categories">
                    <option value="All Categories">All Categories</option>
                    <option value="Laptops">Laptops</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Smartphones">Smartphones</option>
                    <option value="Dell">Dell</option> <!-- Added Dell option for filtering -->
                </select>
                <input type="text" id="search-input" placeholder="Search for products, categories..." aria-label="Search">
                <button id="voice-search-btn" aria-label="Voice Search"><i class="fas fa-microphone"></i></button>
                <button class="search-btn" aria-label="Search Button"><i class="fas fa-search"></i></button>
            </div>

            <div class="nav-icons">
                <a href="../login.php" aria-label="User Account"><i class="fa-regular fa-user"></i></a>
                <a href="wishListView.php" aria-label="Wishlist"><i class="fa-regular fa-heart"></i></a>
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

    <script>
    // Function to handle the search action
    function handleSearch() {
        let searchQuery = document.getElementById('search-input').value;
        let category = document.getElementById('category-select').value;
        // Redirect to the dynamic product page with the selected category and search query as query parameters
        window.location.href = `dynamicproduct.php?search=${searchQuery}&category=${category}`;
    }

    // Search button click event
    document.querySelector('.search-btn').addEventListener('click', function () {
        handleSearch();
    });

    // Trigger search on "Enter" key press
    document.getElementById('search-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });

    // Voice Search Functionality (Optional)
    const voiceSearchBtn = document.getElementById('voice-search-btn');
    const searchInput = document.getElementById('search-input');
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        const recognition = new SpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;
        voiceSearchBtn.addEventListener('click', () => {
            recognition.start();
            voiceSearchBtn.innerHTML = '<i class="fas fa-microphone-slash"></i>';
        });
        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            searchInput.value = transcript;
            voiceSearchBtn.innerHTML = '<i class="fas fa-microphone"></i>';
        };
    } else {
        console.log('Speech recognition not supported in this browser.');
        voiceSearchBtn.style.display = 'none';
    }
</script>

</body>
</html>
