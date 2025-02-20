<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
    width: 100%;
    height: 100vh; /* Full screen height */
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #000; /* Black background to make the images stand out */
}

.slide-container {
    position: relative;
    width: 100%;
    height: 100vh; /* Full screen height */
    overflow: hidden; /* Hide the parts of the images that go out of bounds */
}

.slides {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 1s ease-in-out;
}

.slides img {
    width: 100%;
    height: 100%; /* Images fill the entire screen */
    object-fit: cover; /* Ensures images cover the entire screen without distortion */
}

        /* Optional: Adding navigation arrows for user interaction */
        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

    </style>
</head>
<body>
    <div class="slide-container">
        <!-- Navigation arrows -->
        <span class="arrow prev">&#10094;</span>
        <span class="arrow next">&#10095;</span>

        <div class="slides">
            <img src="images/lenova.jpg" alt="Image 1">
            <img src="images/acer1.jpg" alt="Image 2">
            <img src="images/acer2.jpg" alt="Image 3">
            <img src="images/aspire.jpg" alt="Image 4">
            <img src="images/vostro.jpg" alt="Image 5">
            <img src="images/dell.jpg" alt="Image 6">
            <img src="images/aspire1.jpg" alt="Image 6">
            <img src="images/victus.jpg" alt="Image 6">
            <img src="images/nitro.jpg" alt="Image 6">
        </div>
    </div>

    <script>
        let index = 0;
        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const totalImages = images.length;

        // Move to the next slide
        function moveToNextSlide() {
            index = (index + 1) % totalImages; // Loop back to the first image when we reach the end
            const offset = -index * 100; // Shift by 100% per image
            slides.style.transform = `translateX(${offset}%)`;
        }

        // Move to the previous slide
        function moveToPrevSlide() {
            index = (index - 1 + totalImages) % totalImages; // Loop to the last image when moving backward
            const offset = -index * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }

        // Automatically change the slide every 3 seconds
        setInterval(moveToNextSlide, 3000);

        // Navigation buttons (previous and next)
        document.querySelector('.next').addEventListener('click', moveToNextSlide);
        document.querySelector('.prev').addEventListener('click', moveToPrevSlide);
    </script>
</body>
</html>
