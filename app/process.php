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

// TODO: check if logged in

if ($_GET['t'] === "r") {
  // Check up on the form data and filter it accordingly
  if (!isset($_GET['username']) or $_GET['username'] === '') {
    $err_username[] = 'You must specify a username';
  }
  if (strlen($_GET['username']) > 32) {
    $err_username[] = 'Your username cannot be over 32 characters';
  }
  if (strlen($_GET['username']) < 5) {
    $err_username[] = 'Your username must be 5 or more characters long';
  }
  if (!preg_match_all('/^[a-zA-Z0-9_\-]+$/', $_GET['username'])) {
    $err_username[] = 'Usernames may only contain hyphens, underscores and be alphanumeric';
  } else {
    // This should only be run post-ensuring the password is sanitized
    if ($user->usernameInUse($_GET['username'])) {
      $err_username[] = 'That username already in use';
    }
  }

  if (!isset($_GET['email']) or $_GET['email'] === '') {
    $err_email[] = 'You must specify an email address';
  }
  /* The filtering here isn't technically RFC-5321
  compliant, but I don't care about those people.
  Get a gmail for goodness sakes; it's the 2000's.
  (Though it does adhere fairly well to RFC-822)*/
  $mail = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
  if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) === true) {
    $err_email[] = 'Not a valid email address';
  } else {
    if ($user->emailInUse($mail)) {
      $err_email[] = 'That email address is already in use';
    }
  }
  if (strlen($mail) > 254) {
    $err_email[] = 'Your email address cannot be more than 254 characters long';
  }
  $password = $_GET['password'];
  if (!isset($_GET['password']) or $password === '') {
    $err_password[] = 'You must specify a password';
  }
  if (strlen($password) < 8) {
    $err_password[] = 'Your password must be 8 or more characters';
  }
  if (!preg_match_all('/^(?=.*[a-z])(?=.*[A-Z]).+$/', $password)) {
    $err_password[] = 'Your password must include upper and lowercase characters';
  }

  $errors = array('email'=>$err_email, 'username'=>$err_username, 'password'=>$err_password);
  $errcount = count($err_email)+count($err_username)+count($err_password);
  // Return response to registration page
  if ($errcount > 0) {
    print json_encode($errors);
  } elseif ($user->register($_GET['username'],
                        $mail,
                        password_hash($_GET['password'], PASSWORD_DEFAULT))) {
    print json_encode(array("success"));
  }
} elseif ($_GET['t'] === "l") {
  $err_username = array();
  $err_password = array();
  $err_general = array();

  if (!isset($_GET['username']) or $_GET['username'] === '') {
    $err_username[] = 'You must specify a username';
  }
  if (!isset($_GET['password']) or $_GET['password'] === '') {
    $err_password[] = 'You must specify a password';
  }
  if (!preg_match_all('/^[a-zA-Z0-9_\-]+$/', $_GET['username'])) {
    $err_general[] = 'Invalid username or password';
  }
  $errors = array('username'=>$err_username, 'password'=>$err_password, 'general'=>$err_general);
  $errcount = count($err_general)+count($err_username)+count($err_password);
  if ($errcount > 0) {
    print json_encode($errors);
  } elseif ($user->login($_GET['username'], $_GET['password'])) {
    print json_encode(array("success"));
  } else {
    $errors['general'] = 'Invalid username or password';
    print json_encode($errors);
  }
}

?>
