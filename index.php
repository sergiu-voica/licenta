<?php
  require "header.php";
?>  

  <main>

    <?php
    if (isset($_SESSION['userUid'])) {
      require "loggedin.php";
    } else {
      echo '<h1>Welcome to Tracktruck!</h1>
      <p>Where you can track your vehicles in real time anytime</p>
      ';
    }
    ?>

  </main> 

<?php
  require "footer.php";
?>
