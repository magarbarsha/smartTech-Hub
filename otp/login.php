<?php
session_start();
include '../includes/config.php';
$email=$_SESSION['email'];
$otp=$_POST['otp'];
$sql = "SELECT * FROM user_otp WHERE email='$email' and otp='$otp'";
$res=mysqli_query($conn,$sql);
if(mysqli_num_rows($res)>0){
    $sql = "UPDATE user_otp set otp='$otp' WHERE email='$email'";
$res=mysqli_query($conn,$sql);
    header(header: "location:../admin/dashboard.php?msg=Welcome User:".$email." login Success!");
}
else{
    header("location: ./verify.php?msg=OTP is invalid please try again");

}
?>