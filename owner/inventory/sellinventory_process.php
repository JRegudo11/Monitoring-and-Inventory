<?php

session_start();

require_once "../../database/db.php";


// Make sure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: inventory.php");
    exit();

}


// Check required fields
if (
    !isset($_POST['product_id']) ||
    !isset($_POST['sold'])
) {

    header("Location: inventory.php");
    exit();

}


$product_id = (int) $_POST['product_id'];
$sold = (int) $_POST['sold'];


// Quantity must be greater than 0
if ($sold <= 0) {

    echo "Quantity sold must be greater than 0.";
    exit();

}


// --------------------------------------------------
// STEP 1: Check product
// --------------------------------------------------

$sql = "SELECT product_id
        FROM products
        WHERE product_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $product_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


if (!$product) {

    echo "Product does not exist.";
    exit();

}


// --------------------------------------------------
// STEP 2: Get latest stock
// --------------------------------------------------

$sql = "SELECT current_stock
        FROM inventory_counts
        WHERE product_id = ?
        ORDER BY count_id DESC
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $product_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$inventory = mysqli_fetch_assoc($result);


// If no previous inventory record
$current_stock = $inventory
    ? (int) $inventory['current_stock']
    : 0;


// --------------------------------------------------
// STEP 3: Make sure there is enough stock
// --------------------------------------------------

if ($sold > $current_stock) {

    echo "Not enough stock available.";

    exit();

}


// --------------------------------------------------
// STEP 4: Insert the sale
// --------------------------------------------------

$sql = "INSERT INTO inventory_counts
        (
            product_id,
            last_stock,
            added_stock,
            sold
        )
        VALUES (?, ?, 0, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $product_id,
    $current_stock,
    $sold
);


// --------------------------------------------------
// STEP 5: Execute
// --------------------------------------------------

if (mysqli_stmt_execute($stmt)) {

    header("Location: inventory.php");
    exit();

} else {

    echo "Error selling stock: " . mysqli_error($conn);

}

?>