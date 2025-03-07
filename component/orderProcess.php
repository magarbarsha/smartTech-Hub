
<?php
session_start();
require '../includes/config.php';

// if (!isset($_SESSION['id'])) {
//     header("Location: login.php"); 
//     exit();
// }

if (isset($_POST['confirm'])) {
    // print_r($_POST);
    // die;
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    $order_status = "pending";

    date_default_timezone_set("Asia/Kathmandu");
    $order_date = date('Y-m-d H:i:s');


    mysqli_autocommit($conn, false);

    $error = false;

    // Fetch cart items
    $sql = "SELECT *, card_tbl.id AS cart_id, prod.id AS product_id, prod.quantity AS available_quantity 
                FROM card_tbl
                INNER JOIN prod ON card_tbl.product_id = prod.id 
                WHERE user_id = $user_id";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($res);

    if ($num > 0) {
        $totalAmount = 0;
        $totalItems = 0;
        $orderItems = [];


        while ($row = mysqli_fetch_assoc($res)) {
            $product_id = $row['product_id'];
            $ordered_quantity = $row['product_quantity'];
            $available_quantity = $row['available_quantity'];


            if ($ordered_quantity > $available_quantity) {
                $error = true;
                $_SESSION['error'] = "Insufficient stock for product: " . $row['product_name'];
                header("Location: checkoutpage.php");
                exit();
            }

            $totalAmount += $row['price'] * $ordered_quantity;
            $totalItems += $ordered_quantity;
            $orderItems[] = $row;
        }

        if (!$error) {

            $order_number = 'ORD' . time() . $user_id;


            $insert_order_sql = "INSERT INTO orders1 (
                    order_number, user_id, ordered_date, order_status, total_amount, total_items, 
                    delivery_fullname, delivery_email, delivery_phone,
                     payment_method
                ) VALUES (
                    '$order_number', $user_id, '$order_date', '$order_status', '$totalAmount', $totalItems, 
                    '$name', '$email', '$phone', '$payment_method'
                )";

            if (mysqli_query($conn, $insert_order_sql)) {
                $order_id = mysqli_insert_id($conn);

                foreach ($orderItems as $item) {
                    $product_id = $item['product_id'];
                    $ordered_quantity = $item['product_quantity'];
                    $product_rate = $item['price'];

                    $insert_item_sql = "INSERT INTO order_items1(
                            order_id, product_id, ordered_quantity, product_rate
                        ) VALUES (
                            $order_id, $product_id, $ordered_quantity, '$product_rate'
                        )";

                    if (!mysqli_query($conn, $insert_item_sql)) {
                        $error = true;
                        break;
                    }

                    $new_quantity = $item['available_quantity'] - $ordered_quantity;
                    $update_stock_sql = "UPDATE prod SET quantity = $new_quantity WHERE id = $product_id";

                    if (!mysqli_query($conn, $update_stock_sql)) {
                        $error = true;
                        break;
                    }
                }

                if (!$error) {

                    $clear_cart_sql = "DELETE FROM card_tbl WHERE user_id = $user_id";
                    if (mysqli_query($conn, $clear_cart_sql)) {
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
        // echo "<script>alert('code is empty');</script>";
        $_SESSION['error'] = "Your cart is empty.";
        header("Location: checkoutpage.php");
        exit();
    }

    if ($error) {
        // echo "<script>alert('code is empty');</script>";
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
