<?php

session_start();

require_once "../../database/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: inventory.php");
    exit();
}


if (!isset($_POST['product_id']) || !isset($_POST['added_stock'])) {
    header("Location: inventory.php");
    exit();
}


$product_id = (int) $_POST['product_id'];
$added_stock = (int) $_POST['added_stock'];


if ($added_stock <= 0) {
    echo "Added stock must be greater than 0.";
    exit();
}


// Check product
$sql = "SELECT product_id
        FROM products
        WHERE product_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $product_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


if (!$product) {
    echo "Product does not exist.";
    exit();
}


// Get latest current stock
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


// Latest current stock becomes last stock
$last_stock = $inventory
    ? (int) $inventory['current_stock']
    : 0;


// Insert inventory
$sql = "INSERT INTO inventory_counts
        (product_id, last_stock, added_stock, sold)
        VALUES (?, ?, ?, 0)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iii",
    $product_id,
    $last_stock,
    $added_stock
);


if (mysqli_stmt_execute($stmt)) {

    header("Location: inventory.php");
    exit();

} else {

    echo "Error adding inventory: " . mysqli_error($conn);

}

?>