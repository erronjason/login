<?php
session_start();
require_once("settings.php");
require_once 'class.user.php';

// Set up our database connection
try {
  $handler = new PDO($dsn,$db_username,$db_password);
  $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error) {
  echo $error->getMessage();
}

$user = new User($handler);

// Create our empty error queue
$errors = array();

// TODO: check if logged in

if ($_GET['t'] === "r") {
  // Check up on the form data and filter it accordingly
  if (!isset($_GET['username']) or $_GET['username'] === '') {
    array_push($errors, "You must specify a username");
  }
  if (strlen($_GET['username']) > 32) {
    array_push($errors, "Your username cannot be over 32 characters");
  }
  if (strlen($_GET['username']) < 5) {
    array_push($errors, "Your username must be 5 or more characters long");
  }
  if (!preg_match_all('/^[a-zA-Z0-9_\-]+$/', $_GET['username'])) {
    array_push($errors,
               "Usernames may only contain hyphens, underscores and be alphanumeric");
  } else {
    // This should only be run post-ensuring the password is sanitized
    if ($user->usernameInUse($_GET['username'])) {
      array_push($errors, "That username already in use");
    }
  }

  if (!isset($_GET['email']) or $_GET['email'] === '') {
    array_push($errors, "You must specify an email address");
  }
  /* The filtering here isn't technically RFC-5321
  compliant, but I don't care about those people.
  Get a gmail for goodness sakes; it's the 2000's.
  (Though it does adhere fairly well to RFC-822)*/
  $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
  if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) === true) {
    array_push($errors, $email . " isn't a valid email address");
  } else {
    if ($user->emailInUse($email)) {
      array_push($errors, "That email address is already in use");
    }
  }
  if (strlen($email) > 254) {
    array_push($errors,
               "Your email address cannot be more than 254 characters long");
  }
  $password = $_GET['password'];
  if (!isset($_GET['password']) or $password === '') {
    array_push($errors, "You must specify a password");
  }
  if (strlen($password) < 8) {
    array_push($errors, "Your password must be 8 or more characters");
  }
  if (!preg_match_all('/^(?=.*[a-z])(?=.*[A-Z]).+$/', $password)) {
    array_push($errors,
               "Your password must include upper and lowercase characters");
  }


  // Return response to registration page
  if (count($errors) > 0) {
    print json_encode($errors);
  } elseif ($user->register($_GET['username'],
                        $email,
                        password_hash($_GET['password'], PASSWORD_DEFAULT))) {
    print json_encode(array("success"));
  }
} elseif ($_GET['t'] === "l") {
  if (!isset($_GET['username']) or $_GET['username'] === '') {
    array_push($errors, "You must specify a username");
  }
  if (!isset($_GET['password']) or $_GET['password'] === '') {
    array_push($errors, "You must specify a password");
  }
  if (!preg_match_all('/^[a-zA-Z0-9_\-]+$/', $_GET['username'])) {
    array_push($errors, "Invalid username or password");
  }

  if (count($errors) > 0) {
    print json_encode($errors);
  } elseif ($user->login($_GET['username'], $_GET['password'])) {
    print json_encode(array("success"));
  }
}

?>
