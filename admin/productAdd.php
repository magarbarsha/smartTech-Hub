<?php
require '../includes/config.php'; // Ensure this file contains your database connection

if (isset($_POST['addProduct'])) {
    // Sanitize inputs
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // File upload handling
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $file_name = $_FILES['product_image']['name'];
        $file_tmp_name = $_FILES['product_image']['tmp_name'];
        $file_size = $_FILES['product_image']['size'];
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
            // File size check for 2MB (2MB = 2 * 1024 * 1024 bytes = 2097152 bytes)
            if ($file_size <= 2097152) { 
                // Move the uploaded file to the server
                if (move_uploaded_file($file_tmp_name, $upload_path)) {
                    // Prepared statement to insert product data
                    $sql = "INSERT INTO prod (product_name, category_id, product_image, quantity, price, description) 
                            VALUES (?, ?, ?, ?, ?, ?)";

                    // Initialize a prepared statement
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Bind parameters to the prepared statement
                        mysqli_stmt_bind_param($stmt, 'sssiis', $product_name, $category_id, $file_with_timestamp, $quantity, $price, $description);

                        // Execute the statement
                        if (mysqli_stmt_execute($stmt)) {
                            echo "Product added successfully!";
                            header('Location: ./productAdd.php'); // Redirect to productAdd.php after successful insertion
                        } else {
                            echo "Error: " . mysqli_error($conn);
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/productstyle.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css">

</head>
<body>
    <?php include './adminsidenav.php'; ?>

    <!-- Dashboard Content Section (Cards) -->
    <div class="dashboard-content">
        <form action="productAdd.php" method="post" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Enter the product name" required>
            <select name="category_id" required>
                <option value="none" selected disabled>---Select Category---</option>
                <?php
                $sql = "SELECT * FROM category";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($res)) {
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                <?php }
                ?>
            </select>
            <input type="file" name="product_image" id="" accept="image/png, image/jpeg" required>
            <input type="number" name="quantity" placeholder="Enter quantity" required min="1">
            <input type="number" name="price" placeholder="Enter price" required step="0.01" min="0">
            <textarea rows="8"  name="description" id="editor" placeholder="Enter description"></textarea>
            <input type="submit" name="addProduct" value="Add Product">
        </form>
    </div>

    <script src="../assets/js/dashboard_script.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.umd.js"></script>

    <script>
			const {
				ClassicEditor,
				Essentials,
				Paragraph,
				Bold,
				Italic,
				Font,
                List
			} = CKEDITOR;
			// Create a free account and get <YOUR_LICENSE_KEY>
			// https://portal.ckeditor.com/checkout?plan=free
			ClassicEditor
				.create( document.querySelector( '#editor' ), {
					licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzE2MzE5OTksImp0aSI6IjRlNmFjZTJkLTAzMDgtNGYwYS1hYWQ2LTc3NjdjYTE0NjI3MSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6Ijc2MjAwNTRkIn0.h9PEF1D3pqFho5Zt6U9HNbd2W2xHtdtfUu8RW0QUdALAK3LEmYos4uD-q7vOX79q4KyImSxNPidNR1gBs9HvBw',
					plugins: [ Essentials, Paragraph, Bold, Italic, Font, List ],
					toolbar: [
						'undo', 'redo', '|', 'bold', 'italic', '|',
						'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor','bulletedList','numberedList'
					]
				} )
				.then( editor => {
					window.editor = editor;
				} ) 
				.catch( error => {
					console.error( error );
				} );
		</script>
</body>
</html>
