<?php
include("../includes/db.php");

$token = $_GET['token'];

if(isset($_POST['update'])){
    $password = $_POST['password'];

    mysqli_query($conn, "UPDATE users SET password='$password', reset_token=NULL WHERE reset_token='$token'");

    echo "Password updated!";
}
?>

<form method="POST">
    <input type="password" name="password" placeholder="New Password" required>
    <button name="update">Update Password</button>
</form>