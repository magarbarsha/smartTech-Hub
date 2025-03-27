<?php
include '../includes/config.php';

// Check if a brand is selected from the URL
$brand_name = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';

// Correct SQL query based on the relationship between prod and branch tables
$sql = "
    SELECT prod.* 
    FROM prod
    JOIN branch ON prod.id = branch.id
    WHERE branch.brand_name = '$brand_name'
    ORDER BY prod.id DESC
";

$productResult = mysqli_query($conn, $sql);

// Debugging: Output the query to check if it is correct
// echo $sql;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($brand_name); ?> Products</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
</head>
<body>

<div class="container">
    <h2>Products for <?php echo htmlspecialchars($brand_name); ?></h2>

    <div class="product-list">
        <?php
        if (mysqli_num_rows($productResult) > 0) {
            while ($product = mysqli_fetch_assoc($productResult)) {
                echo "<div class='product-card'>";
                echo "<h3>" . htmlspecialchars($product['product_name']) . "</h3>"; 
                echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                echo "<p>Price: $" . number_format($product['price'], 2) . "</p>";
                echo "<p>Brand: " . htmlspecialchars($product['brand_name']) . "</p>";  
                echo "</div>";
            }
        } else {
            echo "<p>No products found for this brand.</p>";
        }
        ?>
    </div>
</div>

<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
