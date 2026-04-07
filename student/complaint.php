<?php
    error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include("../includes/db.php");

if(isset($_POST['submit'])){

    $category = $_POST['category'];
    $description = $_POST['description'];
    $student_id = $_SESSION['student_id'];
    $priority = $_POST['priority'];
    $room = $_POST['room'];

    $image_name = "";

    if(!empty($_FILES['image']['name'])){
        $image_name = time() . "_" . $_FILES['image']['name'];
        $target = "../uploads/" . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $query = "INSERT INTO complaints 
(student_id, category, complaint, status) 
VALUES 
('$student_id', '$category', '$description', 'Pending')";
    mysqli_query($conn, $query);
    // Mail setup
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    require '../PHPMailer/src/Exception.php';

    require '../config.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = EMAIL_USER;
    $mail->Password = EMAIL_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom(EMAIL_USER, 'Hostel Complaint System');
    $mail->addAddress(EMAIL_USER);
    $mail->addAddress($_SESSION['email']);

    $mail->Subject = 'New Complaint Submitted';
$mail->Body = "New Complaint Details:

Student ID: $student_id
Category: $category
Priority: $priority
Description: $description

Please check admin dashboard.";
    $mail->send();

    echo "Mail Sent";
} catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
}
    // Success message + redirect
    echo "<script>alert('Complaint Registered Successfully'); window.location='my_complaints.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Complaint</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .container{
            width: 90%;
            max-width: 400px;
            margin: 80px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        h2{
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label{
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, textarea{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button{
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover{
            background: #0056b3;
        }
        .back{
            text-align: center;
            margin-top: 15px;
        }
        .back a{
            text-decoration: none;
            color: #007bff;
        }
        .back a:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Register Complaint</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Category</label>
        <select name="category" required>
            <option value="Water">Water</option>
            <option value="Electricity">Electricity</option>
            <option value="Food">Food</option>
            <option value="Cleaning">Cleaning</option>
            <option value="Other">Other</option>
        </select>

        <label>Room Number</label>
<input type="text" name="room" placeholder="e.g. A-203" required>

<label>Priority</label>
<select name="priority" required>
    <option value="High">High</option>
    <option value="Medium">Medium</option>
    <option value="Low">Low</option>
</select>
        <label>Description</label>
        <textarea name="description" rows="4" required placeholder="Describe your complaint"></textarea>

        <label>Upload Image (Optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" name="submit">Submit Complaint</button>
    </form>

    <div class="back">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>