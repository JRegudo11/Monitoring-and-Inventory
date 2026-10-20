```php
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

    <title>Supplier Dashboard | Inventory</title>

    <link rel="stylesheet" href="../../design/dashboard.css">

</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">

        <h2>MIS</h2>

        <ul>

            <li>
                <a href="../../supplier/dashboard.php">
                    🏠Dashboard
                </a>
            </li>

            <li>
                <a href="../../supplier/users/users.php">
                    👥Users
                </a>
            </li>

            <li>
                <a href="../../supplier/products/products.php">
                    📊Product Monitoring
                </a>
            </li>

            <li>
                <a href="../../supplier/inventory/inventory.php">
                    📋Inventory
                </a>
            </li>

            <li>
                <a href="../../auth-pages/logout.php">
                    🚪Log-out
                </a>
            </li>

        </ul>

    </div>


    <!-- Main Content -->
    <div class="main">

        <!-- Navigation -->
        <div class="navi">

            <h2>Supplier's Product Inventory</h2>

            <div class="profile">

                <span>
                    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                </span>

            </div>

        </div>


        <!-- Page Title -->
        <div class="page-title">

            <h2>Product Inventory</h2>

            <!-- <a href="../products/addproducts.php"
               class="add-btn">

                Add A Product

            </a> -->

        </div>


        <!-- Company -->
        <div class="company-filter">

            <label>
                Company:
            </label>

            <strong>
                <?php echo htmlspecialchars($company); ?>
            </strong>

        </div>


        <!-- Inventory Table -->
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

                        WHERE p.company_name = ?

                        ORDER BY p.product_id ASC";


                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param(
                    $stmt,
                    "s",
                    $company
                );

                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);


                if (!$result) {

                    die("Query Error: " . mysqli_error($conn));

                }


                while ($row = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <!-- Product ID -->
                        <td>
                            <?php echo htmlspecialchars($row['Product ID']); ?>
                        </td>


                        <!-- Product Name -->
                        <td>
                            <?php echo htmlspecialchars($row['Product Name']); ?>
                        </td>


                        <!-- Last Stock -->
                        <td>
                            <?php echo htmlspecialchars($row['Last Stock']); ?>
                        </td>


                        <!-- Added Stock -->
                        <td>
                            <?php echo htmlspecialchars($row['Added Stock']); ?>
                        </td>


                        <!-- Sold -->
                        <td>
                            <?php echo htmlspecialchars($row['Sold']); ?>
                        </td>


                        <!-- Current Stock -->
                        <td>

                            <strong>
                                <?php echo htmlspecialchars($row['Current Stock']); ?>
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
                    <td>
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
        <a href="../../supplier/dashboard.php">

            Back to Home

        </a>

    </div>

</div>

</body>

</html>