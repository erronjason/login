<?php
session_start();
unset($_SESSION['username']);
setcookie ('PHPSESSID', "", 1);
setcookie ('PHPSESSID', false);
unset($_COOKIE['PHPSESSID']);

header('Location: login.php');
?>
