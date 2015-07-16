<?php
if (isset($_SESSION)) {
  session_destroy();
}
if (isset($_SESSION['session'])){
  unset($_SESSION['session']);
}
setcookie ('PHPSESSID', "", 1);
setcookie ('PHPSESSID', false);
unset($_COOKIE['PHPSESSID']);
header('Location: login.php?l=s');
?>
