<?php
session_start();
include '../includes/config.php';

if(isset($_POST['submit'])){
    // Get user details using prepared statements
    $user_id = $_SESSION['id'];
    
    // Validate and sanitize all inputs
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
    $purchase_order_id = filter_var($_POST['purchase_order_id'], FILTER_SANITIZE_STRING);
    $purchase_order_name = filter_var($_POST['purchase_order_name'], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

    // Validate amount (minimum 10 NPR for Khalti)
    if ($amount < 10) {
        $_SESSION['error'] = "Minimum payment amount is 10 NPR";
        header("Location: checkoutpage.php");
        exit();
    }

    // Get user details
    $selectQuery = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        $_SESSION['error'] = "Database error. Please try again.";
        header("Location: checkoutpage.php");
        exit();
    }
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    
    // Get cart items to verify cart exists
    $cartQuery = "SELECT * FROM card_tbl WHERE user_id = ?";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        $_SESSION['error'] = "Could not verify your cart items.";
        header("Location: checkoutpage.php");
        exit();
    }
    $cartRes = $stmt->get_result();
    
    if ($cartRes->num_rows === 0) {
        $_SESSION['error'] = "Your cart is empty.";
        header("Location: checkoutpage.php");
        exit();
    }
    
    // Prepare Khalti payload
    $postFields = array(
        "return_url" => "http://localhost/SmartTech%20Hub/component/payment_response.php",
        "website_url" => "https://dev.khalti.com/api/v2/", // Change to your actual website
        "amount" => $amount * 100, // Khalti expects amount in paisa
        "purchase_order_id" => $purchase_order_id,
        "purchase_order_name" => $purchase_order_name,
        "customer_info" => array(
            "name" => $name,
            "email" => $email,
            "phone" => $phone
        )
    );

    $jsonData = json_encode($postFields);

    // Initiate cURL request to Khalti
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/', // Changed from dev.khalti to a.khalti
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30, // Reduced timeout
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: key 3da50215902547fa9b0b928e7fe7ab7b', // Make sure this is your live/test secret key
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);
    
    if ($curlError) {
        error_log("cURL Error: " . $curlError);
        $_SESSION['error'] = "Payment gateway connection failed. Please try again.";
        header("Location: checkoutpage.php");
        exit();
    }
    
    if ($httpCode === 200) {
        $res = json_decode($response, true);
        if(isset($res['payment_url'])) {
            // Store order details in session for verification later
            $_SESSION['order_details'] = [
                'amount' => $amount,
                'purchase_order_id' => $purchase_order_id,
                'user_id' => $user_id,
                'customer_info' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address
                ]
            ];
            
            // Store pidx in session for verification
            $_SESSION['order_details']['pidx'] = $res['pidx'];
            
            header("Location: " . $res['payment_url']);
            exit();
        } else {
            error_log("Khalti API Error: " . print_r($res, true));
            $_SESSION['error'] = "Payment initiation failed. " . ($res['detail'] ?? 'Please try again.');
            header("Location: checkoutpage.php");
            exit();
        }
    } else {
        error_log("Khalti API HTTP Error: $httpCode, Response: $response");
        $_SESSION['error'] = "Payment gateway returned an error (HTTP $httpCode). Please try again.";
        header("Location: checkoutpage.php");
        exit();
    }
}