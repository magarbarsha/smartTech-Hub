<?php
// Include Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use KhaltiSDK\Khalti;
use KhaltiSDK\Exceptions\ValidationException;
use KhaltiSDK\Exceptions\ApiException;
use KhaltiSDK\Exceptions\NetworkException;
use KhaltiSDK\Exceptions\ConfigurationException;

// Initialize Khalti SDK
$khalti = new Khalti([
    'environment' => 'sandbox', // Use 'live' for production
    'secretKey' => 'live_secret_key_3da50215902547fa9b0b928e7fe7ab7b', // Replace with your test secret key
    'publicKey' => 'test_public_key_16f12f9286a34166aa47b1740ccb9435', // Replace with your test public key
    'enableLogging' => true,
    'logPath' => __DIR__ . '/khalti.log'
]);

// Process form submission
$message = '';
$paymentUrl = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['initiate_payment'])) {
    try {
        // Prepare payment parameters
        $params = [
            'return_url' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/verify_payment.php?verify=true',
            'website_url' => 'http://' . $_SERVER['HTTP_HOST'],
            'amount' => (int)($_POST['amount'] * 100), // Convert to paisa
            'purchase_order_id' => 'ORDER-' . time(),
            'purchase_order_name' => $_POST['product_name'],
            'customer_info' => [
                'name' => $_POST['customer_name'],
                'email' => $_POST['customer_email'],
                'phone' => $_POST['customer_phone']
            ]
        ];

        // Initiate payment
        $response = $khalti->ePayment()->initiate($params);
        print_r($response); // Log the response
        
        // Store payment details in session for verification
        session_start();
        $_SESSION['khalti_payment'] = [
            'purchase_order_id' => $params['purchase_order_id'],
            'amount' => $params['amount']
        ];
        
        // Redirect to payment URL
        if (isset($response['payment_url'])) {
            header('Location: ' . $response['payment_url']);
            exit;
        } else {
            $error = "Payment initiation successful but no payment URL returned.";
        }
    } catch (ValidationException $e) {
        $error = "Validation Error: " . $e->getMessage();
    } catch (ApiException $e) {
        $error = "API Error (" . $e->getCode() . "): " . $e->getMessage();
    } catch (NetworkException $e) {
        $error = "Network Error: " . $e->getMessage();
    } catch (ConfigurationException $e) {
        $error = "Configuration Error: " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Verify payment
if (isset($_GET['verify']) && $_GET['verify'] === 'true' && isset($_GET['pidx'])) {
    try {
        $pidx = $_GET['pidx'];
        
        // Verify payment
        $response = $khalti->ePayment()->verify($pidx);
        
        // Process verification response
        if (isset($response['status']) && $response['status'] === 'Completed') {
            $message = "Payment successful! Transaction ID: " . ($response['transaction_id'] ?? 'N/A');
        } else {
            $error = "Payment verification failed. Status: " . ($response['status'] ?? 'Unknown');
        }
    } catch (Exception $e) {
        $error = "Verification Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti PHP SDK Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 2rem;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #5C2D91;
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background-color: #5C2D91;
            border-color: #5C2D91;
        }
        .btn-primary:hover {
            background-color: #4A2275;
            border-color: #4A2275;
        }
        .test-credentials {
            background-color: #f0f0f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .test-credentials code {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="mb-0">Khalti PHP SDK Test</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <div class="test-credentials">
                            <h5>Test Credentials</h5>
                            <code>Phone Number: 9800000001</code>
                            <code>MPIN: 1111</code>
                            <code>OTP: 987654</code>
                        </div>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="Test Product" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (NPR)</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="10" min="10" step="1" required>
                                <small class="text-muted">Minimum amount: 10 NPR</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="John Doe" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Customer Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" value="john@example.com" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Customer Phone</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="9800000001" required>
                            </div>
                            
                            <button type="submit" name="initiate_payment" class="btn btn-primary">Pay with Khalti</button>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">SDK Information</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Environment:</strong> Sandbox</p>
                        <p><strong>Return URL:</strong> <?php echo 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/verify_payment.php?verify=true'; ?></p>
                        <p><strong>Log Path:</strong> <?php echo __DIR__ . '/khalti.log'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>