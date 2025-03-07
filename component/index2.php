<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/navbar2.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php 
  
  include './nav.php' ?>
  
    <div class="slide-container">
        <span class="arrow prev">&#10094;</span>
        <span class="arrow next">&#10095;</span>

        <div class="slides">
            <img src="images/lenova.jpg" alt="Image 1">
            <img src="images/acer1.jpg" alt="Image 2">
            <img src="images/acer2.jpg" alt="Image 3">
            <img src="images/aspire.jpg" alt="Image 4">
            <img src="images/vostro.jpg" alt="Image 5">
            <img src="images/dell.jpg" alt="Image 6">
            <img src="images/aspire1.jpg" alt="Image 7">
            <img src="images/victus.jpg" alt="Image 8">
            <img src="images/nitro.jpg" alt="Image 9">
        </div>
       

        
    </div> 
<?php
include './featured.php';
?>
    <!-- Today's Deals and Offers Section -->
    <section class="deals-section">
        <h2>Today's Deals and Offers</h2>
        <div class="deals-grid">
            <div class="deal-card">
                <img src="./images/1.jpeg" alt="Laptop Deal 1">
                <h3>Gaming Laptop - 20% Off</h3>
                <p>Experience ultimate gaming performance with this high-end laptop.</p>
                <p class="price">$999.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/2.jpeg" alt="Laptop Deal 2">
                <h3>Ultrabook - 15% Off</h3>
                <p>Sleek and lightweight, perfect for professionals on the go.</p>
                <p class="price">$799.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/3.jpeg" alt="Laptop Deal 3">
                <h3>Budget Laptop - 30% Off</h3>
                <p>Affordable yet powerful, ideal for everyday use.</p>
                <p class="price">$499.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
            <div class="deal-card">
                <img src="./images/4.jpeg" alt="Laptop Deal 4">
                <h3>2-in-1 Laptop - 25% Off</h3>
                <p>Versatile and portable, perfect for work and play.</p>
                <p class="price">$899.99</p>
                <a href="#" class="btn">Add to cart</a>
            </div>
        </div>
    </section>
    <?php
    include './logo.php';
    ?>
<?php
include './footer.php';
?>
    <script>
        let index = 0;
        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const totalImages = images.length;

        function moveToNextSlide() {
            index = (index + 1) % totalImages;
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        function moveToPrevSlide() {
            index = (index - 1 + totalImages) % totalImages;
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        setInterval(moveToNextSlide, 3000);

        document.querySelector('.next').addEventListener('click', moveToNextSlide);
        document.querySelector('.prev').addEventListener('click', moveToPrevSlide);

        document.querySelector('.menu-toggle').addEventListener('click', function () {
            document.querySelector('.menu ul').classList.toggle('show');
        });
    </script>

</body>
</html>