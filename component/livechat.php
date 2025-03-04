<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartTech Hub - Live Chat</title>
<style>
    /* Chat Button */
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
}

.chat-button:hover {
  background-color: #0056b3;
}

/* Chat Box */
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
}

.chat-box.active {
  display: flex;
}

/* Chat Header */
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

/* Chat Body */
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

/* Chat Footer */
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
  <!-- Chat Widget Button -->
  <button id="chat-button" class="chat-button">Chat with Us</button>

  <!-- Chat Box -->
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
    // DOM Elements
const chatButton = document.getElementById('chat-button');
const chatBox = document.getElementById('chat-box');
const closeChat = document.getElementById('close-chat');
const chatMessages = document.getElementById('chat-messages');
const chatInput = document.getElementById('chat-input');
const sendButton = document.getElementById('send-button');

// Toggle Chat Box
chatButton.addEventListener('click', () => {
  chatBox.classList.toggle('active');
});

// Close Chat Box
closeChat.addEventListener('click', () => {
  chatBox.classList.remove('active');
});

// Send Message
sendButton.addEventListener('click', () => {
  const message = chatInput.value.trim();
  if (message) {
    addMessage(message, 'user');
    chatInput.value = '';
    simulateBotResponse();
  }
});

// Add Message to Chat
function addMessage(text, sender) {
  const messageElement = document.createElement('div');
  messageElement.classList.add('message', sender);
  messageElement.textContent = text;
  chatMessages.appendChild(messageElement);
  chatMessages.scrollTop = chatMessages.scrollHeight; // Auto-scroll to bottom
}

// Simulate Bot Response
function simulateBotResponse() {
  setTimeout(() => {
    addMessage('Thank you for your message! How can we assist you today?', 'bot');
  }, 1000);
}
  </script>
</body>
</html>