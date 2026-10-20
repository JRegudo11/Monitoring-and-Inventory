<?php

session_start();

require_once "../../database/db.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth-pages/login.php");
    exit();
}

if (!isset($_SESSION['company'])) {
    die("Company information is missing from your session.");
}

$company = $_SESSION['company'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard | Products</title>
    <link rel="stylesheet" href="../../design/dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
         <div class="sidebar">

            <h2>MIS</h2>

            <ul>
                <li><a href="../../supplier/dashboard.php">🏠Dashboard</a></li>
                <li><a href="../../supplier/users/users.php">👥Users</a></li>
                <li><a href="../../supplier/products/products.php">📊Product Monitoring</a></li>
                <li><a href="../../supplier/inventory/inventory.php">📋Inventory</a></li>
                <li><a href="../../auth-pages/logout.php">🚪Log-out</a></li>
            </ul>
         </div>

         <!-- main content -->
          <div class="main">

            <!-- navi -->

            <div class="navi">
                <h2>Supplier's Product Monitoring</h2>

                <div class="profile">
                    <span>
                        <?php echo $_SESSION['fullname']; ?>
                    </span>
                </div>
            </div>
          <div class="page-title">
            <h2>Product Monitoring</h2>
            <a href="addproducts.php" class="add-btn"> Add A Product</a>           
          </div>
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Photo</th>
                    <th>Description</th>
                    <th>Company</th>
                    <th>Price</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                 <?php

                        $sql = "SELECT
                                    product_id,
                                    product_name,
                                    product_photo,
                                    product_description,
                                    company_name,
                                    product_price
                                FROM products
                                WHERE company_name = ?
                                ORDER BY product_id ASC";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "s", $company);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) 
                            {

                        ?>
                    <tr>
                        <td><?php echo $row['product_id']; ?> </td>

                        <td><?php echo $row['product_name']; ?></td>
                        
                        <td>
                            <img src="../../uploads/<?php echo $row['product_photo']; ?>" class="product-photo">
                        </td>

                        <td><?php echo $row['product_description']; ?></td>

                        <td><?php echo $row['company_name']; ?></td>

                        <td><?php echo $row['product_price']; ?></td>

                        <td>
                            <a href="../products/view-products.php?product_id=<?php echo $row['product_id']; ?>"
                             class="action-btn view">
                            👁️
                            </a>
                            
                            <a href="../products/edit-products.php?product_id=<?php echo $row['product_id']; ?>"
                            class="action-btn edit">
                            ✏️
                            </a>
                            
                            <a href="../products/deleteproduct.php?product_id=<?php echo $row['product_id']; ?>"
                            class="action-btn delete" onclick="return confirm('Are you sure you want to delete this product?');">
                            🗑️
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>    
        </table>
    </div>

    <div class="page-title">
    <a href="../../supplier/dashboard.php" class="add-btn">Back to Home</a>
    </div>
</body>
</html>