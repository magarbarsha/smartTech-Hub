<?php
$hostname="localhost";
$username="root";
$password="";
$dbname="sign";
$conn=mysqli_connect($hostname,$username,$password,$dbname);
if(!$conn){
    echo "connection failed";
}