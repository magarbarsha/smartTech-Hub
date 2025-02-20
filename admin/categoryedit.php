<?php
 include '../includes/config.php';
 
$id=$_GET['id'];
$sql="SELECT * FROM category WHERE id= $id";
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($res);
$category_name=$row['category_name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
    <form action="./categoryupdate.php" method="post">
<tr>
    <td> Category name:</td>
    <td><input type="text" value="<?php echo $category_name ?>" name="category_name" placeholder="enter the category name"></td>
</tr>

<input type="hidden" name="id" value="<?php echo $row['id'] ?>"> 
<tr>
    <td><input type="submit" name="Add" value="Add">
</tr>
</body>
</html>