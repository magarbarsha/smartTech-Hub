<?php
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] = 'POST') {
    // Get the product_id from POST
    $product_id = $_POST['product_id'];
    $sql = "SELECT * FROM prod WHERE id='$product_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result)) {
            $row = mysqli_fetch_assoc($result);
            $invoice_no = $row['id'] . time();  // Generate invoice number
            $total = $row['price'];  // Get product price
            $created_at = date('Y-m-d H:i:s');
            $query = "INSERT INTO orders (product_id, invoice_no, total, status, created_at) 
    VALUES ('$product_id', '$invoice_no', '$total', 0 , '$created_at')";
            if (!mysqli_query($conn, $query)) {
                die('eror!');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="../assets/css/productdisplay.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="dashboard-content">
        <div class="product-container">
            <div class="newc">
                <h2>Oder Details</h2>
                <div class="product-card">
                    <div class="product-img-container">
                        <img src="../uploads/<?php echo $row['product_image']; ?>"
                            alt="<?php echo $row['product_name']; ?>" class="product-img">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $row['product_name']; ?></h3>
                        <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>

                    </div>
                </div>
            </div>
            <div class="new2">
                <h3>pay with</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                            <input type="hidden" id="amount" name="amount" value="<?php echo $price?>" required>
                            <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
                            <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total;?>" required>
                            <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?php echo $invoice_no;?>" required>
                            <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
                            <input type="hidden" id="product_service_charge" name="product_service_charge" value="0"
                                required>
                            <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0"
                                required>

                            <input type="hidden" id="success_url" name="success_url"
                                value="https://developer.esewa.com.np/success" required>
                            <input type="hidden" id="failure_url" name="failure_url"
                                value="https://developer.esewa.com.np/failure" required>
                            <input type="hidden" id="signed_field_names" name="signed_field_names"
                                value="total_amount,transaction_uuid,product_code" required>
                            <input type="hidden" id="signature" name="signature"
                                value="i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=" required>
                            <input type="image" src="./images/esewa.png">
                    </li>
                    <li class="list-group-item"><input type="image" src="./images/cash.png"></li>
                    <li class="list-group-item"><input type="image" src="./images/checkout.png"></li>
                    <li class="list-group-item"><input type="image" src="./images/kalti.jpeg"></li>
                    <li class="list-group-item"><input type="image" src="./images/fonpay.png"></li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>