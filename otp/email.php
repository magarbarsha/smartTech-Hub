<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

function send_otp($to, $subject, $content) {
    $mail = new PHPMailer(true);

    try {
        // Enable debugging (0 = off, 1 = commands, 2 = data and commands)
        $mail->SMTPDebug = 2;  
        $mail->Debugoutput = 'html';  // Show debug output in HTML format

        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'magarbarsha333@gmail.com'; // Your email
        $mail->Password = 'vcbbvlvkxbffjdtz'; // Your App Password (Do not use your real password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('magarbarsha333@gmail.com', 'OTP FOR LOGIN');
        $mail->addAddress($to, 'verify email'); 

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<font color='green' size='5'>Your OTP for Login:".$content."<br>
        This OTP is Valid For Only One Time.</font>";  // Corrected issue (previously was `$mail->body`)

        // Send Email and return success/failure
        if ($mail->send()) {
            return true;
        } else {
            error_log("Mailer Error: " . $mail->ErrorInfo);  // Log errors
            return false;
        }
    } catch (Exception $e) {
        error_log("Mailer Exception: " . $e->getMessage());  // Log exceptions
        return false;
    }
}
?>
