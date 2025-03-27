<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Logos</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Section Styling */
.logo-section {
    position:relative;
    top:170px;
    padding: 20px;
    background: #fff;
    margin: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Logo Container */
.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    padding: 10px;
}

/* Logo Styling */
.logo-container img {
    width: 120px;
    height: auto;
    filter: grayscale(100%); /* Optional: Makes logos black and white */
    transition: transform 0.3s, filter 0.3s;
}

/* Hover Effect */
.logo-container img:hover {
    filter: grayscale(0%);
    transform: scale(1.1);
}

    </style>
</head>
<body>

    <section class="logo-section">
       
    <div class="logo-container">
    <a href="dell.php" target="_blank">
        <img src="images/logo5.svg" alt="Dell">
    </a>
    <a href="asus.php" target="_blank">
        <img src="images/logo1.png" alt="Asus">
    </a>
    <!-- <a href="https://www.hp.com" target="_blank">
        <img src="images/logo2.png" alt="HP">
    </a> -->
    <a href="apple.php" target="_blank">
        <img src="images/logo10.svg" alt="Apple">
    </a>
    <!-- <a href="lenova.php" target="_blank">
        <img src="images/logo5.svg" alt="Lenovo">
    </a> -->
    <a href="hp.php" target="_blank">
        <img src="images/logo6.svg" alt="Lenovo">
    </a>
    <a href="aser.php" target="_blank">
        <img src="images/logo7.svg" alt="Lenovo">
    </a>
    <a href="lenovo.php" target="_blank">
        <img src="images/logo8.svg" alt="Lenovo">
    </a>
    
</div>

    </section>
<script>
    $(document).ready(function(){
    $('.logo-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        dots: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
});

    </script>
</body>
</html>
