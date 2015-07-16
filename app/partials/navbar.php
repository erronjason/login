<div id="dashboard">
  <?php if(isset($_SESSION['session'])){ ?>
    <a href='dashboard.php' id='logout'>Home</a>
    <a href='logout.php' id='logout'>Logout</a>
  <?php } elseif(basename($_SERVER['PHP_SELF']) === "login.php") {
    ?><a id="login" href="register.php">Register</a>
    <?php
  }
  else {?>
    <a id="login" href="login.php">login</a>
  <?php }
  ?>
</div>
