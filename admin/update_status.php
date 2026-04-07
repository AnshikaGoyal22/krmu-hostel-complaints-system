<?php
include("../includes/db.php");

$id = $_GET['id'];
$status = $_GET['status'];

// ✅ Step 1: Update complaint status
$query = "UPDATE complaints SET status='$status' WHERE id='$id'";
mysqli_query($conn, $query);

// ✅ Step 2: Get student email using JOIN
$result = mysqli_query($conn, "
    SELECT users.email 
    FROM complaints 
    JOIN users ON complaints.student_id = users.id 
    WHERE complaints.id='$id'
");

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);
$student_email = $data['email'];

// ✅ Step 3: PHPMailer include
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Step 4: Mail setup
require '../config.php';
$mail = new PHPMailer(true);

try {
    // Debug (optional – baad me hata dena)

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

$mail->Username = EMAIL_USER;
$mail->Password = EMAIL_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('goyalanshikaa22@gmail.com', 'Hostel Complaint System');

    // ✅ Email yaha jayegi
    $mail->addAddress($student_email);

    $mail->Subject = 'Complaint Status Updated';
    $mail->Body = "Hello,\n\nYour complaint status has been updated to: $status\n\nThank you.";

    $mail->send();

} catch (Exception $e) {
    echo "Mail Error: " . $mail->ErrorInfo;
}

// ✅ Step 5: Redirect
header("Location: view_complaints.php");
exit();
?>