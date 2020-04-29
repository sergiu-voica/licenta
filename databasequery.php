<?php
  if (isset($_GET['auth'])) {
    if ($_GET['auth'] == "false") {
      echo '<p class="error">Only authorized users can alter database!</p>';
    }
  }
  if (isset($_GET['adduser'])) {
    if ($_GET['adduser'] == "success") {
      echo '<p class="success">User added to database!</p>';
    }
  }
  if (isset($_GET['removeuser'])) {
    if ($_GET['removeuser'] == "success") {
      echo '<p class="success">User removed from to database!</p>';
    }
  }
?>
<div class="database">
  <div>
    <form class="db-form" method="POST">
      <input type="text" name="show-database-query" placeholder="Enter query">
      <button type="submit" name="show-database" value="Submit">Show database</button>
    </form>
  </div>
  <div>
    <form class="db-form" action="" method="POST">
      <input type="text" name="show-database-query" placeholder="Enter query">
      <button type="submit" name="show-database" value="Submit">Delete from database</button>
    </form>
  </div>
  <div>
    <form class="db-form" method="POST">
      <input type="text" name="username" placeholder="Username">
      <input type="text" name="mail" placeholder="E-mail">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="rpassword" placeholder="Repeat password">
      <button type="submit" name="add-user">Add user to database</button>
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
        } else{
          $sql = $input;
          $result = mysqli_query($conn, $sql);
          $result_check = mysqli_num_rows($result);
          if ($result_check > 0) {
            ?>
              <table id="database">
                <tr>
                  <th>Username</th>
                  <th>E-mail</th>
                  <th>Encrypted pass</th>
                </tr>
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['usernameUsers']?></td>
                    <td><?php echo $row['emailUsers']?></td>
                    <td><?php echo $row['pwdUsers']?></td>
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

  function addUser($conn) {
    $username = $_POST['username'];
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $repeatpassword = $_POST['rpassword'];

    if (empty($username) || empty($email) || empty($password) || empty($repeatpassword)) {
        header("Location: index.php?p=databasequery&error=emptyfields&uid=".$username."&mail=".$email);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: index.php?p=databasequery&error=invalidmailusername");
        exit();
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?p=databasequery&error=invalidmail&uid=".$username);
        exit();
    } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: index.php?p=databasequery&error=invalidusername&mail=".$email);
        exit();
    } else if ($password !== $repeatpassword) {
        header("Location: index.php?p=databasequery&error=passwordcheck&uid=".$username."&mail=".$email);
        exit();
    } else {
        $sql = "SELECT usernameUsers FROM users WHERE usernameUsers=?"; // nu verificam aici direct username-ul din motive de securitate, poate fi scris cod sql
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: index.php?p=databasequery&error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: index.php?p=databasequery&error=userttaken&mail=".$email);
                exit();
            } else {
                $sql = "INSERT INTO users (usernameUsers, emailUsers, pwdUsers) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: index.php?p=databasequery&error=sqlerror");
                    exit();
                } else {
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedpassword);
                    mysqli_stmt_execute($stmt);
                    
                    
                    header("Location: index.php?p=databasequery&adduser=success");
                    
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }

  if (isset($_POST['show-database'])) {
    $auth = isset($_SESSION['userUid']);
    if(!$auth) {
      header("Location: index.php?p=databasequery&auth=false");
    }
    $input = $_POST['show-database-query'];
    showDatabase($input, $conn);
  } else if (isset($_POST['add-user'])) {
      $auth = isset($_SESSION['userUid']);
      if(!$auth) {
        header("Location: index.php?p=databasequery&auth=false");
        exit();
      }
      addUser($conn);
      showDatabase('SELECT * FROM users', $conn);
  }
  

?>
