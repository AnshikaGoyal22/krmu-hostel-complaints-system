<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$student_id = $_SESSION['student_id'];

$total = mysqli_num_rows(
    mysqli_query($conn, 
        "SELECT * FROM complaints WHERE student_id='$student_id'"
    )
);

$pending = mysqli_num_rows(
    mysqli_query($conn, 
        "SELECT * FROM complaints 
         WHERE student_id='$student_id' AND status='Pending'"
    )
);

$progress = mysqli_num_rows(
    mysqli_query($conn, 
        "SELECT * FROM complaints 
         WHERE student_id='$student_id' AND status='In Progress'"
    )
);

$resolved = mysqli_num_rows(
    mysqli_query($conn, 
        "SELECT * FROM complaints 
         WHERE student_id='$student_id' AND status='Resolved'"
    )
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .container {
    width: 100%;
    max-width: 850px;
    background: white;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}


        h2 {
            color: #333;
        }

        a {
            display: block;
            padding: 12px;
            margin: 15px 0;
            text-decoration: none;
            background: #007bff;
            color: white;
            border-radius: 8px;
            font-weight: bold;
        }

        a:hover {
            background: #0056b3;
        }

        .logout {
            background: #dc3545;
        }

        .logout:hover {
            background: #a71d2a;
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo-section">
        <img src="../assets/images/logo.png" class="nav-logo">
        <span>KRMU Hostel Portal</span>
    </div>

    <div class="nav-links">
        <a href="#">Dashboard</a>
        <a href="complaint.php">Register</a>
        <a href="my_complaints.php">My Complaints</a>
        <a href="profile.php">Profile</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
</div>

<div class="main-section">
    <div class="dashboard-wrapper">
    <div class="container">
    <h1 class="welcome-text">Welcome Back 👋</h1>
<p class="subtitle">Manage your hostel complaints easily from here.</p>
<div class="stats-cards">

    <div class="stat-card total">
        <h3>Total</h3>
        <p><?php echo $total; ?></p>
    </div>

    <div class="stat-card pending">
        <h3>Pending</h3>
        <p><?php echo $pending; ?></p>
    </div>

    <div class="stat-card progress">
        <h3>In Progress</h3>
        <p><?php echo $progress; ?></p>
    </div>

    <div class="stat-card resolved">
        <h3>Resolved</h3>
        <p><?php echo $resolved; ?></p>
    </div>

</div>

    <div class="cards">

        <div class="card">
            <div class="card-icon">📝
            <h3>Register Complaint</h3>
            <p>Submit a new hostel complaint easily.</p>
            <a href="complaint.php" class="btn">Register</a>
        </div>
</div>
        

<div class="card">
    <div class="card-icon">📂
            <h3>My Complaints</h3>
            <p>Track status of your submitted complaints.</p>
            <a href="my_complaints.php" class="btn">View</a>
        </div>
</div>
    </div>
</div>


</body>
</html>
