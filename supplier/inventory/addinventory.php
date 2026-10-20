<?php

session_start();

require_once "../../database/db.php";

if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    header("Location: inventory.php");
    exit();
}

$product_id = (int) $_GET['product_id'];


// Get product
$sql = "SELECT product_id, product_name
        FROM products
        WHERE product_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $product_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


if (!$product) {
    header("Location: inventory.php");
    exit();
}


// Get latest stock
$sql = "SELECT current_stock
        FROM inventory_counts
        WHERE product_id = ?
        ORDER BY count_id DESC
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $product_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$inventory = mysqli_fetch_assoc($result);

$current_stock = $inventory ? $inventory['current_stock'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Inventory</title>
     <link rel="stylesheet" href="../../design/addinventory-history.css">
</head>

<body>

<div class="form-container">

    <h2>Add Inventory</h2>

    <form action="addinventory_process.php" method="POST">

        <!-- Product ID -->
        <div class="adding-inventory">

            <label>Product ID</label>

            <input type="text"
                   value="<?php echo $product['product_id']; ?>"
                   readonly>

            <input type="hidden"
                   name="product_id"
                   value="<?php echo $product['product_id']; ?>">

        </div>


        <!-- Product Name -->
        <div class="adding-inventory">

            <label>Product Name</label>

            <input type="text"
                   value="<?php echo htmlspecialchars($product['product_name']); ?>"
                   readonly>

        </div>


        <!-- Last Stock -->
        <div class="adding-inventory">

            <label>Last Stock</label>

            <input type="number"
                   value="<?php echo $current_stock; ?>"
                   readonly>

        </div>


        <!-- Added Stock -->
        <div class="adding-inventory">

            <label>Added Stock</label>

            <input type="number"
                   name="added_stock"
                   placeholder="Enter Added Stock"
                   min="1"
                   required>

        </div>


        <!-- Buttons -->
        <div class="button">

            <button type="submit" class="save-btn">
                <i class="fa-solid fa-plus"></i>
                Add Inventory
            </button>

            <a href="inventory.php" class="cancel-btn">
                Cancel
            </a>

        </div>

    </form>

</div>

</body>

</html>