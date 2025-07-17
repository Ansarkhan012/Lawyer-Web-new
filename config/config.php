<?php 

$host="localhost";
$username="root";
$dbpassword="";
$dbname="lawyer-web";

$conn= mysqli_connect($host, $username, $dbpassword, $dbname);

if(!$conn){
  
     echo "Connection failed";
    die("Connection failed: " . mysqli_connect_error());
}



?>