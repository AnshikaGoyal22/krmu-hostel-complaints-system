<?php
include("../includes/db.php");
session_start();
if(isset($_POST['submit_feedback'])){

    $complaint_id = $_POST['complaint_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $query = "INSERT INTO feedback (complaint_id, rating, comment) 
              VALUES ('$complaint_id', '$rating', '$comment')";

    mysqli_query($conn, $query);

    echo "<script>alert('Feedback submitted successfully');</script>";
}
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
    <div class="logo">KRMU Hostel Portal</div>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="complaint.php">Register</a>
        <a href="my_complaints.php">My Complaints</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
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
    <th>Feedback</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['complaint']; ?></td>

    <!-- IMAGE -->
    <td>
        <?php if($row['image'] != ""){ ?>
            <a href="../uploads/<?php echo $row['image']; ?>" target="_blank">
                <img src="../uploads/<?php echo $row['image']; ?>" width="80">
            </a>
        <?php } ?>
    </td>

    <!-- STATUS -->
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

    <!-- DATE -->
    <td><?php echo $row['created_at']; ?></td>

    <!-- FEEDBACK -->
    <td>
    <?php if($row['status'] == 'Resolved') { ?>
        <form method="POST">
            <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">

            <select name="rating" required>
                <option value="">Rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <input type="text" name="comment" placeholder="Comment" required>

            <button type="submit" name="submit_feedback">Submit</button>
        </form>
    <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
