<?php

include "../database/db.php";

$fullname = $_POST['fullname'];

$email = $_POST['email'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$position= "Diser";

// save to database

$sql = "INSERT INTO users( 
fullname,
email, 
position,
password
)
VALUES (
'$fullname',
'$email',
'$position',
'$password'
)";

if(mysqli_query($conn, $sql)){
    
    echo "
    
    <script>
    alert ('Registration Succesful Yohooooo');
    window.location='login.php';
    </script>
    ";

}
else {
    echo "
    
    <script>
    alert ('Registration Failed Huhayyyy');
    window.location='register.php';
    </script>
    ";
}

?>