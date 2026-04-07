<?php
include("../includes/db.php");
session_start();
mysqli_query($conn, "UPDATE notices SET status='read'");
$result = mysqli_query($conn, "SELECT * FROM notices ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notices</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">Notices</div>
    <div class="nav-links">
        <a href="dashboard.php">Back</a>
    </div>
</div>

<div style="padding:30px;">
<h2>Important Notices</h2>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div style="background:white; padding:15px; margin-bottom:10px; border-radius:8px;">
        <p><?php echo $row['message']; ?></p>
        <small><?php echo $row['created_at']; ?></small>
    </div>
<?php } ?>

</div>

</body>
</html>