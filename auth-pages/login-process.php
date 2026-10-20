<?php

session_start();

include "../database/db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql ="SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])) {

        $_SESSION['id'] = $user['id'];

        $_SESSION['fullname'] = $user['fullname'];

        $_SESSION['email'] = $user['email'];

        $_SESSION['position'] = $user['position'];

        $_SESSION['company'] = $user['company'];
        if($user['position'] === "Owner"){

         header("Location: ../owner/dashboard.php");
        } elseif ($user['position'] === "Supplier"){

         header("Location: ../supplier/dashboard.php");
        } else {

         header("Location: ../diser/dashboard.php");
        }
        exit();
    }
    else {

        echo "<script> alert('Incorrect Password!');
        window.location='login.php';
        </script>";
    }
}

else{

    echo"<script>alert('Email Not Found!');
    window.location='login.php';
    </script>";
}

?>