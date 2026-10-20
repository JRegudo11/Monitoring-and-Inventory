<?php

session_start();

require_once "../../database/db.php";

if(!isset($_GET['id'])){
        header("Location: users.php");
        exit();
}

$id=$_GET['id'];

$sql = "SELECT * FROM users WHERE id='$id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_assoc($result);

if(!$user){
    echo "<script>
        alert('User not Found.');
        window.location='users.php';
        </script>";
        exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Management</title>
    <link rel="stylesheet" href="../../design/add-edit-view-products.css">
</head>
<body>
   <div class="content">
        <div class="page-title">
            <h2>User Details</h2>
        </div>
        <div class="view-container">
            <div class="info-group">
                <label>User ID</label>
                <div class="info">
                        <?php echo $user['id']; ?>
                </div>
            </div>
            <div class="info-group">
                <label>Full Name</label>
                <div class="info">
                    <?php echo $user['fullname']; ?>
                </div>
            </div>
            <div class="info-group">
                <label>Email Address</label>
                <div class="info">
                        <?php echo $user['email']; ?>
                </div>
            </div>
            <div class="info-group">
                <label>Positon</label>
                <div class="info">
                        <?php echo $user['position'] ?>
                </div>
            </div>
            <div class="info-group">
                <label>Company</label>
                <div class="info">
                    <?php echo $user['company']; ?>
                </div>
            </div>
            <div class="info-group">
                    <label>Date Registered</label>
                    <div class="info">
                        <?php echo $user['dateandtime']; ?>
                    </div>
            </div>

            <div class="buton-group">
                    <a href="users.php" class="back-btn">
                        Back
                    </a>
            </div>
        </div>
   </div> 
</body>
</html>