<?php
include("../includes/db.php");
session_start();

$student_id = $_SESSION['student_id'];

$result = mysqli_query($conn, "SELECT * FROM complaints WHERE student_id='$student_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Complaints</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    Student Panel
    <span style="float:right;">
        <a href="dashboard.php">Dashboard</a>
        <a href="register_complaint.php">Register Complaint</a>
        <a href="logout.php">Logout</a>
    </span>
</div>

<div class="container">
<h2>My Complaints</h2>

<table border="1" width="100%" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Category</th>
    <th>Description</th>
    <th>Image</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['description']; ?></td>

    <td>
        <?php if($row['image'] != ""){ ?>
            <a href="../uploads/<?php echo $row['image']; ?>" target="_blank">
                <img src="../uploads/<?php echo $row['image']; ?>" width="80">
            </a>
        <?php } ?>
    </td>

    <td>
        <?php
$status = $row['status'];

if($status=="Pending")
    echo "<span class='badge pending'>Pending</span>";
elseif($status=="In Progress")
    echo "<span class='badge progress'>In Progress</span>";
elseif($status=="Resolved")
    echo "<span class='badge resolved'>Resolved</span>";
else
    echo "<span class='badge rejected'>Rejected</span>";
?>

    </td>

    <td><?php echo $row['date']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
