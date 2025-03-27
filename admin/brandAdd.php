<?php
include '../includes/config.php';

if (isset($_POST['Add'])) {
    $brand_name = $_POST['brand_name'];

    // Check if file is uploaded correctly
    if (isset($_FILES['brand_logo']) && $_FILES['brand_logo']['error'] == 0) {
        $file_name = $_FILES['brand_logo']['name'];
        $file_tmp_name = $_FILES['brand_logo']['tmp_name'];
        $file_size = $_FILES['brand_logo']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Generate a unique file name with timestamp
        $timestamp = time();
        $file_with_timestamp = "P{$timestamp}.{$file_ext}";
        $upload_dir = '../uploads/';
        $upload_path = $upload_dir . $file_with_timestamp;

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        if (!in_array($file_ext, $allowed_types)) {
            echo "Invalid file type. Only JPG, PNG, GIF, and PDF are allowed.";
        } else {
            // File size check (2MB = 2097152 bytes)
            if ($file_size <= 2097152) {
                // Move the uploaded file to the server
                if (move_uploaded_file($file_tmp_name, $upload_path)) {
                    // Prepared statement to insert brand data
                    $sql = "INSERT INTO branch (brand_name, brand_logo) VALUES (?, ?)";

                    // Initialize a prepared statement
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Bind parameters (both are strings 'ss')
                        mysqli_stmt_bind_param($stmt, 'ss', $brand_name, $file_with_timestamp);

                        // Execute the statement
                        if (mysqli_stmt_execute($stmt)) {
                            echo "<script>alert('Brand added successfully!');</script>";
                            header('Location: brandAdd.php'); // Redirect after success
                            exit();
                        } else {
                            echo "Error: " . mysqli_stmt_error($stmt);
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "There was an error uploading the file.";
                }
            } else {
                echo "File size exceeds the limit of 2MB.";
            }
        }
    } else {
        echo "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
</head>
<style>
/* General Styles
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    flex-direction: column;
} */

/* Container Styling */
.container {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
  
}

h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

/* Form Elements */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-weight: 600;
    text-align: left;
    color: #444;
}

input[type="text"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}

button {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s ease-in-out;
}

button:hover {
    background: #0056b3;
}

.back-button {
    margin-top: 15px;
    background: #6c757d;
}

.back-button:hover {
    background: #5a6268;
}

/* Responsive Design */
@media (max-width: 500px) {
    .container {
        padding: 20px;
    }
}
</style>
<body>
<?php include './adminsidenav.php' ?>

<div class="container">
    <h2>Add a New Brand</h2>
    <form action="brandAdd.php" method="POST" enctype="multipart/form-data">
        <label for="brand_name">Brand Name:</label>
        <input type="text" name="brand_name" id="brand_name" required>

        <label for="brand_logo">Brand Logo:</label>
        <input type="file" name="brand_logo" id="brand_logo" accept="image/png, image/jpeg, image/gif" required>

        <button type="submit" name="Add">Add Brand</button>
    </form>
    <button class="back-button" onclick="window.location.href='brandDisplay.php';">Back to Dashboard</button>
</div>
<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>