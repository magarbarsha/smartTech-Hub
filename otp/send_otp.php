<?php
session_start();
include '../includes/config.php';
include './email.php';
$email = mysqli_real_escape_string($conn, $_POST['email']);
$sql = "SELECT * FROM user_otp WHERE email='$email'";
$res=mysqli_query($conn,$sql);
if(mysqli_num_rows($res)>0){
    $_SESSION['email']=$email;
$otp=rand(11111,99999);
send_otp($email,"PHP OTP LOGIN",$otp);
$sql = "UPDATE user_otp set otp='$otp' WHERE email='$email'";
$res=mysqli_query($conn,$sql);
header(header: "location:verify.php?msg=Please Check Your Email and Verify!");
}
else{

    header("location: ./index.php?msg=Email id is invalid... plz check again!");
}
?>