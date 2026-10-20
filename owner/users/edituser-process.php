<?php

require_once "../../database/db.php";

$id = $_POST['id'];
$fullname= $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$position = $_POST['position'];
$company =$_POST['company'];

// Password

if(!empty($_POST['password'])){

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "UPDATE users SET
            fullname='$fullname',
            email='$email',
            password='$password',
            position='$position',
            company='$company'

            WHERE id='$id'";
} else {
    $sql = "UPDATE users SET
            fullname = '$fullname',
            email='$email',
            position='$position',
            company='$company'
            
            WHERE   id='$id'";

}

if(mysqli_query($conn,$sql)) {

    echo "<script>
            alert('User Updated Successfully.');
            window.location='users.php';
        </script>";
}else {
    echo "<script>
        alert('Failed to Update User.');
        window.history.back():;
        </script>";
}
?>