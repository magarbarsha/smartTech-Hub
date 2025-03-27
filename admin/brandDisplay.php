<?php
include '../includes/config.php';

// Get all available brands
$sql = "SELECT * FROM branch ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand List</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <style>
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .add-btn {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .edit {
            background-color: #007bff;
            color: white;
        }
        .delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
<?php include './adminsidenav.php' ?>
<div class="container">
    <div class="header">
        <h2>Brand List</h2>
        <a href="brandAdd.php" class="add-btn">Add New Brand</a>
    </div>
    <table>
        <tr>
            <th>Brand Name</th>
            <th>Logo</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                <td><img src="../uploads/<?php echo htmlspecialchars($row['brand_logo']); ?>" alt="Brand Logo"></td>
                <td>
                    <div class="action-buttons">
                        <a href="products.php?brand=<?php echo $row['brand_name']; ?>" class="edit">View Products</a>
                        <a href="editBrand.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                        <a href="deleteBrand.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
