<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>
    <style>
    /* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.featured {
    padding: 20px;
    text-align: center;
}

.featured h2 {
    font-size: 24px;
    text-transform: uppercase;
    margin-bottom: 40px;
    color: #333;
    position: relative;
    display: inline-block;
    letter-spacing: 2px;
}

.featured h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background-color: #e60000;
}

/* Product Container */
.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-bottom: 40px;
}

/* Product Card */
.product-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
    text-align: center;
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-card img {
    width: 100%;
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.product-card img:hover {
    transform: scale(1.05);
}

.product-card h3 {
    font-size: 16px;
    margin: 15px 0;
    color: #333;
}

.product-card p {
    font-size: 20px;
    color: #666;
}

.price {
    font-size: 18px;
    color: #e60000;
    font-weight: bold;
}

.old-price {
    text-decoration: line-through;
    color: #999;
    font-size: 14px;
    margin-left: 5px;
}

.discount {
    font-size: 14px;
    color: green;
    font-weight: bold;
}

.featured-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: orange;
    color: white;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    animation: fadeIn 0.8s ease-in-out;
}

/* Badge Animation */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover Effect for Discount and Price */
.product-card:hover .discount {
    color: #e60000;
    font-size: 16px;
    transition: all 0.3s ease;
}

.product-card:hover .price {
    color: #e60000;
    font-size: 20px;
    transition: all 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-container {
        flex-direction: column;
        align-items: center;
    }

    .product-card {
        width: 90%;
    }
}
</style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <section class="featured">
        <h2>Featured Products</h2>
        <div class="product-container">
            
            <!-- Product 1 -->
            <div class="product-card">
                <span class="featured-badge">Featured</span>
                <img src="./images/feature4.jpeg" alt="Laptop 1">
                <h3>Lenovo IdeaPad Slim 3</h3>
                <p>Intel i5-13240H 13th Gen / 8GB RAM / 512GB SSD</p>
                <p class="price">NPR 69,490.00 <span class="old-price">NPR 78,490.00</span></p>
                <p class="discount">11% Off</p>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <span class="featured-badge">Featured</span>
                <img src="./images/asus3.jpeg" alt="Laptop 2">
                <h3>ASUS VivoBook 16X</h3>
                <p>Intel i7-150U 14th Gen / 16GB RAM / 1TB SSD</p>
                <p class="price">NPR 129,990.00 <span class="old-price">NPR 144,990.00</span></p>
                <p class="discount">10% Off</p>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <span class="featured-badge">Featured</span>
                <img src="./images/feature1.jpeg" alt="Laptop 3">
                <h3>Asus Zenbook Flip 15</h3>
                <p>AMD Ryzen 7 / 8GB RAM / 256GB SSD</p>
                <p class="price">NPR 104,990.00 <span class="old-price">NPR 139,000.00</span></p>
                <p class="discount">24% Off</p>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <span class="featured-badge">Featured</span>
                <img src="./images/feature2.jpeg" alt="Laptop 4">
                <h3>HP Envy x360</h3>
                <p>Intel i7-150U / 16GB RAM / 512GB SSD</p>
                <p class="price">NPR 114,990.00 <span class="old-price">NPR 134,990.00</span></p>
                <p class="discount">15% Off</p>
            </div>

            <!-- Product 5 -->
            <div class="product-card">
                <span class="featured-badge">Featured</span>
                <img src="./images/feature3.jpeg" alt="Laptop 5">
                <h3>HP Victus Gaming</h3>
                <p>AMD Ryzen 7 / 16GB RAM / 512GB SSD / RTX 4070</p>
                <p class="price">NPR 159,990.00 <span class="old-price">NPR 184,990.00</span></p>
                <p class="discount">14% Off</p>
            </div>

        </div>
    </section>

</body>
</html>
