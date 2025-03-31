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

    // Get user details
    $selectQuery = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    
    // Get cart items
    $cartQuery = "SELECT * FROM card_tbl WHERE user_id = ?";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cartRes = $stmt->get_result();
    
    // Prepare Khalti payload
    $postFields = array(
        "return_url" => "http://localhost/SmartTech%20Hub/component/payment_response.php",
        "website_url" => "https://dev.khalti.com/api/v2/", // Changed to your actual website URL
        "amount" => $amount,
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
        CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: key 3da50215902547fa9b0b928e7fe7ab7b',
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
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
            
            header("Location: " . $res['payment_url']);
            exit();
        }
    }
    
    // If we reach here, something went wrong
    $_SESSION['error'] = "Payment initiation failed. Please try again.";
    header("Location: checkoutpage.php");
exit();
}

