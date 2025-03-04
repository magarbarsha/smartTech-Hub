<?php
include '../includes/config.php';
if(isset($_POST['register'])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];
  $password=$_POST['password'];
  $confirm_password=$_POST['confirm_password'];
  if ($password === $confirm_password) {
    $hashed_pass=password_hash($password, PASSWORD_DEFAULT);
    $gender=$_POST['gender'];
    $sql="INSERT INTO user (name,email,phone,password,gender) VALUES ('$name','$email','$phone','$hashed_pass','$gender')";
    $res=mysqli_query($conn, $sql);
    if(!$res){
      echo "inserted failed";
    }
  } else {
    echo "Passwords do not match";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/customerregister.css">
</head>
<body>
<div class="container">
    <div class="form-wrapper">
      <h2>Create Your Account</h2>
      <form action="" method="post">
        <div class="input-group">
          <input type="text" name="name" id="name" placeholder="Your Name" required>
          <label for="name">Username</label>
        </div>

        <div class="input-group">
          <input type="email" name="email" id="email" placeholder="Your Email" required>
          <label for="email">Email</label>
        </div>

        <div class="input-group">
          <input type="number" name="phone" id="phone" placeholder="Your Phone" required>
          <label for="phone">Phone</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>

        <div class="input-group">
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
          <label for="confirm_password">Confirm Password</label>
        </div>

        <div class="gender-selection">
          <label>Gender</label>
          <div class="gender-options">
            <input type="radio" name="gender" value="female" id="female">
            <label for="female">Female</label>

            <input type="radio" name="gender" value="male" id="male">
            <label for="male">Male</label>

            <input type="radio" name="gender" value="others" id="others">
            <label for="others">Others</label>
          </div>
        </div>

        <button type="submit" name="register" class="register-btn">Register</button>
      </form>
    </div>
</body>
</html>