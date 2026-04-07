<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// ✅ Profile Pic Upload
if(isset($_POST['upload_pic'])){
    $image = $_FILES['profile_pic']['name'];
    $tmp = $_FILES['profile_pic']['tmp_name'];

    if(!empty($image)){
        $image_name = time() . "_" . $image;
        move_uploaded_file($tmp, "../uploads/" . $image_name);

        mysqli_query($conn, "UPDATE users SET profile_pic='$image_name' WHERE id='$student_id'");
    }

    header("Location: profile.php");
    exit();
}

// ✅ Student Data
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$student_id'");
$student = mysqli_fetch_assoc($query);

// ✅ Total Complaints
$total_complaints = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM complaints WHERE student_id='$student_id'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" href="../assets/style.css">

<style>
.dashboard-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
}

.profile-card {
    width: 420px;
    margin: auto;
    background: linear-gradient(135deg, #ffffff, #f1f5ff);
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    text-align: center;
    transition: 0.3s;
}

.profile-card:hover {
    transform: translateY(-5px);
}

.profile-pic {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2a5298;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    margin-bottom: 15px;
}

.profile-card h2 {
    margin-bottom: 5px;
    color: #1e3c72;
}

.profile-card p {
    margin: 6px 0;
    font-size: 15px;
    color: #444;
}

.profile-card strong {
    color: #2a5298;
}

.upload-form {
    margin-top: 15px;
}

.custom-file {
    display: inline-block;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.custom-file:hover {
    opacity: 0.9;
}

.upload-form button {
    margin-top: 12px;
    background: #2a5298;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.upload-form button:hover {
    background: #1e3c72;
}
</style>

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

        <!-- ✅ Profile Image -->
        <?php if(!empty($student['profile_pic'])){ ?>
            <img src="../uploads/<?php echo $student['profile_pic']; ?>" class="profile-pic">
        <?php } else { ?>
            <img src="https://i.imgur.com/6VBx3io.png" class="profile-pic">
        <?php } ?>

        <h2><?php echo $student['name']; ?></h2>

        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        <p><strong>User ID:</strong> <?php echo $student['id']; ?></p>
        <p><strong>Total Complaints:</strong> <?php echo $total_complaints; ?></p>

        <!-- ✅ Upload Form -->
        <form method="POST" enctype="multipart/form-data" class="upload-form">
            <label class="custom-file">
                Choose Photo
                <input type="file" name="profile_pic" accept="image/*" required hidden>
            </label>
            <br>
            <button type="submit" name="upload_pic">Save Photo</button>
        </form>

    </div>

</div>

</body>
</html>