<?php
session_destroy();
unset($_SESSION['session']);
setcookie ('PHPSESSID', "", 1);
setcookie ('PHPSESSID', false);
unset($_COOKIE['PHPSESSID']);
header('Location: register.php');
?>
