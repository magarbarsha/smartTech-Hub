<?php
 include '../includes/config.php';
$id=$_GET['id'];
$sql="DElETE FROM category WHERE id= $id";
$res=mysqli_query($conn,$sql);
if($res){
    header("location: ./categorydisplay.php");
}
?>
