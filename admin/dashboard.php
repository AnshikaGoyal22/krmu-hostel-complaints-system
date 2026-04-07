<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("../includes/db.php");

if(isset($_POST['post_notice'])){

    $notice = $_POST['notice'];

    $query = "INSERT INTO notices (message, status) VALUES ('$notice', 'unread')";
    mysqli_query($conn, $query);

    echo "<script>alert('Notice posted successfully');</script>";
}

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints"));
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE status='Pending'"));
$resolved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE status='Resolved'"));
$progress = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE status='In Progress'"));

$water = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE category='Water'"));

$electricity = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE category='Electricity'"));

$food = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE category='Food'"));

$cleaning = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM complaints WHERE category='Cleaning'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="admin-dashboard">

<div class="navbar">
    <div class="logo-section">
        <span>Admin Panel</span>
    </div>
    <div class="nav-links">
        <a href="#">Dashboard</a>
        <a href="view_complaints.php">View Complaints</a>
        <a href="logout.php" class="logout">Logout</a>
        
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
    <div style="display:flex; justify-content:center; gap:50px; flex-wrap:wrap; margin-top:30px;">

    <!-- Complaint Status Chart -->
    <div>
        <h3 style="text-align:center;">Status Analytics</h3>
        <canvas id="myChart" width="300" height="300"></canvas>
    </div>

    <!-- Category Chart -->
    <div>
        <h3 style="text-align:center;">Category Analytics</h3>
        <canvas id="categoryChart" width="300" height="300"></canvas>
    </div>

</div>

<div style="margin-top:40px; text-align:center;">
    

    <div class="notice-box">
    <h2>Post Notice</h2>

    <form method="post">
        <textarea name="notice" placeholder="Enter notice here..." required></textarea>

        <button type="submit" name="post_notice">Post Notice</button>
    </form>
</div>
<div class="notice-list">
    <h3>📋 Recent Notices</h3>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM notices ORDER BY id DESC LIMIT 5");

    while($row = mysqli_fetch_assoc($result)){
        echo "<div class='notice-item'>" . $row['message'] . "</div>";
    }
    ?>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart').getContext('2d');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Pending', 'Resolved'],
        datasets: [{
            data: [<?php echo $pending; ?>, <?php echo $resolved; ?>],
            backgroundColor: ['#FFA500', '#28a745']
        }]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let value = context.raw;
                        let percent = ((value / total) * 100).toFixed(1);
                        return value + " (" + percent + "%)";
                    }
                }
            }
        }
    }
});
</script>

<script>
const ctx2 = document.getElementById('categoryChart').getContext('2d');

new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Water', 'Electricity', 'Food', 'Cleaning'],
        datasets: [{
            data: [
                <?php echo $water; ?>,
                <?php echo $electricity; ?>,
                <?php echo $food; ?>,
                <?php echo $cleaning; ?>
            ],
            backgroundColor: ['#007bff', '#ffc107', '#dc3545', '#6f42c1']
        }]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let value = context.raw;
                        let percent = ((value / total) * 100).toFixed(1);
                        return value + " (" + percent + "%)";
                    }
                }
            }
        }
    }
});
</script>
</body>
</html>
