<?php
session_start();
include '../includes/config.php';

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please login first!'); window.location.href='../login.php';</script>";
    exit();
}

if (isset($_POST['addtowishlist'])) { // Ensure it's coming from the correct button
    $product_id = intval($_POST['pid']); // Prevent SQL Injection
    $user_id = intval($_SESSION['id']);
    $product_quantity = isset($_POST['product_quantity']) ? intval($_POST['product_quantity']) : 1;

    // Check if the product is already in the wishlist
    $sql = "SELECT * FROM card_tbl WHERE product_id = $product_id AND user_id = $user_id";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        // Update quantity if already in wishlist
        $updateQuery = "UPDATE card_tbl SET product_quantity = product_quantity + 1 WHERE product_id = $product_id AND user_id = $user_id";
        $result = mysqli_query($conn, $updateQuery);
    } else {
        // Insert new wishlist entry
        $insertQuery = "INSERT INTO card_tbl (product_id, user_id, product_quantity) VALUES ($product_id, $user_id, $product_quantity)";
        $result = mysqli_query($conn, $insertQuery);
    }

    if ($result) {
        echo "<script>alert('Product added to wishlist'); window.location.href='./wishlistView.php';</script>";
    } else {
        echo "<script>alert('Failed to add to wishlist'); window.location.href='./cart.php';</script>";
    }
}
?>
