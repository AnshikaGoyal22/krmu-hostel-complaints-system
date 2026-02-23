<?php
include("../includes/db.php");

if(isset($_GET['status'])){
    $status = $_GET['status'];
    $result = mysqli_query($conn, 
        "SELECT * FROM complaints WHERE status='$status'"
    );
} else {
    $result = mysqli_query($conn, 
        "SELECT * FROM complaints"
    );
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    Admin Panel
    <span style="float:right;">
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </span>
</div>

<div class="container">
<h2>All Complaints</h2>

<table>
<tr>
    <th>ID</th>
    <th>Student ID</th>
    <th>Category</th>
    <th>Description</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['student_id']; ?></td>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['description']; ?></td>

<!-- IMAGE COLUMN -->
<td>
<?php
if($row['image'] != ""){
    echo "<a href='../uploads/".$row['image']."' target='_blank'>
            <img src='../uploads/".$row['image']."' width='60' style='border-radius:6px;'>
          </a>";
} else {
    echo "—";
}
?>
</td>

<!-- STATUS COLUMN -->
<td>
<?php
if($row['status']=="Pending"){
    echo "<span class='badge pending'>Pending</span>";
}
elseif($row['status']=="In Progress"){
    echo "<span class='badge progress'>In Progress</span>";
}
elseif($row['status']=="Resolved"){
    echo "<span class='badge resolved'>Resolved</span>";
}
else{
    echo "<span class='badge rejected'>Rejected</span>";
}
?>
</td>

<!-- ACTION COLUMN -->
<td>
<a href="update_status.php?id=<?php echo $row['id']; ?>&status=In Progress"
   class="btn-small progress-btn"
   onclick="return confirm('Mark this complaint as In Progress?')">
   In Progress
</a>

<a href="update_status.php?id=<?php echo $row['id']; ?>&status=Resolved"
   class="btn-small resolve-btn"
   onclick="return confirm('Mark this complaint as Resolved?')">
   Resolve
</a>

<a href="update_status.php?id=<?php echo $row['id']; ?>&status=Rejected"
   class="btn-small reject-btn"
   onclick="return confirm('Reject this complaint?')">
   Reject
</a>
</td>

</tr>
<?php } ?>
</table>

</div>
</body>
</html>
