<?php 
    session_start();
    if (isset($_POST['add-user'])) {
        require 'includes/db.php';

        $auth = isset($_SESSION['userUid']);
        if(!$auth) {
            header("Location: index.php?pg=databasequery&auth=false");
            exit();
        }
        addUser($conn);
    }

    function addUser($conn) {
        $username = $_POST['username']; 
        $email = $_POST['mail'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['rpassword'];

        if (empty($username) || empty($email) || empty($password) || empty($repeatpassword)) {
            header("Location: index.php?pg=databasequery&error=emptyfields&uid=".$username."&mail=".$email);
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: index.php?pg=databasequery&error=invalidmailusername");
            exit();
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?pg=databasequery&error=invalidmail&uid=".$username);
            exit();
        } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: index.php?pg=databasequery&error=invalidusername&mail=".$email);
            exit();
        } else if ($password !== $repeatpassword) {
            header("Location: index.php?pg=databasequery&error=passwordcheck&uid=".$username."&mail=".$email);
            exit();
        } else {
            $sql = "SELECT usernameUsers FROM users WHERE usernameUsers=?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: index.php?pg=databasequery&error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: index.php?pg=databasequery&error=userttaken&mail=".$email);
                    exit();
                } else {
                    $sql = "INSERT INTO users (usernameUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: index.php?pg=databasequery&error=sqlerror");
                        exit();
                    } else {
                        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpassword);
                        mysqli_stmt_execute($stmt);
                        
                        header("Location: index.php?pg=databasequery&adduser=success");
                        
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }