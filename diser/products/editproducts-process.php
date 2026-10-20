<?php

require_once "../../database/db.php";

$id = $_POST['product_id'];
$name= $_POST['product_name'];
$description = $_POST['product_description'];
$company = $_POST['company_name'];
$price = $_POST['product_price'];

// Password

if(!empty($_POST['product_name'])){

    $name= $_POST['product_name'];

    $sql = "UPDATE products SET
            product_name='$name',
            product_description='$description',
            company_name='$company',
            product_price='$price'

            WHERE product_id='$id'";
} else {
    $sql = "UPDATE products SET
            product_name = '$name',
            product_description='$description',
            company_name='$company',
            product_price='$price'
            
            WHERE   product_id='$id'";

}

if(mysqli_query($conn,$sql)) {

    echo "<script>
            alert('Product Updated Successfully.');
            window.location='products.php';
        </script>";
}else {
    echo "<script>
        alert('Failed to Update Product.');
        window.history.back():;
        </script>";
}
?>