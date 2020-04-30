<?php
  require "header.php";
?>  

  <main>

    <?php
    if (isset($_SESSION['userUid']) && !isset($_GET['p'])) {
      require "homepage.php";
    } else if (isset($_GET['p']) == 'edit' && isset($_GET['p']) != 'databasequery'){
      require "edit.php";
    } else if (isset($_GET['p']) == 'databasequery' && isset($_GET['p']) == 'edit'){
      require "databasequery.php";
    }  else {
      echo '<h1>Welcome to Tracktruck!</h1>
      <p>Where you can track your vehicles in real time, anytime, anywhere</p>
      ';
    }
    ?>

  </main> 

<?php
  require "footer.php";
?>
