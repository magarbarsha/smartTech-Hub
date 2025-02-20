<?php
 include '../includes/config.php';

 if(isset($_POST['Add']))
 {
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO category (category_name) VALUES ('$category_name')";
    $res = mysqli_query($conn, $sql);
    if($res) {
        $message = "Category added successfully!";
        $message_class = "success-message";
    } else {
        $message = "Category not added. Please try again.";
        $message_class = "error-message";
    }
    header("location: ./categoryAdd.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/categorystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
</head>
<body>

<?php include './adminsidenav.php'; ?>

<!-- Dashboard Content Section (Cards) -->
<div class="dashboard-content">
    <h1>Add New Category</h1>

    <!-- Category Add Form -->
    <div class="form-container">
        <form action="categoryAdd.php" method="POST">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" required>
            <input type="submit" value="Add Category" name="Add">
        </form>
    </div>

    <!-- Success/Error Message -->
    <?php
        if (isset($message)) {
            echo "<div class='$message_class'>$message</div>";
        }
    ?>

    <!-- Back Button -->
    <a href="categorydisplay.php" class="back-btn">Back to Dashboard</a>
</div>

<script src="../assets/js/dashboard_script.js"></script>

</body>
</html>
