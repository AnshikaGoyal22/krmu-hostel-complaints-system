<?php
include("../includes/db.php");

if(isset($_POST['submit'])){
    $email = $_POST['email'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($result) > 0){

        $token = md5(rand());

        mysqli_query($conn, "UPDATE users SET reset_token='$token' WHERE email='$email'");

        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        require '../PHPMailer/src/Exception.php';
        require '../config.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ✅ FIXED
        $mail->setFrom(EMAIL_USER, 'Hostel Complaint System');
        $mail->addAddress($email);

        $link = "http://localhost/krmu_hostel_complaint/student/reset_password.php?token=$token";

        $mail->Subject = "Reset Password";
        $mail->Body = "Click here to reset password:\n$link";

        $mail->send();

        echo "<script>alert('Reset link sent!');</script>";

    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="login-body">

<div class="login-container">
    <div class="login-box">

        <h2>Forgot Password</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter Email" required>

            <button type="submit" name="submit">Send Reset Link</button>
        </form>

        <p style="margin-top:15px;">
            <a href="login.php">← Back to Login</a>
        </p>

    </div>
</div>

</body>
</html>