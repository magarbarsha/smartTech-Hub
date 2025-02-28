<!-- <?php
include '../includes/config.php';
if(isset($_POST['register'])){
  $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $hashed_pass=password_hash($pass, PASSWORD_DEFAULT);
    $confirm_password=$_POST['confirm_password'];
    $province=$_POST['province'];
    $cityDistrict=$_POST['cityDistrict'];
    $streetAddress=$_POST['steetAddress'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $role='customer';
    $sql="INSERT INTO user (name,email,phone,password,confirm_password,province,cityDistrict,streetAddress,gender,dob,role) VALUES ('$name','$email','$phone','$password','$confirm_password','$province','$cityDistrict','$streetAddress','$gender','$dob','$role');
    $res=mysqli_query($conn,$sql);
   
if(!$res){
echo "failed":
}
} 