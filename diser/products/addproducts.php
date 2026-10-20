<?php

session_start();

require_once "../../database/db.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
     <link rel="stylesheet" href="../../design/add-edit-view-products.css">
</head>
<body>
   <div class="form-container">

    <form action="addproducts_process.php" method="POST" enctype="multipart/form-data">
        <div class="adding-product">
            <label>Product Name</label>
            <input type="text" name="product_name" placeholder="Enter Product Name" required>
        </div>

        <div class="adding-product">
            <label>Description</label>
            <input type="text" name="product_description" placeholder= "Enter Products Description" required>
        </div>

        <div class="adding-product">
            <label>Company</label>
            <input type="text" name= "company_name" placeholder="Enter The Company" required>
        </div>

        <div class="adding-product">
            <label>Price</label>
            <input type="number" 
                        name="product_price" placeholder="Input The Price Here" step="0.01" min="0" required>
        </div>

        <div class="button">

            <button type="submit" class="save-btn">
                Save Product
            </button>

            <a href="products.php" class="cancel-btn">
                Cancel
            </a>
        </div>
    </form>
   </div> 
    
</body>
</html>