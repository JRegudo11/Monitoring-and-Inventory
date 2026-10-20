<?php

session_start();

require_once "../../database/db.php";

if(!isset($_GET['product_id'])){
        header("Location: products.php");
        exit();
}

$id=$_GET['product_id'];

$sql = "SELECT * FROM products WHERE product_id='$id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_assoc($result);

if(!$user){
    echo "<script>
        alert('Product not Found.');
        window.location='products.php';
        </script>";
        exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Monitoring</title>
    <link rel="stylesheet" href="../../design/add-edit-view-products.css">
</head>
<body>
   <div class="content">
        <div class="page-title">
            <h2>Product Details</h2>
        </div>
        <div class="view-container">
            <div class="info-group">
                <label>Product ID</label>
                <div class="info">
                        <?php echo $user['product_id']; ?>
                </div>
            </div>
            <div class="info-group">
                <label>Product Name</label>
                <div class="info">
                    <?php echo $user['product_name']; ?>
                </div>
            </div>
            <div class="info-group">
                <label>Product Photo</label>
                <div class="info">
                    <img src="../../uploads/<?php echo $user ['product_photo']; ?>">
                </div>
            </div>
            <div class="info-group">
                <label>Description</label>
                <div class="info">
                        <?php echo $user['product_description']; ?>
                </div>
            <div class="info-group">
                <label>Company</label>
                <div class="info">
                        <?php echo $user['company_name'];?>
                </div>
            <div class="info-group">
                    <label>Price</label>
                    <div class="info">
                        <?php echo $user['product_price']; ?>
                    </div>
            </div>

            <div class="buton-group">
                    <a href="products.php" class="back-btn">
                        Back
                    </a>
            </div>
        </div>
   </div> 
</body>
</html>