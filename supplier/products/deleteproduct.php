<?php

session_start();

require_once "../../database/db.php";

// if(!isset($_SESSION['product_id'])){

//     header("Location: ../products/products.php");
//     exit();
// }

// Check if the ID exist

if(!isset($_GET['product_id'])){
    header("Location:products.php");
    exit();
}

$id= $_GET['product_id'];

// retrieving the user first to get file

$sql= "SELECT * FROM products WHERE product_id='$id'";

$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);

// if the user doesnt exist

if(!$user){
 
    echo "<script>
            alert('Product Not Found.');
            window.location='products.php';
        </script>";

    exit();
}

// Delete the user record

$sql="DELETE FROM products WHERE product_id='$id'";

if(mysqli_query($conn,$sql)){

        echo "<script>
                alert('Product Deleted Successfully');
                window.location='products.php';
                </script>";
}
else {
        echo "<script>
                alert('Unable to Delete Product');
                window.location='products.php';
                </script>";
}
?>