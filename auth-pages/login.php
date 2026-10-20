<?php

if(isset($_SESSION['id'])){

    if($_SESSION['position'] == "Owner") {
        header("Location:../owner/dashboard.php");
    } elseif ($_SESSION['position'] == "Supplier") {
        header ("Location:../supplier/dashboard.php");
    }
    else {
        header ("Location:../diser/dashboard.php");
    }

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS Log-In</title>
    <link rel="stylesheet" href='../design/log-in.css'>
</head>
<body>
    <div class="login">
        <h2>Log-In</h2>

        <form action="login-process.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Log-in</button>
        </form>

        Don't have an account?
        <a href="../index.php#contact">Please Contact The Owner</a>
    </div>
</body>
</html>