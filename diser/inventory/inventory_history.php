<?php

session_start();

require_once "../../database/db.php";


// Check product ID
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {

    header("Location: inventory.php");
    exit();

}

$product_id = (int) $_GET['product_id'];


// Get product information
$sql = "SELECT product_id, product_name
        FROM products
        WHERE product_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $product_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


// Check if product exists
if (!$product) {

    header("Location: inventory.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Inventory History</title>
    <link rel="stylesheet" href="../../design/addinventory-history.css">

</head>

<body>

<div class="history-container">

    <h2>
        Inventory History
    </h2>

    <h3>
        Product ID:
        <?php echo $product['product_id']; ?>
    </h3>

    <h3>
        Product Name:
        <?php echo htmlspecialchars($product['product_name']); ?>
    </h3>


    <table>

        <thead>

            <tr>

                <th>Count ID</th>

                <th>Last Stock</th>

                <th>Added Stock</th>

                <th>Sold</th>

                <th>Current Stock</th>

                <th>Date</th>

            </tr>

        </thead>


        <tbody>

        <?php

        // Get ALL inventory records for this product
        $sql = "SELECT
                    count_id,
                    last_stock,
                    added_stock,
                    sold,
                    current_stock,
                    count_date

                FROM inventory_counts

                WHERE product_id = ?

                ORDER BY count_id ASC";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $product_id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);


        while ($row = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <td>
                    <?php echo $row['count_id']; ?>
                </td>

                <td>
                    <?php echo $row['last_stock']; ?>
                </td>

                <td>
                    <?php echo $row['added_stock']; ?>
                </td>

                <td>
                    <?php echo $row['sold']; ?>
                </td>

                <td>
                    <strong>
                        <?php echo $row['current_stock']; ?>
                    </strong>
                </td>

                <td>
                    <?php
                    echo date(
                        'M d, Y h:i A',
                        strtotime($row['count_date'])
                    );
                    ?>
                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>


    <br>

    <a href="inventory.php">
        Back to Inventory
    </a>

</div>

</body>

</html>