<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        /* Tailwind-like custom styles for responsiveness */
        .hero-section {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 0;
            height: 100vh;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero-content p {
            font-size: 1.125rem;
            margin-bottom: 20px;
        }

        .hero-content a {
            background-color: #2575fc;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .hero-content a:hover {
            background-color: #6a11cb;
        }

        .contact-form {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: #2575fc;
            outline: none;
        }

        .form-textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-textarea:focus {
            border-color: #2575fc;
            outline: none;
        }

        .form-submit {
            background-color: #2575fc;
            color: white;
            padding: 15px;
            border-radius: 6px;
            font-size: 1.125rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .form-submit:hover {
            background-color: #6a11cb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 20px;
                height: auto;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .contact-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    
<?php
include './nav.php';
?>

    <!-- Contact Form Section -->
    <section id="contact-form" class="p-8 bg-gray-100">
    <h1 style="font-size: 4rem; font-weight: bold; text-align: center; color: #2575fc;">Get in touch with us</h1>
        <div class="contact-form">
            <form action="contact.php" method="post">
                <input type="text" name="name" placeholder="Your Name" class="form-input" required />
                <input type="email" name="email" placeholder="Your Email" class="form-input" required />
                <input type="text" name="subject" placeholder="Subject" class="form-input" required />
                <textarea name="message" placeholder="Your Message" rows="6" class="form-textarea" required></textarea>
                <input type="submit" name="sub" value="Send Message" class="form-submit" />
            </form>
        </div>
    </section>
    <?php 
    include './footer.php';
    ?>
</body>
</html>
