<?php

// Author: Samir Khanal
$error_message = "";
$khalti_public_key = "test_public_key_dc74e0fd57cb46cd93832aee0a390234"; // Replace this with your actual Khalti public key

// Run your code here to get your amount and product id and product URL. Change this dynamically.
// ------------------------------------------------------------------------
// CHANGE THE CODE BELOW, e.g. you can get product price and ID from here and set these variables.
// Do not change variable names unless you change everything below
// ------------------------------------------------------------------------

$amount = 10; // Product price in rupees
$uniqueProductId = "nike-shoes"; // Product unique ID
$uniqueUrl = "http://localhost/product/nike-shoes/"; // Product URL
$uniqueProductName = "Nike shoes"; // Product name
$successRedirect = "http://localhost/SmartTech%20Hub/component/index2.php"; // Redirect URL after successful payment

// ------------------------------------------------------------------------
// HINT: Just change price above and redirect user to this page. It will handle everything automatically.
// ------------------------------------------------------------------------

function checkValid($data)
{
    $expectedAmount = 10 * 100; // Convert to paisa (Khalti returns amount in paisa, so 10 rupees = 1000 paisa)

    if ((float) $data["amount"] == $expectedAmount) {
        return 1; // Success
    } else {
        return 0; // Error
    }
}

// ------------------------------------------------------------------------
// DO NOT CHANGE THE CODE BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
// ------------------------------------------------------------------------

$token = "";
$price = $amount * 100; // Convert to paisa (100 paisa = 1 rupee)
$mpin = "";

// Send OTP
if (isset($_POST["mobile"]) && isset($_POST["mpin"])) {
    try {
        $mobile = $_POST["mobile"];
        $mpin = $_POST["mpin"];

        if (strlen($mobile) !== 10 || !is_numeric($mobile)) {
            $error_message = "Invalid mobile number.";
        } elseif (strlen($mpin) < 4 || strlen($mpin) > 6) {
            $error_message = "Invalid MPIN length.";
        } else {
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://khalti.com/api/v2/payment/initiate/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode([
                        "public_key" => $khalti_public_key,
                        "mobile" => $mobile,
                        "transaction_pin" => $mpin,
                        "amount" => $price,
                        "product_identity" => $uniqueProductId,
                        "product_name" => $uniqueProductName,
                        "product_url" => $uniqueUrl
                    ]),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ),
                )
            );

            $response = curl_exec($curl);
            curl_close($curl);

            $parsed = json_decode($response, true);

            if (key_exists("token", $parsed)) {
                $token = $parsed["token"];
            } else {
                $error_message = "Incorrect mobile number or MPIN.";
            }
        }
    } catch (Exception $e) {
        $error_message = "Incorrect mobile number or MPIN.";
    }
}

// OTP verification
if (isset($_POST["otp"]) && isset($_POST["token"]) && isset($_POST["mpin"])) {
    try {
        $otp = $_POST["otp"];
        $token = $_POST["token"];
        $mpin = $_POST["mpin"];

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://khalti.com/api/v2/payment/confirm/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "public_key" => $khalti_public_key,
                    "transaction_pin" => $mpin,
                    "confirmation_code" => $otp,
                    "token" => $token
                ]),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $parsed = json_decode($response, true);

        if (key_exists("token", $parsed)) {
            $isvalid = checkValid($parsed);
            if ($isvalid) {
                $error_message = "<span style='color:green'>Payment success</span> <script> window.location='" . $successRedirect . "'; </script>";
            }
        } else {
            $error_message = "Could not process the transaction at the moment.";
            if (key_exists("detail", $parsed)) {
                $error_message = $parsed["detail"];
            }
        }
    } catch (Exception $e) {
        $error_message = "Could not process the transaction at the moment.";
    }
}
?>

<div class="khalticontainer">
    <center>
        <div><img src="./images/khalti.png" alt="khalti" width="200"></div>
    </center>
    <?php
    if ($token == "") {
        ?>
    <form action="pay.php" method="post">
        <small>Mobile Number:</small> <br>
        <input type="number" class="number" minlength="10" maxlength="10" name="mobile" placeholder="98xxxxxxxx">
        <small>Khalti MPIN:</small> <br>
        <input type="password" class="mpin" name="mpin" minlength="4" maxlength="6" placeholder="xxxx">
        <small>Price:</small> <br>
        <input type="text" class="price" value="Rs. <?php echo $amount; ?>" disabled>
        <input type="hidden" class="price" name="amount" value="<?php echo $amount; ?>">
        <br>
        <span style="display:block;color:red;">
            <?php echo $error_message; ?>
        </span>
        <button>Pay Rs. <?php echo $amount; ?></button>
        <br>
        <small>We don't store your credentials for security reasons. You will have to reenter your details every time.</small>
    </form>
    <?php } ?>
    <?php
    if ($token != "") {
        ?>
    <form action="pay.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="hidden" name="mpin" value="<?php echo $mpin; ?>">
        <small>OTP:</small> <br>
        <input type="number" value="" name="otp" placeholder="xxxx">
        <span style="display:block;color:red;">
            <?php echo $error_message; ?>
        </span>
        <button>Pay Rs. <?php echo $amount; ?></button>
    </form>
    <?php
    } ?>
</div>

<style>
.khalticontainer {
    width: 300px;
    border: 2px solid #5C2D91;
    margin: 0 auto;
    padding: 8px;
}

input {
    display: block;
    width: 98%;
    padding: 8px;
    margin: 2px;
}

button {
    display: block;
    background-color: #5C2D91;
    border: none;
    color: white;
    cursor: pointer;
    width: 98%;
    padding: 8px;
    margin: 2px;
}

button:hover {
    opacity: 0.8;
}
</style>
