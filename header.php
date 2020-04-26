<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - MySQL Integration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <header>
    <nav>
      <a href="#">
        <img src="image/logo.png" id="logo" alt="logo" width="100px">
      </a>
      <ul>
        <li><a href="index.php">Home</a></li>
      </ul>

      <div id="login-form">
        <?php
          if (isset($_SESSION['userUid'])) {
            echo '<form action="includes/logout.php" method="POST">
            <button type="submit" name="submit-logout" value="Logout">Logout</button>
          </form> ';
          } else {
            echo '<form action="includes/login.php" method="POST">
            <input type="text" id="usermail" name="usermail" placeholder="Username/Email"><br>
            <input type="password" id="password" name="password" placeholder="Password"><br><br>
            <button type="submit" name="submit-login" value="Submit">Login</button>
          </form> 
          <a href="signup.php">Signup</a>';
          }
        ?>

      </div>

    </nav>
  </header>

