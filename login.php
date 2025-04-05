<?php


session_start();
require './includes/config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($res);
    if ($num > 0) {
        $row = mysqli_fetch_assoc($res);
        $role = $row['role'];
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            if ($role == 'admin') {
                header('location: ./admin/dashboard.php');
            }
            if ($role == 'user') {
                header('location: ./component/index.php');
            }
        } else {
            echo "Password donot match";
        }
    } else {
        echo "No user found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTech Hub - Login</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="./assets/css/login2.css">
</head>

<body>
    <div class="login-container">
        <div class="logo-container">
            <h1>SmartTech Hub</h1>
            <p>Your digital gateway to the future</p>
        </div>
        <div class="form-container">
            <form id="loginForm" action="" method="POST">
                <div class="input-group">
                    <label for="email">Email or Phone Number</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email or phone" required>
                </div>

                <div class="input-group password-container">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁</span>
                </div>

                <div class="terms">
                    <label>
                        <input type="checkbox" required> I agree to the <a href="#">Terms & Privacy</a>
                    </label>
                </div>

                <div class="submit-container">
                    <input type="submit" name="login">Login</>
                </div>
            </form>

            <div class="links">
                <a href="#">Forgot password?</a>
                <a href="#">Sign up</a>
            </div>

            <div class="divider">OR</div>
            <div class="google-login">
                <button class="google-btn">Log in with Google</button>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>