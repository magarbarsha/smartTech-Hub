<?php 
session_start();
include '../includes/config.php';
if(isset($_POST['updateCart'])){
$card_id=$_POST['card_id'];
$product_quantity=$_POST['product_quantity'];
$sql="UPDATE card_tbl SET product_quantity='$product_quantity' WHERE id='$card_id'";
$res=mysqli_query($conn,$sql);
if($res){
    echo "<script>alert('updated succesfull'); window.location.href = './cartView.php';</script>";
}

else{
    echo "<script>alert('update failed'); window.location.reload();</script>";
}
}
if(isset($_POST['remove'])){
    $card_id=$_POST['card_id'];
    $sql="DELETE FROM card_tbl  WHERE id=$card_id";
    $res=mysqli_query($conn,$sql);
    if($res){
        echo "<script>alert('remove succesfull'); window.location.href = './cartView.php';</script>";
    }
    
    else{
        echo "<script>alert('remove failed'); window.location.reload();</script>";
    }
}
if(isset($_POST['removeall'])){
    $user_id=$_POST['user_id'];
    $sql="DELETE FROM card_tbl  WHERE  user_id = $user_id";
    $res=mysqli_query($conn,$sql);
    if($res){
        echo "<script>alert('remove succesfull'); window.location.href = './cartView.php';</script>";
    }
    
    else{
        echo "<script>alert('remove failed'); window.location.reload();</script>";
    }
}