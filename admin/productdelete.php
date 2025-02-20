<?php
require '../includes/config.php';
$id=$_GET['id'];
$sql="DElETE FROM prod WHERE id= $id";
$res=mysqli_query($conn,$sql);
if($res){
    header("location: ./productDisplay.php");
}
?>
