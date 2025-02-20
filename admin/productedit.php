<?php
require '../includes/config.php';
$id=$_GET['id'];
$sql="SELECT * FROM prod WHERE id= $id";
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($res);
$product_name=$row['product_name'];
$category_id=$row['category_id'];
$product_image=$row['product_image'];
$quantity=$row['quantity'];
$description=$row['description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="">
        
</body>
</html>