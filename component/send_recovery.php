<?php
include 'db_connect.php';

// AI Logic: Only target carts abandoned >1 hour but <24 hours
$query = "
    SELECT * FROM abandoned_carts 
    WHERE recovery_sent = FALSE 
    AND abandoned_at BETWEEN DATE_SUB(NOW(), INTERVAL 24 HOUR) AND DATE_SUB(NOW(), INTERVAL 1 HOUR)
";
$result = $conn->query($query);

while ($cart = $result->fetch_assoc()) {
    $cart_items = json_decode($cart['cart_data'], true);
    
    // AI Rule: Bigger cart = Bigger discount (5% to 15%)
    $cart_total = array_sum(array_column($cart_items, 'price'));
    $discount = ($cart_total > 1000) ? 15 : ($cart_total > 500 ? 10 : 5);
    $discount_code = "RECOVER" . rand(1000, 9999);

    // Update DB with discount code
    $update = $conn->prepare("
        UPDATE abandoned_carts 
        SET recovery_sent = TRUE, discount_code = ?
        WHERE id = ?
    ");
    $update->bind_param("si", $discount_code, $cart['id']);
    $update->execute();

    // Send Email
    if ($cart['email']) {
        $subject = "Complete Your Purchase – {$discount}% OFF!";
        $message = generate_recovery_email($cart_items, $discount_code, $discount);
        send_email($cart['email'], $subject, $message);
    }

    // Send SMS (Twilio API Example)
    if ($cart['phone']) {
        $sms_body = "Your cart is waiting! Use {$discount_code} for {$discount}% OFF. Shop now: [LINK]";
        send_sms($cart['phone'], $sms_body);
    }
}

// Helper Functions
function generate_recovery_email($cart_items, $code, $discount) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .cart-item { border-bottom: 1px solid #eee; padding: 10px; }
            .discount-box { background: #f8f8f8; padding: 15px; text-align: center; }
        </style>
    </head>
    <body>
        <h2>Your Cart is Waiting! 🚀</h2>
        <p>Complete your purchase now and get <strong>{$discount}% OFF</strong>!</p>
        
        <div class="discount-box">
            <h3>Use Code: <span style="color: red;">{$code}</span></h3>
        </div>
        
        <h3>Your Selected Items:</h3>
        <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
                <img src="<?= $item['image'] ?>" width="50">
                <strong><?= $item['name'] ?></strong> - $<?= $item['price'] ?>
            </div>
        <?php endforeach; ?>
        
        <a href="https://yourwebsite.com/checkout?recovery=1" style="background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">
            Complete Purchase Now
        </a>
    </body>
    </html>
    <?php return ob_get_clean();
}

function send_email($to, $subject, $message) {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);
}

function send_sms($phone, $message) {
    // Example using Twilio (requires Twilio SDK)
    require_once 'twilio-php/src/Twilio/autoload.php';
    $client = new Twilio\Rest\Client('ACCOUNT_SID', 'AUTH_TOKEN');
    $client->messages->create(
        $phone,
        ['from' => '+1234567890', 'body' => $message]
    );
}
?>