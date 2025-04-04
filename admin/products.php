<?php
include '../includes/config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all brands
$brandQuery = "SELECT * FROM branch";
$brandResult = $conn->query($brandQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Store</title>
    <style>
        .brand-logo { cursor: pointer; width: 100px; }
        .product-card { border: 1px solid #ddd; padding: 10px; margin: 10px; display: inline-block; }
    </style>
</head>
<body>

    <h1>Select a Brand</h1>
    
    <!-- Display Brand Logos -->
    <div id="brands">
        <?php while ($brand = $brandResult->fetch_assoc()) { ?>
            <img class="brand-logo" src="uploads/<?php echo $brand['brand_logo']; ?>" alt="<?php echo $brand['brand_name']; ?>" data-brand="<?php echo $brand['id']; ?>">
        <?php } ?>
    </div>

    <div id="product-list"></div>

    <script>
        document.querySelectorAll(".brand-logo").forEach(function(logo) {
            logo.addEventListener("click", function() {
                var brandId = logo.getAttribute("data-brand");

                // Fetch products for the selected brand
                fetch("fetch_products.php?brand_id=" + brandId)
                    .then(response => response.json())
                    .then(products => {
                        let output = "";
                        products.forEach(product => {
                            output += `
                                <div class="product-card">
                                    <img src="uploads/${product.product_image}" width="100"><br>
                                    <b>${product.product_name}</b><br>
                                    Price: $${product.price}<br>
                                    Quantity: ${product.quantity}<br>
                                    Description: ${product.description}
                                </div>
                            `;
                        });
                        document.getElementById("product-list").innerHTML = output;
                    });
            });
        });
    </script>

</body>
</html>
