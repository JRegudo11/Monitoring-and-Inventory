<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS-Register</title>
    <link rel="stylesheet" href='../design/register.css'>
</head>
<body>
    
<div class="login-box">

    <h2> Create an Account</h2>

    <form action="register-process.php" method= "POST" enctype= "multipart/form-data">

        <input type="text"
        name="fullname"
        placeholder="Full Name"
        required>

        <input type="email"
        name= "email"
        placeholder= "Email"
        required>

        <input type="password"
        name= "password"
        placeholder= "Password"
        required>

        <button type="submit">
            Register
        </button>
        
</form>

    <p>
        Already have an account?
        <a href="login.php">Log-in Here</a>
    </p>
</div>
</body>
</html>