<?php
 include '../includes/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO subscribers (email) VALUES ('$email')";

    if ($conn->query($sql) === TRUE) {
        // Notify admin (example using mail function)
        $admin_email = "magarbarsha333@gmail.com";
        $subject = "New Subscriber";
        $message = "You have a new subscriber: " . $email;
        $headers = "From: $email";

        if (mail($admin_email, $subject, $message, $headers)) {
            echo "Thank you! You will be notified when we launch.";
        } else {
            echo "Thank you! You will be notified when we launch. (Admin notification failed)";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method";
}
?>