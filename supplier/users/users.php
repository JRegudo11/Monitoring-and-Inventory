<?php

session_start();

require_once "../../database/db.php";

if(!isset($_SESSION['id'])){
    header("Location: ../../auth-pages/login.php");
    exit();
}

// Get the logged-in supplier's company
if(!isset($_SESSION['company'])){
    die("Company information is missing from your session.");
}

$company = $_SESSION['company'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supplier's Dashboard | User Management</title>

    <link rel="stylesheet" href="../css/dashboard.css">
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
                    <a href="users.php">
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

                <h2>Supplier's Users Management</h2>

                <div class="profile">

                    <span>
                        <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                    </span>

                </div>

            </div>


            <!-- Page Title -->
            <div class="page-title">

                <h2>User Management</h2>

                <a href="../users/add-user.php" class="add-btn">
                    Add New User
                </a>

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


            <!-- User Table -->
            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Company</th>
                            <th>Date&Time Register</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php
                        $sql = "SELECT
                                    id,
                                    fullname,
                                    email,
                                    position,
                                    company,
                                    dateandtime
                                FROM users
                                WHERE company = ?
                                ORDER BY id ASC";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param(
                            $stmt,
                            "s",
                            $company
                        );

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);


                        while($row = mysqli_fetch_assoc($result))
                        {
                        ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($row['id']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['fullname']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['email']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['position']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['company']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['dateandtime']); ?>
                                </td>

                                <td>

                                    <!-- View -->
                                    <a href="../users/view-user.php?id=<?php echo $row['id']; ?>"
                                       class="action-btn view">
                                        👁️
                                    </a>


                                    <!-- Edit -->
                                    <!--
                                    <a href="edit-user.php?id=<?php echo $row['id']; ?>"
                                       class="action-btn edit">
                                        ✏️
                                    </a>
                                    -->


                                    <!-- Delete -->
                                    <a href="../users/delete-user.php?id=<?php echo $row['id']; ?>"
                                       class="action-btn delete"
                                       onclick="return confirm('Are you sure you want to delete this user?');">
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


            <!-- Back to Home -->
            <div class="page-title">

                <a href="../../supplier/dashboard.php"
                   class="add-btn">

                    Back to Home

                </a>

            </div>

        </div>

    </div>

</body>
</html>