<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTech Hub</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Live Chat Widget CSS -->
    <style>
        /* Live Chat Widget Styles */
        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            z-index: 1000;
        }

        .chat-button:hover {
            background-color: #0056b3;
        }

        .chat-box {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            z-index: 1000;
        }

        .chat-box.active {
            display: flex;
        }

        .chat-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-chat {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .close-chat:hover {
            color: #ccc;
        }

        .chat-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message {
            padding: 8px;
            border-radius: 5px;
            max-width: 80%;
        }

        .message.user {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }

        .message.bot {
            background-color: #f1f1f1;
            color: black;
            align-self: flex-start;
        }

        .chat-footer {
            display: flex;
            padding: 10px;
            gap: 10px;
        }

        #chat-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .send-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .send-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include './nav.php'; ?>

    <!-- Image Slider -->
    <div class="slide-container">
        <span class="arrow prev">&#10094;</span>
        <span class="arrow next">&#10095;</span>

        <div class="slides">
            <img src="images/lenova.jpg" alt="Image 1">
            <img src="images/acer1.jpg" alt="Image 2">
            <img src="images/acer2.jpg" alt="Image 3">
            <img src="images/aspire.jpg" alt="Image 4">
            <img src="images/vostro.jpg" alt="Image 5">
            <img src="images/dell.jpg" alt="Image 6">
            <img src="images/aspire1.jpg" alt="Image 7">
            <img src="images/victus.jpg" alt="Image 8">
            <img src="images/nitro.jpg" alt="Image 9">
        </div>
    </div>

    <?php include './featured.php'; ?>

    <!-- Today's Deals and Offers Section -->
    <section class="deals-section">
        <h2>Today's Deals and Offers</h2>
        <div class="deals-grid">
            <div class="deal-card">
                <img src="./images/1.jpeg" alt="Laptop Deal 1">
                <h3>Gaming Laptop - 20% Off</h3>
                <p>Experience ultimate gaming performance with this high-end laptop.</p>
                <p class="price">$999.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/2.jpeg" alt="Laptop Deal 2">
                <h3>Ultrabook - 15% Off</h3>
                <p>Sleek and lightweight, perfect for professionals on the go.</p>
                <p class="price">$799.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/3.jpeg" alt="Laptop Deal 3">
                <h3>Budget Laptop - 30% Off</h3>
                <p>Affordable yet powerful, ideal for everyday use.</p>
                <p class="price">$499.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/4.jpeg" alt="Laptop Deal 4">
                <h3>2-in-1 Laptop - 25% Off</h3>
                <p>Versatile and portable, perfect for work and play.</p>
                <p class="price">$899.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
        </div>
    </section>

    <?php include './footer.php'; ?>

    <!-- Live Chat Widget -->
    <button id="chat-button" class="chat-button">Chat with Us</button>
    <div id="chat-box" class="chat-box">
        <div class="chat-header">
            <h3>SmartTech Hub Support</h3>
            <button id="close-chat" class="close-chat">×</button>
        </div>
        <div class="chat-body">
            <div id="chat-messages" class="chat-messages"></div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Type a message..." />
            <button id="send-button" class="send-button">Send</button>
        </div>
    </div>

    <script>
        // Image Slider Functionality
        let index = 0;
        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const totalImages = images.length;

        function moveToNextSlide() {
            index = (index + 1) % totalImages;
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        function moveToPrevSlide() {
            index = (index - 1 + totalImages) % totalImages;
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        setInterval(moveToNextSlide, 3000);

        document.querySelector('.next').addEventListener('click', moveToNextSlide);
        document.querySelector('.prev').addEventListener('click', moveToPrevSlide);

        document.querySelector('.menu-toggle').addEventListener('click', function () {
            document.querySelector('.menu ul').classList.toggle('show');
        });

        // Live Chat Functionality
        const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const closeChat = document.getElementById('close-chat');
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const sendButton = document.getElementById('send-button');

        chatButton.addEventListener('click', () => {
            chatBox.classList.toggle('active');
        });

        closeChat.addEventListener('click', () => {
            chatBox.classList.remove('active');
        });

        sendButton.addEventListener('click', () => {
            const message = chatInput.value.trim();
            if (message) {
                addMessage(message, 'user');
                chatInput.value = '';
                simulateBotResponse();
            }
        });

        function addMessage(text, sender) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', sender);
            messageElement.textContent = text;
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function simulateBotResponse() {
            setTimeout(() => {
                addMessage('Thank you for your message! How can we assist you today?', 'bot');
            }, 1000);
        }
    </script>
</body>
</html>