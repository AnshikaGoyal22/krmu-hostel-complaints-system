<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn, 
    "SELECT * FROM users WHERE id='$student_id'"
);

$student = mysqli_fetch_assoc($query);

$total_complaints = mysqli_num_rows(
    mysqli_query($conn, 
        "SELECT * FROM complaints WHERE student_id='$student_id'"
    )
);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="navbar">
    <div class="logo-section">
        <span>Student Panel</span>
    </div>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="complaint.php">Register</a>
        <a href="my_complaints.php">My Complaints</a>
        <a href="profile.php">Profile</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
</div>

<div class="dashboard-container">

    <h1>My Profile 👤</h1>

    <div class="profile-card">
        <p><strong>ID:</strong> <?php echo $student['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $student['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        <p><strong>Total Complaints:</strong> <?php echo $total_complaints; ?></p>
    </div>

</div>

</body>
</html>