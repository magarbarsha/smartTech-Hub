// Toggle Password Visibility
function togglePassword() {
    const passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

// Handle Form Submission
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Logging in to SmartTech Hub...");
});