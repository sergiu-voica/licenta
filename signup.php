<?php
  require "header.php";
?>

  <main>
    <div>
      <h1>Signup</h1>
      <?php
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "emptyfields") {
            echo '<p class="error">Fill in all fields!</p>';
          } else if ($_GET['error'] == "invalidmailusername") {
            echo '<p class="error">You entered an invalid e-mail or username!</p>';
          } else if ($_GET['error'] == "invalidmail") {
            echo '<p class="error">You entered an invalid e-mail!</p>';
          } else if ($_GET['error'] == "invalidusername") {
            echo '<p class="error">You entered an invalid username!</p>';
          } else if ($_GET['error'] == "passwordcheck") {
            echo '<p class="error">The password you entered doesn\'t match!</p>';
          } else if ($_GET['error'] == "userttaken") {
            echo '<p class="error">Username is already taken!</p>';
          }
        } else if (isset($_GET['success'])) {
          echo '<p class="error">Login Successful!</p>';
        }
      ?>
      <form action="includes/signup.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="mail" placeholder="E-mail">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="rpassword" placeholder="Repeat password">
        <button type="submit" name="signup-submit">Submit</button>
      </form>
    </div>
  </main>

<?php
  require "footer.php";
?>
