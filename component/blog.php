<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Smattect Hub Blog - Latest news, reviews, and tips about laptops.">
  <title>Smattect Hub Blog</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  line-height: 1.6;
  color: #333;
}

.container {
  width: 90%;
  max-width: 1200px;
  margin: 0 auto;
}

/* Header */
header {
  background: #333;
  color: #fff;
  padding: 20px 0;
}

header h1 {
  margin: 0;
  font-size: 2rem;
}

header nav ul {
  list-style: none;
  padding: 0;
  display: flex;
  gap: 20px;
}

header nav ul li a {
  color: #fff;
  text-decoration: none;
}

.search-bar {
  display: flex;
  margin-top: 10px;
}

.search-bar input {
  padding: 5px;
  width: 200px;
}

.search-bar button {
  padding: 5px 10px;
  background: #555;
  color: #fff;
  border: none;
  cursor: pointer;
}

/* Featured Post */
.featured-post {
  margin: 20px 0;
}

.featured-card {
  position: relative;
}

.featured-card img {
  width: 100%;
  height: auto;
  border-radius: 10px;
}

.featured-content {
  position: absolute;
  bottom: 20px;
  left: 20px;
  color: #fff;
  background: rgba(0, 0, 0, 0.5);
  padding: 10px;
  border-radius: 5px;
}

.featured-content h2 {
  margin: 0;
}

/* Blog Grid */
.blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin: 20px 0;
}

.blog-card {
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s;
}

.blog-card:hover {
  transform: scale(1.05);
}

.blog-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.blog-content {
  padding: 15px;
}

.blog-content h3 {
  margin: 0 0 10px;
}

.blog-content p {
  margin: 0 0 15px;
}

.btn {
  display: inline-block;
  padding: 10px 15px;
  background: #333;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
}

/* Footer */
footer {
  background: #333;
  color: #fff;
  text-align: center;
  padding: 20px 0;
  margin-top: 40px;
}

.social-links {
  margin-top: 10px;
}

.social-links a {
  color: #fff;
  margin: 0 10px;
  font-size: 1.2rem;
}

  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <h1>Smattect Hub Blog</h1>
      <nav>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">About</a></li>
        </ul>
      </nav>
      <div class="search-bar">
        <input type="text" placeholder="Search blogs...">
        <button><i class="fas fa-search"></i></button>
      </div>
    </div>
  </header>

  <!-- Blog Posts Section -->
  <main class="container">
    <section class="featured-post">
      <div class="featured-card">
        <img src="https://via.placeholder.com/800x400" alt="Featured Laptop Review">
        <div class="featured-content">
          <h2>Top 5 Laptops of 2025</h2>
          <p>Discover the best laptops for gaming, productivity, and more.</p>
          <a href="#" class="btn">Read More</a>
        </div>
      </div>
    </section>

    <section class="blog-grid">
      <div class="blog-card">
        <img src="https://via.placeholder.com/400x200" alt="Laptop Buying Guide">
        <div class="blog-content">
          <h3>How to Choose the Right Laptop</h3>
          <p>A comprehensive guide to help you pick the perfect laptop.</p>
          <a href="#" class="btn">Read More</a>
        </div>
      </div>
      <div class="blog-card">
        <img src="https://via.placeholder.com/400x200" alt="Tech Tips">
        <div class="blog-content">
          <h3>5 Tips to Extend Your Laptop's Battery Life</h3>
          <p>Learn how to make your laptop battery last longer.</p>
          <a href="#" class="btn">Read More</a>
        </div>
      </div>
      <div class="blog-card">
        <img src="https://via.placeholder.com/400x200" alt="Laptop Accessories">
        <div class="blog-content">
          <h3>Must-Have Laptop Accessories</h3>
          <p>Upgrade your laptop experience with these accessories.</p>
          <a href="#" class="btn">Read More</a>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2025 Smattect Hub. All rights reserved.</p>
      <div class="social-links">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </footer>

  <script>
    // Add interactivity here (e.g., search functionality, animations, etc.)
document.querySelector('.search-bar button').addEventListener('click', () => {
  const query = document.querySelector('.search-bar input').value;
  alert(Searching for: ${query});
});
  </script>
</body>
</html>
