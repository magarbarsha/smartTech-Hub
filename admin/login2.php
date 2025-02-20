
<?php
include '../includes/config.php';
if(isset($_POST['submit']))
{
  
$email=$_POST['email'];

$password=$_POST['password'];

$sql="SELECT INTO login WHERE email='$email'";
$res=mysqli_query($conn,$sql);
$num=mysqli_num_rows($res);
if($num>0){
    $row=mysqli_fetch_assoc($res);
    $role=$row['role'];
    if($role=='admin'){
        
    }
}
if(!$res){

echo "category not added";
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
     <style>
        /* Reset default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to right, #4e73df, #224abe);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
    padding: 0 15px;
}

/* Login Container */
.login-container {
    background: #fff;
    padding: 40px 50px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    transition: all 0.3s ease;
}

/* Logo and Heading */
.logo-container {
    text-align: center;
    margin-bottom: 20px;
}

h1 {
    color: #4e73df;
    font-size: 32px;
    margin-bottom: 5px;
}

p {
    color: #666;
    font-size: 14px;
}

/* Input Fields */
.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #333;
}

.input-group input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ddd;
    outline: none;
    transition: border-color 0.3s ease;
}

.input-group input:focus {
    border-color: #4e73df;
}

/* Password Container */
.password-container {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    cursor: pointer;
    color: #4e73df;
}

/* Terms and Conditions */
.terms {
    font-size: 12px;
    margin-bottom: 20px;
    color: #666;
}

/* Submit Button */
.submit-container button {
    width: 100%;
    padding: 14px;
    background-color: #4e73df;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
input[type="submit"]{
    width: 100%;
    padding: 14px;
    background-color: #4e73df;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-container button:hover {
    background-color: #2e58b0;
}

/* Links */
.links {
    text-align: center;
    margin-top: 10px;
}

.links a {
    color: #4e73df;
    text-decoration: none;
    font-size: 14px;
    margin: 5px;
    transition: color 0.3s ease;
}

.links a:hover {
    color: #2e58b0;
}

/* Divider */
.divider {
    text-align: center;
    margin: 20px 0;
    font-weight: bold;
    color: #4e73df;
}

/* Google Login */
.google-login {
    text-align: center;
}

.google-btn {
    background-color: #db4437;
    color: white;
    padding: 12px;
    border-radius: 6px;
    border: none;
    width: 100%;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.google-btn:hover {
    background-color: #c1351d;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .login-container {
        padding: 30px 40px;
    }

    h1 {
        font-size: 28px;
    }

    .input-group input,
    .submit-container button {
        font-size: 14px;
    }

    .google-btn {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .login-container {
        width: 90%;
        padding: 25px 30px;
    }

    h1 {
        font-size: 24px;
    }

    .input-group input,
    .submit-container button {
        font-size: 13px;
    }

    .google-btn {
        font-size: 13px;
    }
}

     </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-container">
            <h1>SmartTech Hub</h1>
            <p>Your digital gateway to the future</p>
        </div>
        <div class="form-container">
            <form id="loginForm" action="login2.php" method="POST">
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
                    <input type="submit" name="submit">Login</>
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
