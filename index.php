<?php
  require "header.php";
?>  

  <main>

    <?php
    if (isset($_SESSION['userUid'])) {
      if(!isset($_GET['pg'])) {
        require "homepage.php";
      } else if ($_GET['pg'] == 'cargo') {
        include "cargo.php";
      } else if ($_GET['pg'] == 'databasequery') {
        include "databasequery.php";
      } else if($_GET['pg'] == 'cars') {
        include "cars.php";
      }
    } else {
      echo '<h1>Welcome to Tracktruck!</h1>
      <p>Where you can track your vehicles in real time, anytime, anywhere</p>
      ';
    }
    ?>

  </main> 

<?php
  require "footer.php";
?>
