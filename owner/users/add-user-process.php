<?php

require_once "../../database/db.php";

//   Get From Data

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$position = $_POST['position'];
$company = $_POST['company'];

//    Insert Query

$sql = "INSERT INTO users(fullname, email, password, position, company)

VALUES('$fullname', '$email', '$password', '$position' ,'$company' )";

if(mysqli_query($conn,$sql))
{

   echo "<script>
            alert('User Added Successfully.');
            window.location='users.php';
            </script>";

}
else
{
    
    echo "<script>
            alert ('Error Adding User.');
            window.history.back();
    </script>";
}

?>