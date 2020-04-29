<?php
  require "header.php";
?>  

  <main>

    <?php
    if (isset($_SESSION['userUid']) && !isset($_GET['p'])) {
      require "homepage.php";
    } else if (isset($_SESSION['userUid']) && $_GET['p'] == 'masini') {
      require "masini.php";
    } else if (isset($_GET['p']) == 'databasequery'){
      require "databasequery.php";
    }
    else {
      echo '<h1>Welcome to Tracktruck!</h1>
      <p>Where you can track your vehicles in real time, anytime, anywhere</p>
      ';
    }
    ?>

  </main> 

<?php
  require "footer.php";
?>
