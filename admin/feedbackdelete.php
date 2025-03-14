<?php
session_start();
include '../includes/config.php';

if (isset($_POST['delete'])) {
    $message_id = $_POST['message_id'];
    $sql = "DELETE FROM contact WHERE id = $message_id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "<script>alert('Message deleted successfully.'); window.location.href='feedback.php';</script>";
    } else {
        echo "<script>alert('Failed to delete message.'); window.location.href='feedback.php';</script>";
    }
}
?>
