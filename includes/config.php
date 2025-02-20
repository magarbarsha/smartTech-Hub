<?php
$hostname="localhost";
$username="root";
$password="";
$dbname="SmartTechHub";
$conn=mysqli_connect($hostname,$username,$password,$dbname);
if(!$conn){

    echo "connnection failed";
}