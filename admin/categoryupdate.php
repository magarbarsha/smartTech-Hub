<?php

include '../includes/config.php';


if(isset($_POST['Add'])){
    
$category_name=$_POST['category_name'];
$id = $_POST['id'];
$sql ="UPDATE category set category_name='$category_name' where id=$id";
$res=mysqli_query($conn, $sql);
if($res){
    echo "data updated succsesfully";
}
else{
    echo "failed";
}
header("location: ./categoryAdd.php");
die;
}
?>
