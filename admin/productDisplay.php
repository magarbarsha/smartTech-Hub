<?php
 include '../includes/config.php';
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../assets/css/productdisplay.css">

   </head>
<body>

 
   <?php include './adminsidenav.php' ?>

    <!-- Dashboard Content Section (Cards) -->
    <div class="dashboard-content">
    <table>
        <tr>
        <th>SN</th>
        <th>product_name</th>
        <th>category_id</th>
        <th>product_image</th>
        <th>quantity</th>
        <th>price</th>
        <th>description</th>
        </tr>
        <?php
        $sql="SELECT * FROM prod";
        $res=mysqli_query($conn,$sql);
    


$num=mysqli_num_rows($res);
$counter=0;
//display the rows returned by the sql query
if($num > 0){
 while($row=mysqli_fetch_assoc($res)){
?>
<tr>
    <td><?php echo ++$counter ?></td>
    <td><?php echo $row['product_name'] ?></td>
    <td><?php echo $row['category_id'] ?></td>
    <td><img src="<?php echo '../uploads/'.$row['product_image']?>"/></td>
    <td><?php echo $row['quantity'] ?></td>
    <td><?php echo $row['price'] ?></td>
    <td><?php echo $row['description'] ?></td>
    

   
<td><a href="./productedit.php?id=<?php echo $row['id'] ?>">Edit</a>

<a href="./productdelete.php?id=<?php echo $row['id'] ?>">Delete</a>
</td>
 </tr>
 <?php }
}
?>
    </div>

 <script src="../assets/js/dashboard_script.js"></script>
</body>
</html>

 