<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints"));
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE status='Pending'"));
$resolved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE status='Resolved'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
</head>

<body class="admin-dashboard">

<div class="navbar">
    <div class="logo-section">
        <span>Admin Panel</span>
    </div>
    <div class="nav-links">
        <a href="#">Dashboard</a>
        <a href="view_complaints.php">View Complaints</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>
</div>

<div class="dashboard-container">

    <h1>Welcome Admin 👋</h1>

    <div class="admin-cards">

        <a href="view_complaints.php" class="admin-card">
    <h3>Total Complaints</h3>
    <p><?php echo $total; ?></p>
</a>

        <a href="view_complaints.php?status=Pending" class="admin-card pending">
    <h3>Pending</h3>
    <p><?php echo $pending; ?></p>
</a>

        <a href="view_complaints.php?status=Resolved" class="admin-card resolved">
    <h3>Resolved</h3>
    <p><?php echo $resolved; ?></p>
</a>

    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="view_complaints.php" class="btn">Manage Complaints</a>
    </div>

</div>

</body>
</html>
