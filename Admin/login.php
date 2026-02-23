<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='admin'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['admin'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KRMU Hostel Portal - Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="admin-login">

<div class="login-container">

    <div class="login-box">

        <img src="../assets/images/logo.png" 
             alt="KR Mangalam Logo" 
             class="college-logo">

<div class="login-toggle">
    <a href="../student/login.php" class="toggle-link">Student Login</a>
    <a href="login.php" class="toggle-link active">Admin Login</a>
</div>
        <h2>Admin Login</h2>

        <form method="post">
            <input type="email" 
                   name="email" 
                   placeholder="Enter Admin Email" 
                   required>

            <input type="password" 
                   name="password" 
                   placeholder="Enter Password" 
                   required>

            <button type="submit" name="login">
                Login
            </button>

            
        </form>

    </div>

</div>

</body>
</html>
