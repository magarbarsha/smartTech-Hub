<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTechHub - Laptop Insights & News</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo img {
            height: 40px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo-text span {
            color: var(--secondary);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a.active {
            color: var(--primary);
            font-weight: 600;
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
        }

        /* Hero Section */
        .blog-hero {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 3rem;
        }

        .blog-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .blog-hero p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .search-bar {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: none;
            font-size: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .search-bar button {
            position: absolute;
            right: 5px;
            top: 5px;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: #e69009;
        }

        /* Main Content */
        .blog-container {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            margin-bottom: 4rem;
        }

        /* Featured Post */
        .featured-post {
            grid-column: 1 / -1;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .featured-post-image {
            height: 100%;
            min-height: 300px;
            background-size: cover;
            background-position: center;
        }

        .featured-post-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .post-category {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .featured-post-content h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .featured-post-content p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .post-meta img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .read-more {
            display: inline-block;
            margin-top: 1rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: var(--primary-dark);
        }

        .read-more i {
            margin-left: 5px;
            transition: transform 0.3s;
        }

        .read-more:hover i {
            transform: translateX(3px);
        }

        /* Posts Grid */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .post-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .post-card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .post-card-content {
            padding: 1.5rem;
        }

        .post-card-content .post-category {
            margin-bottom: 0.8rem;
            background-color: var(--secondary);
        }

        .post-card-content h3 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .post-card-content p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .post-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-widget {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .widget-title {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .widget-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }

        .categories-list {
            list-style: none;
        }

        .categories-list li {
            margin-bottom: 0.8rem;
        }

        .categories-list a {
            display: flex;
            justify-content: space-between;
            text-decoration: none;
            color: var(--dark);
            transition: color 0.3s;
            padding: 0.5rem 0;
        }

        .categories-list a:hover {
            color: var(--primary);
        }

        .categories-list span {
            background-color: #e2e8f0;
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        .popular-posts {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .popular-post {
            display: flex;
            gap: 1rem;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
            transition: color 0.3s;
        }

        .popular-post:hover {
            color: var(--primary);
        }

        .popular-post-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
        }

        .popular-post-content h4 {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            line-height: 1.4;
        }

        .popular-post-content span {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .newsletter-form input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .newsletter-form button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .newsletter-form button:hover {
            background-color: var(--primary-dark);
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag {
            display: inline-block;
            background-color: #e2e8f0;
            color: var(--dark);
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .tag:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }

        .pagination a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background-color: white;
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .pagination a:hover, .pagination a.active {
            background-color: var(--primary);
            color: white;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 40px;
        }

        .footer-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .footer-logo-text span {
            color: var(--secondary);
        }

        .footer-about p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #334155;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: var(--primary);
        }

        .footer-links h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-links h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-contact p {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            color: var(--gray);
            margin-bottom: 1rem;
        }

        .footer-contact i {
            color: var(--primary);
            margin-top: 3px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #334155;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .featured-post {
                grid-template-columns: 1fr;
            }
            
            .featured-post-image {
                min-height: 250px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 1rem;
            }

            nav {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                background-color: white;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                transform: translateY(-150%);
                transition: transform 0.3s ease-in-out;
                z-index: 99;
            }

            nav.active {
                transform: translateY(0);
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
            }

            .mobile-menu-btn {
                display: block;
            }

            .blog-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                margin-top: 2rem;
            }
        }

        @media (max-width: 480px) {
            .blog-hero h1 {
                font-size: 2rem;
            }

            .blog-hero p {
                font-size: 1rem;
            }

            .featured-post-content h2 {
                font-size: 1.5rem;
            }

            .post-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
 
<?php include './nav.php'; ?>

    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <h1>SmartTechHub Blog</h1>
            <p>Stay updated with the latest laptop trends, reviews, and buying guides from our tech experts.</p>
            <div class="search-bar">
                <input type="text" placeholder="Search articles...">
                <button>Search</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container blog-container">
        <!-- Featured Post -->
        <article class="featured-post">
            <div class="featured-post-image" style="background-image: url('https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1026&q=80');"></div>
            <div class="featured-post-content">
                <span class="post-category">Buying Guide</span>
                <h2>Best Laptops for Programmers in 2023: Top Picks for Every Budget</h2>
                <p>Choosing the right laptop for programming can be challenging. We've tested dozens of models to bring you the best options whether you're a student, freelancer, or enterprise developer.</p>
                <div class="post-meta">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Author">
                    <div>
                        <span>John Doe</span>
                        <span>•</span>
                        <span>May 15, 2023</span>
                        <span>•</span>
                        <span>8 min read</span>
                    </div>
                </div>
                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
        </article>

        <!-- Posts Grid -->
        <div class="posts-content">
            <div class="posts-grid">
                <!-- Post Card 1 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1032&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">Tech News</span>
                        <h3>Intel's 14th Gen Processors: What to Expect in Next-Gen Laptops</h3>
                        <p>Intel has announced their 14th generation processors. Here's how they'll impact laptop performance and what models to look out for.</p>
                        <div class="post-card-meta">
                            <span>May 10, 2023</span>
                            <span>5 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post Card 2 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1064&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">Comparison</span>
                        <h3>MacBook Pro vs Dell XPS: Which Premium Laptop is Right for You?</h3>
                        <p>We compare Apple's MacBook Pro with Dell's XPS line to help you decide which premium laptop fits your needs and workflow.</p>
                        <div class="post-card-meta">
                            <span>May 5, 2023</span>
                            <span>7 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post Card 3 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1068&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">Tips & Tricks</span>
                        <h3>10 Essential Laptop Accessories to Boost Your Productivity</h3>
                        <p>From docking stations to ergonomic stands, these accessories will help you get the most out of your laptop setup.</p>
                        <div class="post-card-meta">
                            <span>April 28, 2023</span>
                            <span>6 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post Card 4 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1629131726692-1accd0c53ce0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">Review</span>
                        <h3>Asus ROG Zephyrus G14 Review: Powerhouse in a Compact Package</h3>
                        <p>We put the latest Asus ROG Zephyrus G14 through its paces to see if it lives up to the hype as the ultimate 14-inch gaming laptop.</p>
                        <div class="post-card-meta">
                            <span>April 22, 2023</span>
                            <span>9 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post Card 5 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1626785774573-4b799315345d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1171&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">How-To</span>
                        <h3>How to Upgrade Your Laptop RAM: A Step-by-Step Guide</h3>
                        <p>Want to give your laptop a performance boost? Our comprehensive guide walks you through upgrading your RAM safely and effectively.</p>
                        <div class="post-card-meta">
                            <span>April 15, 2023</span>
                            <span>10 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post Card 6 -->
                <article class="post-card">
                    <div class="post-card-image" style="background-image: url('https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1171&q=80');"></div>
                    <div class="post-card-content">
                        <span class="post-category">Software</span>
                        <h3>Best Software Tools for Remote Workers in 2023</h3>
                        <p>Discover the must-have applications that will help you work efficiently from anywhere while keeping your data secure.</p>
                        <div class="post-card-meta">
                            <span>April 8, 2023</span>
                            <span>5 min read</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <a href="#"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#"><i class="fas fa-chevron-right"></i></a>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="categories-list">
                    <li><a href="#">Buying Guides <span>12</span></a></li>
                    <li><a href="#">Laptop Reviews <span>24</span></a></li>
                    <li><a href="#">Tech News <span>18</span></a></li>
                    <li><a href="#">Comparison <span>9</span></a></li>
                    <li><a href="#">Tips & Tricks <span>15</span></a></li>
                    <li><a href="#">Software <span>7</span></a></li>
                    <li><a href="#">Accessories <span>11</span></a></li>
                </ul>
            </div>

            <!-- Popular Posts Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Popular Posts</h3>
                <div class="popular-posts">
                    <a href="#" class="popular-post">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1026&q=80" alt="Post thumbnail" class="popular-post-image">
                        <div class="popular-post-content">
                            <h4>Best Laptops for Video Editing in 2023</h4>
                            <span>April 30, 2023</span>
                        </div>
                    </a>
                    <a href="#" class="popular-post">
                        <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1064&q=80" alt="Post thumbnail" class="popular-post-image">
                        <div class="popular-post-content">
                            <h4>Windows vs MacOS: Which is Better for You?</h4>
                            <span>April 25, 2023</span>
                        </div>
                    </a>
                    <a href="#" class="popular-post">
                        <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1068&q=80" alt="Post thumbnail" class="popular-post-image">
                        <div class="popular-post-content">
                            <h4>How to Choose the Right Laptop for College</h4>
                            <span>April 18, 2023</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Newsletter Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Newsletter</h3>
                <p>Subscribe to get the latest laptop news and exclusive deals straight to your inbox.</p>
                <form class="newsletter-form">
                    <input type="text" placeholder="Your Name">
                    <input type="email" placeholder="Your Email">
                    <button type="submit">Subscribe</button>
                </form>
            </div>

            <!-- Tags Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Tags</h3>
                <div class="tags-container">
                    <a href="#" class="tag">Gaming</a>
                    <a href="#" class="tag">Ultrabooks</a>
                    <a href="#" class="tag">Business</a>
                    <a href="#" class="tag">Student</a>
                    <a href="#" class="tag">Budget</a>
                    <a href="#" class="tag">Premium</a>
                    <a href="#" class="tag">Intel</a>
                    <a href="#" class="tag">AMD</a>
                    <a href="#" class="tag">Apple</a>
                    <a href="#" class="tag">Dell</a>
                    <a href="#" class="tag">HP</a>
                    <a href="#" class="tag">Lenovo</a>
                </div>
            </div>
        </aside>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-about">
                    <a href="index.html" class="footer-logo">
                        <img src="https://via.placeholder.com/40" alt="SmartTechHub Logo">
                        <span class="footer-logo-text">Smart<span>Tech</span>Hub</span>
                    </a>
                    <p>Your trusted source for the latest laptops, expert reviews, and tech insights since 2018.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Categories</h3>
                    <ul>
                        <li><a href="#">Gaming Laptops</a></li>
                        <li><a href="#">Business Laptops</a></li>
                        <li><a href="#">Ultrabooks</a></li>
                        <li><a href="#">Chromebooks</a></li>
                        <li><a href="#">Workstations</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Tech Street, Silicon Valley, CA 94025</p>
                    <p><i class="fas fa-phone-alt"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope"></i> info@smarttechhub.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 SmartTechHub. All Rights Reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mainNav = document.getElementById('mainNav');

        mobileMenuBtn.addEventListener('click', () => {
            mainNav.classList.toggle('active');
            mobileMenuBtn.innerHTML = mainNav.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <?php include './footer.php'; ?>
</body>
</html>
