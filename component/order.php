<?php
session_start();
include '../includes/config.php';
if (isset($_POST['confirm'])) {
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $order_status = "Pending";
    date_default_timezone_set('Asia/Kolkata');
    $order_date = date('Y-m-d H:i:s');
    mysqli_autocommit($con, false);
    $error = false;
    $sql = "SELECT *, card_tbl.id AS cart_id , prod.id AS product_id, prod.quantity AS available_quantity FROM card_tbl INNER JOIN prod ON card_tbl.product_id=prod.id WHERE user_id=$user_id";
    $res = mysqli_query($con, $sql);
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
                $_SESSION['error'] = "Insufficient stock for " . $row['product_name'];
                header("location: checkoutpage.php");
                exit();
            }
            $totalAmount += $row['product_price'] * $ordered_quantity;
            $totalItems += $ordered_quantity;
            $orderItems[] = $row;
        }
        if (!$error) {
            $ordered_number = 'ORD' . time() . $user_id;
            $insert_order_sql = "INSERT INTO orders1 (order_number,user_id,ordered_date,order_status,total_amount,total_items,delivery_name,delivery_email,delivery_phone,delivery_address,payment_method) VALUES ('$ordered_number','$user_id','$order_date','$order_status','$totalAmount','$totalItems','$name','$email','$phone','$address','$payment_method')";
            if (mysqli_query($con, $insert_order_sql)) {
                $order_id = mysqli_insert_id($con);
                foreach ($orderItems as $item) {
                    $product_id = $item['product_id'];
                    $product_quantity = $item['product_quantity'];
                    $product_rate = $item['price'];

                    $insert_item_sql = "INSERT INTO order_items1 (order_id,product_id,order_quantity,product_rate) VALUES ('$order_id','$product_id','$order_quantity','$product_rate')";
                    if (!mysqli_query($con, $insert_item_sql)) {
                        $error = true;
                        break;
                    }
                    $new_quantity = $item['available_quantity'] - $order_quantity;
                    $update_stock_sql = "UPDATE prod SET quantity='$new_quantity' WHERE id='$product_id'";
                    if (!mysqli_query($con, $update_stock_sql)) {
                        $error = true;
                        break;
                    }
                }

                if (!$error) {
                    $clear_cart_sql = "DELETE FROM card_tbl WHERE user_id='$user_id'";
                    if (mysqli_query($con, $clear_cart_sql)) {
                        mysqli_commit($con);
                        $_SESSION['success'] = "Order placed successfully! your order number is " . $ordered_number;
                        header("location: orderConfirmation.php");
                        exit();
                    } else {
                        $error = true;
                    }
                }
            } else {
                $error = true;
            }
        } else {
            $_SESSION['error'] = "Your cart is empty";
            header("location: checkoutpage.php");
            exit();
        }
        if ($error) {
            mysqli_rollback($con);
            $_SESSION['error'] = "failed to place order. Please try again";
            header("location: checkoutpage.php");
            exit();
        }
        mysqli_autocommit($con, true);
    } else {
        header("location: checkoutpage.php");
        exit();
    }
}
