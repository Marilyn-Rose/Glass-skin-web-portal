<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "skincare_portal";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
