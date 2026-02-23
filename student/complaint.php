<?php
session_start();
include("../includes/db.php");

if(isset($_POST['submit'])){

    $category = $_POST['category'];
    $description = $_POST['description'];
    $student_id = $_SESSION['student_id'];

    $image_name = "";

    if(!empty($_FILES['image']['name'])){

        $image_name = time() . "_" . $_FILES['image']['name'];
        $target = "../uploads/" . $image_name;

        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $query = "INSERT INTO complaints 
              (student_id, category, description, image, status, date)
              VALUES 
              ('$student_id', '$category', '$description', '$image_name', 'Pending', NOW())";

    mysqli_query($conn, $query);

    header("Location: my_complaints.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Complaint</title>
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .container{
            width: 400px;
            margin: 80px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        h2{
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label{
            font-weight: bold;
        }
        select, textarea{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button{
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover{
            background: #0056b3;
        }
        .back{
            text-align: center;
            margin-top: 15px;
        }
        .back a{
            text-decoration: none;
            color: #007bff;
        }
        .back a:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Register Complaint</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Category</label>
        <select name="category" required>
            <option value="Water">Water</option>
            <option value="Electricity">Electricity</option>
            <option value="Food">Food</option>
            <option value="Cleaning">Cleaning</option>
            <option value="Other">Other</option>
        </select>

        <label>Description</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Upload Image (Optional)</label>
<input type="file" name="image" accept="image/*">

        <button type="submit" name="submit">Submit Complaint</button>
    </form>

    <div class="back">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>

<?php
if(isset($_POST['submit'])){
    $category = $_POST['category'];
    $description = $_POST['description'];
    $student_id = $_SESSION['id'];

    $query = "INSERT INTO complaints(student_id, category, description, status)
              VALUES('$student_id','$category','$description','Pending')";
    mysqli_query($conn,$query);

    echo "<script>alert('Complaint Registered Successfully'); window.location='dashboard.php';</script>";
}
?>
