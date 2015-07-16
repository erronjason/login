<div id="dashboard">
  <?php if(isset($_SESSION['session'])){
    // If user is logged in show dashboard
    ?>
    <a href='dashboard.php' id='logout'>Home</a>
    <a href='logout.php' id='logout'>Logout</a>
  <?php } elseif(basename($_SERVER['PHP_SELF']) === "login.php") {
    // If on the login page
    ?><a id="login" href="register.php">Register</a>
    <?php
  }
  else {
    // If on the registration page
    ?>
    <a id="login" href="login.php">login</a>
  <?php }
  ?>
</div>
