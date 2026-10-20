<?php

session_start();

require_once "../../database/db.php";

if(!isset($_SESSION['id'])){

    header("Location: ../auth-pages/login.php");
    exit();
}

// Check if the ID exist

if(!isset($_GET['id'])){
    header("Location:users.php");
    exit();
}

$id= $_GET['id'];

// retrieving the user first to get file

$sql= "SELECT * FROM users WHERE id='$id'";

$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);

// if the user doesnt exist

if(!$user){
 
    echo "<script>
            alert('User Not Found.');
            window.location='users.php';
        </script>";

    exit();
}

// Delete the user record

$sql="DELETE FROM users WHERE id='$id'";

if(mysqli_query($conn,$sql)){

        echo "<script>
                alert('User Deleted Successfully');
                window.location='users.php';
                </script>";
}
else {
        echo "<script>
                alert('Unable to Delete User');
                window.location='users.php';
                </script>";
}
?>