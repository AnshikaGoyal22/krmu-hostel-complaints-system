<?php
include("../includes/db.php");

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $role = "student";

    $query = "INSERT INTO users (name,email,password,role) 
              VALUES ('$name','$email','$password','$role')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>

    
    <link rel="stylesheet" href="../assets/style.css">
</head>


<body class="login-page">

<div class="login-container">

<div class="login-box">

    
    <img src="../assets/images/logo.png" alt="Logo" class="college-logo">

    <h2>Student Registration</h2>

    <form method="post">

        <input type="text" name="name" placeholder="Enter Name" required>

        <input type="email" name="email" placeholder="Enter Email" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" name="register">Register</button>

        <p style="margin-top:15px;">
            Already have an account? <a href="login.php">Login</a>
        </p>

    </form>

</div>
</div>

</body>
</html>