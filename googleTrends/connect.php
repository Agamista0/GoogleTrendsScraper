<?php
$servername = "DB";
$username = "root";
$password = "root";
$database = "google_trends" ;

$connection = new mysqli($servername, $username, $password ,$database);

 if(!$connection){
  die("Database Connection Failed" . mysqli_error($connection));
 }
 
$select_db = mysqli_select_db($connection, $database );
if(!$select_db){
 die("Database Selection Failed" . mysqli_error($connection));
}


?>
