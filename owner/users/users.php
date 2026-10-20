<?php

session_start();

require_once "../../database/db.php";

if(!isset($_SESSION['id'])){
    header("Location: ../../auth-pages/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner's Dashboard | User Management</title>
    <link rel="stylesheet" href="../../design/dashboard.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">

        <h2>MIS</h2>

        <ul>
            <li><a href="../../owner/dashboard.php">🏠Dashboard</a></li>
            <li><a href="users.php">👥Users</a></li>
            <li><a href="../../owner/products/products.php">📊Product Monitoring</a></li>
            <li><a href="../../owner/inventory/inventory.php">📋Inventory</a></li>
            <li><a href="../../auth-pages/logout.php">🚪Log-out</a></li>
        </ul>

    </div>

    <!-- Main Content -->
    <div class="main">

        <!-- Navigation -->
        <div class="navi">

            <h2>Owner's Users Management</h2>

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


        <!-- Company Filter -->
        <div class="company-filter">

            <form method="GET">

                <label for="company">View Company:</label>

                <select name="company"
                        id="company"
                        onchange="this.form.submit()">

                    <option value="">All Companies</option>

                    <?php

                    $company_sql = "
                        SELECT DISTINCT company
                        FROM users
                        WHERE company IS NOT NULL
                        AND company != ''
                        ORDER BY company ASC
                    ";

                    $company_result = mysqli_query($conn, $company_sql);

                    while($company_row = mysqli_fetch_assoc($company_result)){

                        $company = htmlspecialchars($company_row['company']);

                        $selected = (
                            isset($_GET['company']) &&
                            $_GET['company'] === $company
                        ) ? 'selected' : '';

                        echo "
                            <option value=\"$company\" $selected>
                                $company
                            </option>
                        ";
                    }

                    ?>

                </select>

            </form>

        </div>


        <!-- Users Table -->
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
                if(isset($_GET['company']) && $_GET['company'] !== ''){

                    $company = $_GET['company'];

                    $sql = "
                        SELECT
                            id,
                            fullname,
                            email,
                            position,
                            company,
                            dateandtime
                        FROM users
                        WHERE company = ?
                        ORDER BY id ASC
                    ";

                    $stmt = mysqli_prepare($conn, $sql);

                    mysqli_stmt_bind_param(
                        $stmt,
                        "s",
                        $company
                    );

                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                } else {
                    $sql = "
                        SELECT
                            id,
                            fullname,
                            email,
                            position,
                            company,
                            dateandtime
                        FROM users
                        ORDER BY id ASC
                    ";

                    $result = mysqli_query($conn, $sql);

                }
                while($row = mysqli_fetch_assoc($result)){

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
                            <?php echo ($row['company']); ?>
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
                            <a href="edit-user.php?id=<?php echo $row['id']; ?>"
                               class="action-btn edit">
                                ✏️
                            </a>

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


        <!-- Back Button -->
        <div class="page-title">

            <a href="../../owner/dashboard.php"
               class="add-btn">
                Back to Home
            </a>

        </div>

    </div>

</div>

</body>
</html>