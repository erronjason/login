<?php
	session_destroy();
  unset($_SESSION['username']);
  setcookie ('PHPSESSID', "", 1);
  setcookie ('PHPSESSID', false);
  unset($_COOKIE['PHPSESSID']);
  // TODO: Change this to login/home page
  header('Location: register.php');
?>
