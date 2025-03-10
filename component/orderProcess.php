<?php
session_start();
require '../includes/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    $_SESSION['error'] = "Please log in to place an order.";
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    $user_id = $_SESSION['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $order_status = "pending";

    date_default_timezone_set("Asia/Kathmandu");
    $order_date = date('Y-m-d H:i:s');

    // Start transaction
    mysqli_autocommit($conn, false);
    $error = false;

    // Fetch cart items securely
    $sql = "SELECT *, card_tbl.id AS cart_id , prod.id AS product_id, prod.quantity AS available_quantity FROM card_tbl INNER JOIN prod ON card_tbl.product_id=prod.id WHERE user_id=$user_id";
    
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $totalAmount = 0;
        $totalItems = 0;
        $orderItems = [];

        while ($row = mysqli_fetch_assoc($res)) {
            if ($row['product_quantity'] > $row['available_quantity']) {
                $error = true;
                $_SESSION['error'] = "Insufficient stock for product: " . $row['product_name'];
                header("Location: checkoutpage.php");
                exit();
            }

            $totalAmount += $row['price'] * $row['product_quantity'];
            $totalItems += $row['product_quantity'];
            $orderItems[] = $row;
        }

        if (!$error) {
            $order_number = 'ORD' . time() . $user_id;

            // Insert order
            $insert_order_sql = "INSERT INTO orders1 (
                                    order_number, user_id, ordered_date, order_status, total_amount, total_items, 
                                    delivery_name, delivery_email, delivery_phone, payment_method
                                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $insert_order_sql);
            mysqli_stmt_bind_param($stmt, "sissdissss", $order_number, $user_id, $order_date, $order_status, 
                                  $totalAmount, $totalItems, $name, $email, $phone, $payment_method);

            if (mysqli_stmt_execute($stmt)) {
                $order_id = mysqli_insert_id($conn);

                foreach ($orderItems as $item) {
                    // Insert order items
                    $insert_item_sql = "INSERT INTO order_items1 (order_id, product_id, ordered_quantity, product_rate)
                                        VALUES (?, ?, ?, ?)";

                    $stmt = mysqli_prepare($conn, $insert_item_sql);
                    mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['product_id'], 
                                          $item['product_quantity'], $item['price']);

                    if (!mysqli_stmt_execute($stmt)) {
                        $error = true;
                        break;
                    }

                    // Update stock
                    $new_quantity = $item['available_quantity'] - $item['product_quantity'];
                    $update_stock_sql = "UPDATE prod SET quantity = ? WHERE id = ?";

                    $stmt = mysqli_prepare($conn, $update_stock_sql);
                    mysqli_stmt_bind_param($stmt, "ii", $new_quantity, $item['product_id']);

                    if (!mysqli_stmt_execute($stmt)) {
                        $error = true;
                        break;
                    }
                }

                if (!$error) {
                    // Clear cart
                    $clear_cart_sql = "DELETE FROM card_tbl WHERE user_id = ?";
                    $stmt = mysqli_prepare($conn, $clear_cart_sql);
                    mysqli_stmt_bind_param($stmt, "i", $user_id);

                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_commit($conn);
                        $_SESSION['success'] = "Order placed successfully! Your order number is: $order_number";
                        header("Location: orderConfirmation.php");
                        exit();
                    } else {
                        $error = true;
                    }
                }
            } else {
                $error = true;
            }
        }
    } else {
        $_SESSION['error'] = "Your cart is empty.";

        header("Location: checkoutpage.php");
        exit();
    }

    if ($error) {
        mysqli_rollback($conn);

        $_SESSION['error'] = "Failed to place order. Please try again.";
        header("Location: checkoutpage.php");
        exit();
    }

    mysqli_autocommit($conn, true);
} else {

    header("Location: checkoutpage.php");
    exit();
}
