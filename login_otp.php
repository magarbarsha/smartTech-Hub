<?php
include './includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-container {
            margin-top: 20px;
        }

        .submit-container input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-container input:hover {
            background-color: #3f51b5;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="input-group first_box">

                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <span id="email_error" class="field_error"></span>
            </div>
            <div class="submit-container first_box">
                <button type="button" class="btn" onclick="send_opt()">Send OTP</button>
            </div>
            <div class="input-group second_box">

                <input type="text" id="opt" placeholder="Enter your otp" required>
                <span id="otp_error" class="field_error"></span>
            </div>
            <div class="submit-container second_box">
                <button type="button" class="btn" onclick="submit_opt()">Submit OTP</button>
            </div>
        </form>
    </div>
    <script>
        function send_opt() {
            var email = jQuery('#email').val();
            jQuery.ajax({
                url: 'send_opt.php',
                type: 'post',
                data: 'email=' + email,
                success: function (result) {
                    if (result == 'yes') {
                        jQuery('.second_box').show();
                        jQuery('.first_box').hidden();
                    }
                    if (result == "not exit") {
                        3333333
                        jQuery('#email_error').html('please enter valid email');
                    }
                }
            });
        }
    </script>
    <style>
        .second_box {
            display: none;
        }

        .field_error {
            color: red;
        }
    </style>
</body>

</html>