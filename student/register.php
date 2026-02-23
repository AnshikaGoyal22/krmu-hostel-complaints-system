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
        echo "<script>alert('Registration Successful');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration</h2>

    <form method="post">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
