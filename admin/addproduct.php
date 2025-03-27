<?php
require '../includes/config.php';

if (isset($_POST['add_product'])) {
    // Retrieve form data and escape it to prevent SQL injection
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $brand_id = $_POST['brand']; // ID of the selected brand

    // Validate that all required fields are filled
    if (!empty($product_name) && !empty($description) && !empty($price) && !empty($brand_id)) {

        // Check if the selected brand exists in the branch table
        $check_brand_query = "SELECT * FROM branch WHERE id = '$brand_id'";
        $check_result = mysqli_query($conn, $check_brand_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Insert the data into the prod table
            $insert_query = "INSERT INTO prod (product_name, description, price, brand_id) 
                             VALUES ('$product_name', '$description', '$price', '$brand_id')";

            if (mysqli_query($conn, $insert_query)) {
                echo "Product added successfully!";
            } else {
                // Output any error that occurs during the insertion
                if (mysqli_errno($conn) == 1452) { // Foreign key constraint error code
                    echo "Error: The selected brand does not exist or is invalid.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error: Selected brand ID does not exist in the branch table!";
        }
    } else {
        echo "Please fill all fields!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>

<form action="addProduct.php" method="POST">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required>
    
    <label for="description">Product Description:</label>
    <textarea name="description" required></textarea>
    
    <label for="price">Product Price:</label>
    <input type="number" name="price" step="0.01" required>
    
    <label for="brand">Select Brand:</label>
    <select name="brand" required>
        <?php
        // Fetch all brands
        $brands_query = "SELECT id, brand_name FROM branch";
        $brands_result = mysqli_query($conn, $brands_query);
        while ($brand = mysqli_fetch_assoc($brands_result)) {
            echo "<option value='" . $brand['id'] . "'>" . $brand['brand_name'] . "</option>";
        }
        ?>
    </select>
    
    <button type="submit" name="add_product">Add Product</button>
</form>

</body>
</html>
