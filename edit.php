

<div >
    <div class="form-popup" id="edit-user">
        <form class="db-form" action="" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="mail" placeholder="E-mail">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="rpassword" placeholder="Repeat password">
        <button type="submit" name="edit-user">Edit user</button>
        </form>
    </div>
</div>
<?php 
    // session_start();
    if (isset($_POST['edit-user'])) {
        require 'includes/db.php';

        $auth = isset($_SESSION['userUid']);
        if(!$auth) {
            header("Location: index.php?p=edit&auth=false");
            exit();
        }
        editUser($conn);
    }

    function editUser($conn) {
        $username = $_POST['username']; 
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['rpassword'];
        $id = $_GET['id'];

        if (empty($username) || empty($email) || empty($password) || empty($repeatpassword)) {
            header("Location: index.php?p=edit&error=emptyfields&uid=".$username."&mail=".$email);
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: index.php?p=edit&error=invalidmailusername");
            exit();
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?p=edit&error=invalidmail&uid=".$username);
            exit();
        } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: index.php?p=edit&error=invalidusername&mail=".$email);
            exit();
        } else if ($password !== $repeatpassword) {
            header("Location: index.php?p=edit&error=passwordcheck&uid=".$username."&mail=".$email);
            exit();
        } else {
            $sql = "SELECT usernameUsers FROM users WHERE usernameUsers=?"; // nu verificam aici direct username-ul din motive de securitate, poate fi scris cod sql
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: index.php?p=edit&error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
            
                $sql = "UPDATE users SET usernameUsers = ?, emailUsers = ?, pwdUsers = ? WHERE idUsers=$id";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: index.php?p=edit&error=sqlerror");
                    exit();
                } else {
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpassword);
                    mysqli_stmt_execute($stmt);
                    
                    
                    header("Location: index.php?p=databasequery&edituser=success");
                    
                    exit();
                }
                
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
?>