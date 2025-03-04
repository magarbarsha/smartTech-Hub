<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTech Hub - Blog</title>
    <!-- Link to your main CSS file -->
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Blog-specific CSS -->
    <style>
        /* Blog Page Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }

        .blog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .blog-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .blog-header h1 {
            font-size: 2.5rem;
            color: #007bff;
        }

        .blog-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .blog-posts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .blog-post {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .blog-post:hover {
            transform: translateY(-5px);
        }

        .blog-post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-post-content {
            padding: 20px;
        }

        .blog-post-content h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #007bff;
        }

        .blog-post-content p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }

        .blog-post-content a {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .blog-post-content a:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .blog-posts {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include './nav.php'; ?>

    <!-- Blog Header -->
    <div class="blog-header">
        <h1>SmartTech Hub Blog</h1>
        <p>Stay updated with the latest trends, tips, and news about laptops and technology.</p>
    </div>

    <!-- Blog Posts -->
    <div class="blog-container">
        <div class="blog-posts">
            <!-- Blog Post 1 -->
            <div class="blog-post">
                <img src="./images/blog1.jpg" alt="Blog Post 1">
                <div class="blog-post-content">
                    <h2>Top 5 Gaming Laptops of 2023</h2>
                    <p>Discover the best gaming laptops for 2023, featuring high-performance GPUs, fast refresh rates, and stunning displays.</p>
                    <a href="#">Read More</a>
                </div>
            </div>

            <!-- Blog Post 2 -->
            <div class="blog-post">
                <img src="./images/blog2.jpg" alt="Blog Post 2">
                <div class="blog-post-content">
                    <h2>How to Choose the Right Laptop for Your Needs</h2>
                    <p>Not sure which laptop to buy? This guide will help you choose the perfect laptop based on your budget and requirements.</p>
                    <a href="#">Read More</a>
                </div>
            </div>

            <!-- Blog Post 3 -->
            <div class="blog-post">
                <img src="./images/blog3.jpg" alt="Blog Post 3">
                <div class="blog-post-content">
                    <h2>MacBook vs. Windows Laptops: Which is Better?</h2>
                    <p>Compare MacBooks and Windows laptops to find out which one suits your needs and preferences.</p>
                    <a href="#">Read More</a>
                </div>
            </div>

            <!-- Blog Post 4 -->
            <div class="blog-post">
                <img src="./images/blog4.jpg" alt="Blog Post 4">
                <div class="blog-post-content">
                    <h2>5 Tips to Extend Your Laptop's Battery Life</h2>
                    <p>Learn how to maximize your laptop's battery life with these simple yet effective tips.</p>
                    <a href="#">Read More</a>
                </div>
            </div>
        </div>
    </div>

    <?php include './footer.php'; ?>
</body>
</html>