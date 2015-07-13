<?php
session_start();


print_r($_SERVER['HTTP_REFERER']);

$errors = array();
if (!isset($_GET[username]) or $_GET[username] === '') {
  array_push($errors, "You must specify a username");
}
if (!isset($_GET[email]) or $_GET[email] === '') {
  array_push($errors, "You must specify an email address");
}
if (!isset($_GET[password]) or $_GET[password] === '') {
  array_push($errors, "You must specify a password");
}

// Return response to registration page
if (count($errors) > 0){
  print json_encode($errors);
} else {
  print json_encode(array("success"));
}


?>
