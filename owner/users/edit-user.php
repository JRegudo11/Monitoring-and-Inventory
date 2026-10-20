<?php

    session_start();

    require_once "../../database/db.php";

    if(!isset($_GET['id'])){
            header("Location: users.php");
            exit();
    }

    $id = $_GET['id'];

    $sql ="SELECT * FROM users WHERE id='$id'";

    $result= mysqli_query($conn,$sql);

    $user = mysqli_fetch_assoc($result);

    if(!$user){
        header("Location: users.php");
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Edit User</title>
         <link rel="stylesheet" href="../../design/add-edit-view-products.css">
    </head>
    <body>
        <div class="page-title">

            <h2>Edit User</h2>
        </div>

        <div class="form-container">

            <form action="edituser-process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                    <div class="form-group">

                        <label>Full Name</label>
                            <input type="text"
                            name="fullname" value="<?php echo $user['fullname']; ?>" 
                            required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                            <input type="email" 
                            name="email" value= "<?php echo$user['email']; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                            <input type="password"
                            name="password"
                            placeholder="Leave blank to keep current password">
                    </div>

                    <div class="form-group">
                        <label>Position</label>
                        <select name="position">
                            <option value="Owner"
                            <?php if($user['position'] == "Owner") echo "selected"; ?>>
                                Owner
                            </option>

                            <option value="Supplier"
                            <?php if($user['position'] == "Supplier") echo "selected"; ?>>
                                Supplier
                            </option>

                            <option value="Diser"
                            <?php if($user['position'] == "Diser") echo "selected";?>>
                                Diser
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                            <input type="text"
                            name="company" value="<?php echo$user['company']; ?>"
                            required>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="update-btn">
                            Update User
                        </button>
                        <a href="users.php" class= "cancel-btn">
                            Cancel
                        </a>
                    </div>
            </form>
        </div>
    </body>
    </html>