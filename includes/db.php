<?php
$host = "sql212.infinityfree.com";
$user = "if0_41592341";
$pass = "Anshika2210";
$db   = "if0_41592341_hostel_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>