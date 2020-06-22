
  
<?php
    if ( ! isset($_POST['show-database']) ) { // not submitted yet
?>
  <script>
  window.onload = function(){
    $("#show-database").click();
  }
  </script>
<?php
    }
?>

<?php
  if (isset($_GET['auth'])) {
    if ($_GET['auth'] == "false") {
      echo '<p class="error">Only authorized users can alter database!</p>';
    }
  }
  if (isset($_GET['addcar'])) {
    if ($_GET['addcar'] == "success") {
      echo '<p class="success">Car added to database!</p>';
    }
  }
  if (isset($_GET['removecar'])) {
    if ($_GET['removecar'] == "success") {
      echo '<p class="success">Car removed from the database!</p>';
    }
  }
  if (isset($_GET['editcar'])) {
    if ($_GET['editcar'] == "success") {
      echo '<p class="success">Car successfully edited!</p>';
    }
  }
  if (isset($_GET['p'])) {
    if ($_GET['p'] == "edit") {
      echo '<p>Editing car entry with id '.$_GET['id'].'...</p>';
    }
  }
?>

<div class="database" id="ops">
<?php 
      if (isset($_GET['p'])) {
        if ($_GET['p'] == "edit") {
          require "edit.php";      
        }
      }
      if (isset($_GET['p'])) {
        if ($_GET['p'] == "delete") {
          require "delete.php";      
        }
      }
  ?>
  <div>
    <form class="db-form" method="POST">
      <input type="hidden" name="show-database-query" placeholder="Enter query" value='SELECT * FROM cars WHERE userUid="<?php
        echo $_SESSION['userUid']?>"'>
      <button type="submit" style="display: none;" id="show-database" name="show-database" value="Submit">Show database</button>
    </form>
  </div>
  <div>
    <form class="db-form" action="insertCar.php" method="POST">
      <input type="text" name="brand" placeholder="Car">
      <input type="text" name="vehicleNumber" placeholder="Registration Plate">
      <?php
        echo '<input type="text" name="user" value="'.$_SESSION['userUid'].'"></input>'; 
      ?>
      <button type="submit" name="add-car">Add car to database</button>
    </form>
  </div>
</div>

<?php
  function showDatabase($input, $conn) {
    if (empty($input)) {
      header("Location: index.php?pg=cars&error=emptyquery");
      exit();
    } else {
        if(strpos($input, "DELETE") !== false){
          $sql = $input;
          $result = mysqli_query($conn, $sql);
          header("Location: index.php?pg=cars&removecar=success");
          exit();
        } else {
            $sql = $input;
            $result = mysqli_query($conn, $sql);
            $result_check = mysqli_num_rows($result);
            if ($result_check > 0) {
              ?>
                <table id="database">
                  <tr>
                    <th>Car ID</th>
                    <th>carName</th>
                    <th>Registration plate</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tr>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['brand']?></td>
                      <td><?php echo $row['vehicleNumber']?></td>
                      <td><a href="index.php?pg=cars&p=edit&id=<?php echo $row["id"]; ?>&e=car"><img src="https://img.pngio.com/circle-compose-draw-edit-write-icon-edit-icon-png-512_512.png" alt="edit" width="30px"></a>
                      <td><a href="index.php?pg=cars&p=delete&id=<?php echo $row["id"]; ?>&e=car" onclick="return confirm('Are you sure you want to delete selected car?');"><img src="https://toppng.com/uploads/preview/delete-circle-icon-11563655960vxqxj7ly3u.png" alt="delete" width="30px"></a>
                    </tr>
                  <?php
                }
                ?>
                </table>
                <?php
                // header("Location: index.php?p=databasequery&database=printed");
            } 
        }
    }
  } 

  if (isset($_POST['show-database'])) {
    $auth = isset($_SESSION['userUid']);
    if(!$auth) {
      header("Location: index.php?pg=cars&auth=false");
    }
    $input = $_POST['show-database-query'];
    showDatabase($input, $conn);
  }
?>
           