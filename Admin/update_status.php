<?php
include("../includes/db.php");

$id = $_GET['id'];
$status = $_GET['status'];

$query = "UPDATE complaints SET status='$status' WHERE id='$id'";
mysqli_query($conn, $query);

header("Location: view_complaints.php");
?>
