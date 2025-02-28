<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include './includes/config.php';
// Sanitize the email input to prevent SQL injection
$email = mysqli_real_escape_string($conn, $_POST['email']);

$res = mysqli_query($conn, "SELECT * FROM user_otp WHERE email='$email'");
$count = mysqli_num_rows($res);

if ($count > 0) {
    $otp = rand(11111, 99999);
    mysqli_query($conn, "UPDATE user_otp SET otp='$otp' WHERE email='$email'");
    
    $html = "Your OTP verification code is: " . $otp;
    
    // Send the OTP email
    if (smtp_mailer($email, 'OTP Verification', $html)) {
        echo "yes";
    } else {
        echo "Failed to send OTP";
    }
} else {
    echo "Email does not exist";
}



// SMTP email function
function smtp_mailer($to, $subject, $msg) {

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;  
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'TLS';
    $mail->Host = "smtp.sendgrid.net"; // Correct SendGrid SMTP server
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->Charset = 'UTF-8';

    // Set the credentials for SendGrid (use environment variables for security in production)
    $mail->Username = "magarbarsha333@gmail.com"; // This is the SendGrid API key username (it’s literally 'apikey')
    $mail->Password = "Bhagimayamagar123"; // Use your SendGrid API key here
    $mail->SetFrom("magarbarsha333@gmail.com"); // Sender's email address
    
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);

    // Send email and return success/failure
    return $mail->Send() ? 1 : 0;
}
?>
