<?php

session_start();

require_once "../../database/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Owner Dashboard | Inventory</title>
    <link rel="stylesheet" href="../../design/dashboard.css">

</head>

<body>
    <div class="container">
        <!-- Sidebar -->
         <div class="sidebar">

            <h2>MIS</h2>

            <ul>
                <li><a href="../../owner/dashboard.php">🏠Dashboard</a></li>
                <li><a href="../../owner/users/users.php">👥Users</a></li>
                <li><a href="../../owner/products/products.php">📊Product Monitoring</a></li>
                <li><a href="../../owner/inventory/inventory.php">📋Inventory</a></li>
                <li><a href="../../auth-pages/logout.php">🚪Log-out</a></li>
            </ul>
         </div>

         <!-- main content -->
          <div class="main">

            <!-- navi -->

            <div class="navi">
                <h2>Owner's Product Inventory</h2>

                <div class="profile">
                    <span>
                        <?php echo $_SESSION['fullname']; ?>
                    </span>
                </div>
            </div>
          <div class="page-title">
            <h2>Product Inventory</h2>
            <!-- <a href="../products/addproducts.php" class="add-btn"> Add A Product</a>            -->
          </div>

<div class="table-container">

    <table>

        <thead>

            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Last Stock</th>
                <th>Added Stock</th>
                <th>Sold</th>
                <th>Current Stock</th>
                <th>Status</th>
                <th>Last Date Count</th>
                <th width="180">Actions</th>
            </tr>

        </thead>

        <tbody>

        <?php

        $sql = "SELECT
                    p.product_id AS `Product ID`,
                    p.product_name AS `Product Name`,

                    COALESCE(ic.last_stock, 0) AS `Last Stock`,
                    COALESCE(ic.added_stock, 0) AS `Added Stock`,
                    COALESCE(ic.sold, 0) AS `Sold`,
                    COALESCE(ic.current_stock, 0) AS `Current Stock`,

                    ic.count_date AS `Last Date Count`

                FROM products p

                LEFT JOIN inventory_counts ic
                    ON ic.count_id = (
                        SELECT MAX(ic2.count_id)
                        FROM inventory_counts ic2
                        WHERE ic2.product_id = p.product_id
                    )

                ORDER BY p.product_id ASC";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <!-- Product ID -->
                <td>
                    <?php echo $row['Product ID']; ?>
                </td>


                <!-- Product Name -->
                <td>
                    <?php echo htmlspecialchars($row['Product Name']); ?>
                </td>


                <!-- Last Stock -->
                <td>
                    <?php echo $row['Last Stock']; ?>
                </td>


                <!-- Added Stock -->
                <td>
                    <?php echo $row['Added Stock']; ?>
                </td>


                <!-- Sold -->
                <td>
                    <?php echo $row['Sold']; ?>
                </td>


                <!-- Current Stock -->
                <td>
                    <strong>
                        <?php echo $row['Current Stock']; ?>
                    </strong>
                </td>


                <!-- Status -->
                <td>

                    <?php

                    $stock = $row['Current Stock'];

                    if ($stock == 0) {

                        echo '<span class="status out">
                                Out of Stock
                              </span>';

                    } elseif ($stock <= 10) {

                        echo '<span class="status low">
                                Low Stock
                              </span>';

                    } else {

                        echo '<span class="status available">
                                In Stock
                              </span>';

                    }

                    ?>

                </td>


                <!-- Last Date Count -->
                <td>

                    <?php

                    if ($row['Last Date Count']) {

                        echo date(
                            'M d, Y h:i A',
                            strtotime($row['Last Date Count'])
                        );

                    } else {

                        echo "No Count";

                    }

                    ?>

                </td>


                <!-- Actions -->
                <td>

                    <!-- Add Inventory -->
                    <a href="../inventory/addinventory.php?product_id=<?php echo $row['Product ID']; ?>"
                       class="action-btn add"
                       title="Add Inventory">

                    ➕

                    </a>


                    <!-- Sell Stock -->
                    <a href="../inventory/sellinventory.php?product_id=<?php echo $row['Product ID']; ?>"
                       class="action-btn sell"
                       title="Sell Stock">

                    🛒

                    </a>

                    <a href="inventory_history.php?product_id=<?php echo $row['Product ID']; ?>"
                        class="action-btn history"
                        title="Inventory History">

                    📜

                    </a>

                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>

</div>


<br>


<!-- Back to Dashboard -->
 <div class="page-title">
<a href="../../owner/dashboard.php" class="add-btn">
    Back to Home
</a>
</div>

</body>

</html>