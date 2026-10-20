<?php

session_start();
require_once "../../database/db.php";

if(!isset($_SESSION['id'])){
    header("Location: ../auth-pages/login.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Owner Dashboard| User Management</title>
     <link rel="stylesheet" href="../../design/add-edit-view-products.css">
</head>
<body>
    <div class="content">

    <div class="page-title">
        <h2>Add New User</h2>
    </div>

    <div class="form-container">
        <form action="add-user-process.php" method="POST" enctype="multipart/form-data">
    
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="Enter Full Name" required>
            </div>
        
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter Your Email" required>
            </div>
            
            <div class="form-group">
                <label>Position</label>
                <select name="position" required>
                    <option value="">Select Position</option>
                    <option value="owner">Owner</option>
                    <option value="supplier">Supplier</option>
                    <option value="diser">Diser</option>
                </select>
            </div>
            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" placeholder="Enter Company" required>
            </div>
        
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Your Password">
            </div>
            <div class="button">
                <button type="submit" class="save-btn">
                    Save User
                </button>
                <a href="users.php" class="cancel-btn"> 
                    Cancel
                </a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>