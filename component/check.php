<?php
include '../includes/config.php';

$name = $email = $phone = $gender = '';
$password = $confirm_password = '';

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Secure query using prepared statements
    $sql = "SELECT name, email, phone, gender FROM card_tbl WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $gender = $row['gender'];
    } else {
        echo "<script>alert('No user found.');</script>";
    }
} else {
    echo "<script>alert('User ID not set or empty.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .checkout-container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .gender-selection {
            margin-bottom: 15px;
        }
        .gender-options {
            display: flex;
            gap: 10px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .confirm-btn {
            background-color: #d4a041;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            width: 48%;
        }
        .reset-btn {
            background-color: #777;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            width: 48%;
        }
    </style>
</head>
<body>

    <div class="checkout-container">
        <h2>Checkout Page</h2>
        <form action="../admin/customeregister.php" method="post">
            <!-- Hidden field to store user ID -->
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="input-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>"> 
            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <div class="gender-selection">
                <label>Gender</label>
                <div class="gender-options">
                    <input type="radio" name="gender" value="female" <?= ($gender == 'female') ? 'checked' : '' ?>>
                    <label>Female</label>

                    <input type="radio" name="gender" value="male" <?= ($gender == 'male') ? 'checked' : '' ?>>
                    <label>Male</label>

                    <input type="radio" name="gender" value="others" <?= ($gender == 'others') ? 'checked' : '' ?>>
                    <label>Others</label>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" name="confirm_order" class="confirm-btn">Confirm Order</button>
                <button type="reset" class="reset-btn">Reset</button>
            </div>
        </form>
    </div>

</body>
</html>
