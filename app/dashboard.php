<?php
session_start();
session_regenerate_id(true);
$token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $token;
?>
  <?php if(!isset($_SESSION['session'])){
    header('Location: login.php', true, 302);
  }else { ?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | Bravelogin</title>
  <script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
  <?php include("partials/navbar.php");?>
  <div id="container">
    <div class="floatleft">
      <p>
        <span id="headertext">Welcome to the dashboard!</span>
      </p>
      <div class="infotext">
        <p>Look at all this secret data.</p>
        <p>You can do awesome stuff here, like logout.</p>
      </div>
    </div>
  </div>

</body>
</html>
<?php } ?>
