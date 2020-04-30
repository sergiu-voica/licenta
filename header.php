<?php 
  session_start();
  include_once 'includes/db.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - MySQL Integration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>

  <header>
    <nav class="navigation">
      <a href="#">
        <img src="image/logo.png" id="logo" alt="logo" width="100px">
      </a>
      <?php
        if (isset($_SESSION['userUid'])) {
          echo '<ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?pg=cars">Cars</a></li>
            <li><a href="index.php?pg=cargo">Cargo</a></li>
            <li><a href="index.php?pg=databasequery">Useri</a></li>
          </ul>';
        }
      ?>
      <div id="login-form">
        <?php
          if (isset($_SESSION['userUid'])) {
            echo '<p class="welcome">Welcome, '.$_SESSION['userUid'].'<p>';
            echo '<form action="includes/logout.php" method="POST">
            <button type="submit" name="submit-logout" value="Logout">Logout</button>
          </form> ';
          } else {
            echo '<form class="login-form" action="includes/login.php" method="POST">
            <input type="text" id="usermail" name="usermail" placeholder="Username/Email">
            <input type="password" id="password" name="password" placeholder="Password">
            <button type="submit" name="submit-login" value="Submit">Login</button>
          </form>
          <a class="sign-up-button" href="signup.php">Signup</a>';
          }
        ?>

      </div>

    </nav>
  </header>

