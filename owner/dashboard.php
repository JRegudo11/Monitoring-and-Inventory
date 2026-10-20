<?php

session_start();

require_once "../database/db.php";

// To Prevent Browser Caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset ($_SESSION['id'])) {
        header("Location: ../auth-pages/login.php");
        exit();
}
?>
<!DOCTYPE html>
<html>
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="../design/dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
         <div class="sidebar">

            <h2>MIS</h2>

            <ul>
                <li><a href="dashboard.php">🏠Dashboard</a></li>
                <li><a href="../owner/users/users.php">👥Users</a></li>
                <li><a href="../owner/products/products.php">📊Product Monitoring</a></li>
                <li><a href="../owner/inventory/inventory.php">📋Inventory</a></li>
                <li><a href="../auth-pages/logout.php">🚪Log-out</a></li>
            </ul>
         </div>

         <!-- main content -->
          <div class="main">

            <!-- navi -->

            <div class="navi">
                <h2>Owner's Dashboard</h2>

                <div class="profile">
                    <span>
                        <?php echo $_SESSION['fullname']; ?>
                    </span>
                </div>
            </div>
            <div class="cards">
                
            <div class="card">
                <h3>Total Products</h3>

                <h1>
                    <?php   
                        $sql= "SELECT COUNT(*) AS total_data
                                FROM products";
                        $result = mysqli_query($conn,$sql);
                        while($row= mysqli_fetch_assoc($result)) {
                            ?>
                            <?php echo $row['total_data'];?>
                            <?php
                        }
                    ?>
                </h1>
            </div>
            <div class="card">
                <h3>Total Users</h3>

                <h1>
                    <?php
                        $sql = "SELECT COUNT(*) AS total_data
                                FROM users";
                        $result = mysqli_query($conn,$sql);
                        while($row=mysqli_fetch_assoc($result)) {
                            ?>
                            <?php echo $row['total_data'];?>
                            <?php
                        }
                    ?>
                </h1>
            </div>
            </div>
            
          </div>
    </div>
</body>
</html>