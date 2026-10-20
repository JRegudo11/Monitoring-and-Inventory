<?php

    session_start();

    require_once "../../database/db.php";

    if(!isset($_GET['product_id'])){
            header("Location: products.php");
            exit();
    }

    $id = $_GET['product_id'];

    $sql ="SELECT * FROM products WHERE product_id='$id'";

    $result= mysqli_query($conn,$sql);

    $user = mysqli_fetch_assoc($result);

    if(!$user){
        header("Location: products.php");
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Edit Products</title>
        <link rel="stylesheet" href="../../design/add-edit-view-products.css">
    </head>
    <body>
        <div class="page-title">

            <h2>Edit Products</h2>
        </div>

        <div class="form-container">

            <form action="editproducts-process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $user['product_id']; ?>">

                    <div class="form-group">

                        <label>Product Name</label>
                            <input type="text"
                            name="product_name" value="<?php echo $user['product_name']; ?>" 
                            required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                            <input type="text" 
                            name="product_description" value= "<?php echo$user['product_description']; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Company Name</label>
                            <input type="text"
                            name="company_name"
                            value="<?php echo $user['company_name']; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text"
                        name="product_price"
                        value="<?php echo $user['product_price']; ?>"
                        required>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="update-btn">
                            Update Product
                        </button>
                        <a href="products.php" class= "cancel-btn">
                            Cancel
                        </a>
                    </div>
            </form>
        </div>
    </body>
    </html>