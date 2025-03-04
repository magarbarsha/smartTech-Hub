<?php
session_start();
include '../includes/config.php';
if(isset($_POST['addtocart'])){
    $product_id=$_POST['pid'];
    $user_id=$_SESSION['id'];
    $product_quantity=isset($_POST['product_quantiy']) ? $_POST['product_quantity'] : 1 ;
$sql="SELECT * FROM card_tbl WHERE product_id=$product_id AND user_id=$user_id";
$res=mysqli_query($conn,$sql);
$num=mysqli_num_rows($res);
if($num>0){
    $addQuery= "UPDATE card_tbl SET product_quantity= product_quantity + 1 WHERE product_id=$product_id ";
}
else{
    $addQuery= "INSERT INTO card_tbl (product_id,user_id,product_quantity) VALUES ($product_id,$user_id,$product_quantity)"; 
}
$res=mysqli_query($conn,$addQuery);
if($res){
    echo "<script>alert('product added to cart'); window.location.href='./cartView.php'</script>";
}
else{
    echo "<script>alert('failed to add to cart'); window.location.href='./cart.php'</script>";
}
}
