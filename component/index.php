<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    <link rel="stylesheet" href="../assets/css/chatbot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    
</head>
<body>
    <?php include './nav.php' ?>
    
    <div class="slide-container">
        <span class="arrow prev">&#10094;</span>
        <span class="arrow next">&#10095;</span>
        <div class="slides">
            <img src="images/lenova.jpg" alt="Lenovo Laptop">
            <img src="images/acer1.jpg" alt="Acer Laptop">
            <img src="images/acer2.jpg" alt="Acer Laptop">
            <img src="images/aspire.jpg" alt="Acer Aspire">
            <img src="images/vostro.jpg" alt="Dell Vostro">
            <img src="images/dell.jpg" alt="Dell Laptop">
            <img src="images/aspire1.jpg" alt="Acer Aspire">
            <img src="images/victus.jpg" alt="HP Victus">
            <img src="images/nitro.jpg" alt="Acer Nitro">
        </div>
    </div>

    <?php include './featured.php'; ?>

    <section class="deals-section">
        <h2>Today's Deals and Offers</h2>
        <div class="deals-grid">
            <div class="deal-card">
                <img src="./images/1.jpeg" alt="Gaming Laptop">
                <h3>Gaming Laptop - 20% Off</h3>
                <p>Experience ultimate gaming performance with this high-end laptop.</p>
                <p class="price">$999.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/2.jpeg" alt="Ultrabook">
                <h3>Ultrabook - 15% Off</h3>
                <p>Sleek and lightweight, perfect for professionals on the go.</p>
                <p class="price">$799.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/3.jpeg" alt="Budget Laptop">
                <h3>Budget Laptop - 30% Off</h3>
                <p>Affordable yet powerful, ideal for everyday use.</p>
                <p class="price">$499.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/4.jpeg" alt="2-in-1 Laptop">
                <h3>2-in-1 Laptop - 25% Off</h3>
                <p>Versatile and portable, perfect for work and play.</p>
                <p class="price">$899.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
        </div>
    </section>

    <?php include './logo.php'; ?>
    <?php include './footer.php'; ?>

    <!-- Chatbot HTML -->
    <div id="chatbot-toggle">
        <i class="fas fa-robot"></i>
    </div>

    <div id="chatbot-container">
        <div class="chatbot-header">
            <h3>Tech Assistant</h3>
            <button id="chatbot-close" class="chatbot-close-btn">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        
        <div class="chatbot-suggestions">
            <div class="suggestion-card" data-prompt="Show me gaming laptops">
                <span class="material-symbols-rounded">sports_esports</span>
                <p>Gaming Laptops</p>
            </div>
            <div class="suggestion-card" data-prompt="What are today's deals?">
                <span class="material-symbols-rounded">local_offer</span>
                <p>Today's Deals</p>
            </div>
            <div class="suggestion-card" data-prompt="Recommend a budget laptop">
                <span class="material-symbols-rounded">savings</span>
                <p>Budget Options</p>
            </div>
        </div>
        
        <div class="chatbot-messages"></div>
        
        <div class="chatbot-input">
            <input type="text" placeholder="Ask about laptops..." class="chatbot-prompt">
            <button id="chatbot-send" class="chatbot-send-btn">
                <span class="material-symbols-rounded">send</span>
            </button>
        </div>
        
        <p class="chatbot-disclaimer">Assistant may make mistakes. Verify important details.</p>
    </div>

    <script>
    // Slider functionality (unchanged)
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

    if (slides && images.length > 0) {
        setInterval(moveToNextSlide, 3000);
        
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');
        if (nextBtn) nextBtn.addEventListener('click', moveToNextSlide);
        if (prevBtn) prevBtn.addEventListener('click', moveToPrevSlide);
    }

    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            const menu = document.querySelector('.menu ul');
            if (menu) menu.classList.toggle('show');
        });
    }

    // Chatbot functionality with typing effect and response length control
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotContainer = document.getElementById('chatbot-container');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotSend = document.getElementById('chatbot-send');
        const chatbotPrompt = document.querySelector('.chatbot-prompt');
        const chatbotMessages = document.querySelector('.chatbot-messages');
        const suggestionCards = document.querySelectorAll('.suggestion-card');

        // Typing effect variables
        let typingInterval;
        const typingSpeed = 30; // milliseconds per character
        const pauseBetweenWords = 100; // milliseconds
        const maxResponseLength = 500; // Maximum characters to show initially
        const readMoreThreshold = 300; // Minimum length to show "Read More"

        if (!chatbotToggle || !chatbotContainer) {
            console.error('Essential chatbot elements missing!');
            return;
        }

        // Toggle chatbot visibility
        chatbotToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            chatbotContainer.classList.toggle('active');
            void chatbotContainer.offsetWidth;
        });

        if (chatbotClose) {
            chatbotClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                chatbotContainer.classList.remove('active');
            });
        }

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (chatbotContainer.classList.contains('active') && 
                !chatbotContainer.contains(e.target) && 
                e.target !== chatbotToggle) {
                chatbotContainer.classList.remove('active');
            }
        });

        // Handle suggestion cards
        if (suggestionCards.length > 0) {
            suggestionCards.forEach(card => {
                card.addEventListener('click', function() {
                    const prompt = this.getAttribute('data-prompt');
                    if (prompt) {
                        sendMessage(prompt);
                    }
                });
            });
        }

        // Handle send button click
        if (chatbotSend && chatbotPrompt) {
            chatbotSend.addEventListener('click', function() {
                const message = chatbotPrompt.value.trim();
                if (message) {
                    sendMessage(message);
                    chatbotPrompt.value = '';
                }
            });

            // Handle Enter key in prompt input
            chatbotPrompt.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const message = chatbotPrompt.value.trim();
                    if (message) {
                        sendMessage(message);
                        chatbotPrompt.value = '';
                    }
                }
            });
        }

        // Function to send message and get response
        async function sendMessage(message) {
            if (!chatbotMessages) return;
            
            // Add user message to chat
            addMessage(message, 'user-message');
            
            // Show typing indicator
            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'chatbot-message bot-message typing-indicator';
            typingIndicator.textContent = 'Assistant is typing...';
            chatbotMessages.appendChild(typingIndicator);
            scrollToBottom();
            
            try {
                // Prepare the request with length limits
                const requestData = {
                    contents: [{
                        parts: [{ text: message }]
                    }],
                    generationConfig: {
                        maxOutputTokens: 500, // Limit response length at API level
                        temperature: 0.7
                    }
                };
                
                // Make API call
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                });
                
                const data = await response.json();
                
                // Remove typing indicator
                if (typingIndicator.parentNode) {
                    chatbotMessages.removeChild(typingIndicator);
                }
                
                if (response.ok && data.candidates && data.candidates[0].content.parts) {
                    const botResponse = data.candidates[0].content.parts[0].text;
                    // Use improved typing effect with length control
                    simulateTypingEffect(botResponse, 'bot-message');
                } else {
                    throw new Error(data.error?.message || 'Failed to get response');
                }
            } catch (error) {
                console.error('Error:', error);
                if (typingIndicator.parentNode) {
                    chatbotMessages.removeChild(typingIndicator);
                }
                addMessage(`Sorry, I encountered an error: ${error.message}`, 'bot-message');
            }
        }
        
        // Improved typing effect with length control
        function simulateTypingEffect(text, className) {
            if (!chatbotMessages) return;
            
            // Create message container
            const messageDiv = document.createElement('div');
            messageDiv.className = `chatbot-message ${className}`;
            chatbotMessages.appendChild(messageDiv);
            
            // Determine if we need to truncate
            const needsTruncation = text.length > maxResponseLength;
            const displayText = needsTruncation ? 
                text.substring(0, maxResponseLength) + '...' : 
                text;
            
            let i = 0;
            let currentWord = '';
            let isTypingWord = true;
            
            // Clear any existing interval
            if (typingInterval) clearInterval(typingInterval);
            
            typingInterval = setInterval(() => {
                if (i < displayText.length) {
                    if (isTypingWord) {
                        // Add next character
                        currentWord += displayText.charAt(i);
                        messageDiv.textContent = currentWord;
                        i++;
                        
                        // Random chance to pause between words
                        if (displayText.charAt(i) === ' ' || displayText.charAt(i) === '.' || Math.random() < 0.02) {
                            isTypingWord = false;
                        }
                    } else {
                        // Pause between words
                        setTimeout(() => {
                            isTypingWord = true;
                        }, pauseBetweenWords);
                    }
                    
                    scrollToBottom();
                } else {
                    // Typing complete
                    clearInterval(typingInterval);
                    
                    // Add "Read More" button if needed
                    if (needsTruncation && text.length > readMoreThreshold) {
                        const readMoreBtn = document.createElement('button');
                        readMoreBtn.className = 'read-more-btn';
                        readMoreBtn.textContent = 'Read More';
                        readMoreBtn.addEventListener('click', () => {
                            // Replace with full text
                            messageDiv.textContent = text;
                            scrollToBottom();
                        });
                        messageDiv.appendChild(readMoreBtn);
                    }
                }
            }, typingSpeed);
        }
        
        // Helper function to add message to chat (instant display)
        function addMessage(text, className) {
            if (!chatbotMessages) return;
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `chatbot-message ${className}`;
            messageDiv.textContent = text;
            chatbotMessages.appendChild(messageDiv);
            scrollToBottom();
        }
        
        // Helper function to scroll to bottom of messages
        function scrollToBottom() {
            if (chatbotMessages) {
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
        }
    });

    // IMPORTANT: Move this to server-side in production!
    const API_KEY = "AIzaSyAKbyk4jq-YqYriQpK6gF0pJBkev8zbFNA";
    const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;
</script>

<style>
    /* Add this to your CSS */
    .read-more-btn {
        background: #0044ff;
       
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        margin-top: 10px;
        cursor: pointer;
        font-size: 0.8rem;
        display: block;
    }
    
    .read-more-btn:hover {
        background: #0044ff;
    }
</style>