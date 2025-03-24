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
    <title>Payment Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="mb-0">Payment Verification</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>