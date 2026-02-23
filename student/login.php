<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users 
              WHERE email='$email' 
              AND password='$password' 
              AND role='student'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['student_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];

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
    <title>KRMU Hostel Portal - Student Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="login-page">

<div class="login-container">

    
    <div class="login-box">
<img src="../assets/images/logo.png" alt="KR Mangalam Logo" class="college-logo">

<div class="login-toggle">
    <a href="login.php" class="toggle-link active">Student Login</a>
    <a href="../admin/login.php" class="toggle-link">Admin Login</a>
</div>
    <h2>Student Login</h2>

    <form method="post">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="login">Login</button>

        <p style="margin-top:15px;">
            <a href="forgot_password.php">Forgot Password?</a>
        </p>

        <p>
            New student? <a href="register.php">Register Here</a>
        </p>
    </form>
</div>


</div>

</body>
</html>