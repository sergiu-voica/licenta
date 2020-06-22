
  
<?php
    if ( ! isset($_POST['show-database']) ) { // not submitted yet
?>
  <script>
    window.onload = function() {
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
  if (isset($_GET['addcargo'])) {
    if ($_GET['addcargo'] == "success") {
      echo '<p class="success">Cargo added to database!</p>';
    }
  }
  if (isset($_GET['removecargo'])) {
    if ($_GET['removecargo'] == "success") {
      echo '<p class="success">Cargo removed from the database!</p>';
    }
  }
  if (isset($_GET['editcargo'])) {
    if ($_GET['editcargo'] == "success") {
      echo '<p class="success">Cargo successfully edited!</p>';
    }
  }
  if (isset($_GET['p'])) {
    if ($_GET['p'] == "edit") {
      echo '<p>Editing cargo entry with id '.$_GET['id'].'...</p>';
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
      <input type="text" name="show-database-query" placeholder="Enter query" value='SELECT * FROM cargo'>
      <button type="submit"  id="show-database" name="show-database" value="Submit">Show database</button>
    </form>
  </div>
  <div>
    <form class="db-form" action="insertCargo.php" method="POST">
      <!-- <input type="text" name="id_user" placeholder="Username">     -->
      <input type="text" name="id_masina" placeholder="Vehicle Number">
      <input type="text" name="description" placeholder="Description">
      <button type="submit" name="add-cargo">Add cargo to database</button>
    </form>
  </div>
</div>

<?php
  function showDatabase($input, $conn) {
    if (empty($input)) {
      header("Location: index.php?p=databasequery&error=emptyquery");
      exit();
    } else {
        if(strpos($input, "DELETE") !== false){
          $sql = $input;
          $result = mysqli_query($conn, $sql);
          header("Location: index.php?p=databasequery&removeuser=success");
          exit();
        } else {
            $sql = $input;
            $result = mysqli_query($conn, $sql);
            $result_check = mysqli_num_rows($result);
            if ($result_check > 0) {
              ?>
                <table id="database">
                  <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Car ID</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                  </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tr>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['userUid']?></td>
                      <td><?php echo $row['vehicleNumber']?></td>
                      <td><?php echo $row['denumire']?></td>

                      <td><a href="index.php?pg=cargo&p=edit&id=<?php echo $row["id"]; ?>&e=cargo"><img src="https://img.pngio.com/circle-compose-draw-edit-write-icon-edit-icon-png-512_512.png" alt="edit" width="30px"></a>
                      <td><a href="index.php?pg=cargo&p=delete&id=<?php echo $row["id"]; ?>&e=cargo"><img src="https://toppng.com/uploads/preview/delete-circle-icon-11563655960vxqxj7ly3u.png" alt="delete" width="30px"></a>
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
      header("Location: index.php?p=databasequery&auth=false");
    }
    $input = $_POST['show-database-query'];
    showDatabase($input, $conn);
  }
?>
           