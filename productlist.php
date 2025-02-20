<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Basic reset and body setup */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f7f9;
            padding: 20px;
        }

        /* Product list container */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin: 0;
        }

        /* Individual product card */
        .product-card {
            background-color: #fff;
            border-radius: 10px;
            width: 24%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        /* Image section */
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Product details section */
        .product-card .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.1rem;
            color: #ff9900;
            margin-bottom: 15px;
        }

        /* Action buttons */
        .product-actions {
            display: flex;
            justify-content: space-between;
        }

        .product-actions button, .heart {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .product-actions button:hover, .heart:hover {
            background-color: #0056b3;
        }

        .heart {
            background-color: transparent;
            font-size: 1.5rem;
            color: #ff0000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-card {
                width: 48%;
            }
        }

        @media (max-width: 480px) {
            .product-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1>Product List</h1>

    <div class="product-list" id="productList">
        <!-- Product Cards will be dynamically generated here -->
    </div>

    <script>
        const products = [
            {
                name: "Lenovo Gaming Laptop",
                price: 999.99,
                img: "dell.jpg"
            },
            {
                name: "Acer Predator",
                price: 1299.99,
                img: "https://via.placeholder.com/400x300?text=Acer+Predator"
            },
            {
                name: "HP Omen",
                price: 1499.99,
                img: "https://via.placeholder.com/400x300?text=HP+Omen"
            },
            {
                name: "Dell G5",
                price: 1099.99,
                img: "https://via.placeholder.com/400x300?text=Dell+G5"
            }
        ];

        const cart = [];
        const wishlist = [];

        const productListElement = document.getElementById('productList');

        // Function to display products
        function displayProducts() {
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');

                productCard.innerHTML = `
                    <img src="${product.img}" alt="${product.name}">
                    <div class="product-info">
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">$${product.price.toFixed(2)}</div>
                        <div class="product-actions">
                            <button onclick="addToCart('${product.name}')">Add to Cart</button>
                            <button class="heart" onclick="addToWishlist('${product.name}')"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                `;
                productListElement.appendChild(productCard);
            });
        }

        // Function to add product to cart
        function addToCart(productName) {
            const product = products.find(p => p.name === productName);
            if (!cart.some(item => item.name === productName)) {
                cart.push(product);
                alert(`${productName} added to cart`);
            } else {
                alert(`${productName} is already in the cart`);
            }
        }

        // Function to add product to wishlist
        function addToWishlist(productName) {
            const product = products.find(p => p.name === productName);
            if (!wishlist.some(item => item.name === productName)) {
                wishlist.push(product);
                alert(`${productName} added to wishlist`);
            } else {
                alert(`${productName} is already in your wishlist`);
            }
        }

        // Initialize product list
        displayProducts();
    </script>

</body>
</html>
