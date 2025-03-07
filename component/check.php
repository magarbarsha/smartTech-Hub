<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
            outline: none;
            text-transform: capitalize;
            transition: all .2s linear;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            min-height: 100vh;
            background: linear-gradient(90deg,rgba(25, 93, 194, 0.73) 60%,#007bff 40%);
        }

        .container form {
            padding: 20px;
            width: 700px;
            background: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .container form .row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .container form .row .col {
            flex: 1 1 250px;
        }

        .container form .row .col .title {
            font-size: 20px;
            color: #333;
            padding-bottom: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .container form .row .col .inputBox {
            margin: 10px 0;
        }

        .container form .row .col .inputBox span {
            margin-bottom: 5px;
            display: block;
            font-size: 14px;
            font-weight: 600;
        }

        .container form .row .col .inputBox input {
            width: 100%;
            border: 1px solid #ccc;
            padding: 10px 15px;
            font-size: 15px;
            border-radius: 5px;
            text-transform: none;
        }

        .container form .row .col .inputBox input:focus {
            border: 1px solid black;
        }

        .flex {
            display: flex;
            gap: 15px;
        }

        .container form .row .col .inputBox img {
            width: 100px;
            height: auto;
        }

        .submit {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            color: white;
            background: orange;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .submit:hover {
            background: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <div class="row">
                <!-- Billing Address -->
                <div class="col">
                    <h3 class="title">Billing Address</h3>
                    <div class="inputBox">
                        <span>Full Name:</span>
                        <input type="text" placeholder="Enter your name...">
                    </div>
                    <div class="inputBox">
                        <span>Email:</span>
                        <input type="email" placeholder="Enter your email...">
                    </div>
                    <div class="inputBox">
                        <span>Address:</span>
                        <input type="text" placeholder="Enter your address...">
                    </div>
                    <div class="inputBox">
                        <span>City:</span>
                        <input type="text" placeholder="Enter your city...">
                    </div>
                    <div class="flex">
                        <div class="inputBox">
                            <span>State:</span>
                            <input type="text" placeholder="Enter your state...">
                        </div>
                        <div class="inputBox">
                            <span>ZIP Code:</span>
                            <input type="text" placeholder="Enter your ZIP code...">
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="col">
                    <h3 class="title">Payment</h3>
                    <div class="inputBox">
                        <span>Cards Accepted:</span>
                        <img src="./images/checkout.png" alt="Card Image">
                        <img src="./images/cash.png" alt="Card Image">
                        <img src="./images/esewa.png" alt="Card Image">
                    </div>
                    <div class="inputBox">
                        <span>Name on Card:</span>
                        <input type="text" placeholder="Enter cardholder's name...">
                    </div>
                    <div class="inputBox">
                        <span>Credit Card Number:</span>
                        <input type="text" placeholder="Enter card number...">
                    </div>
                    <div class="inputBox">
                        <span>Exp Month:</span>
                        <input type="text" placeholder="Enter expiration month...">
                    </div>
                    <div class="flex">
                        <div class="inputBox">
                            <span>Exp Year:</span>
                            <input type="text" placeholder="Enter expiration year...">
                        </div>
                        <div class="inputBox">
                            <span>CVV:</span>
                            <input type="text" placeholder="Enter CVV...">
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" value="Proceed to Checkout" class="submit">
        </form> 
    </div>
</body>
</html>
