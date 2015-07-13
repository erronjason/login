<?php
require_once("settings.php");

class User {
  /// Handles user interaction when 
  /// provided a database connection.

  private $db;

  public __construct($_db) {
    $this->db=$_db;
  }

  public function logout() {
    session_destroy();
    unset($_SESSION['username']);
    setcookie ('PHPSESSID', "", 1);
    setcookie ('PHPSESSID', false);
    unset($_COOKIE['PHPSESSID']);
    header('Location: login.php');
  }

// TODO: fix alllll this below
  public function register($username, $email, $password) {
    try {
    $handler = new PDO($dsn, $username, $email, $password);

    // Clean values
    $statement = $handler->prepare("insert into users (username, email, password) values (:username, :email, :password)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->execute();
  }

  public function checkUsername($username) {
    $statement = $handler->prepare("SELECT username FROM users WHERE username=?");
    $statement->execute(array($username));
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($rows[0][username] === $username) {
      return "Username already in use!";
    } else {
      return "Username is available!";
  }
  }

  public function isLoggedIn {
    // Check to see if token is set in the session
  }

  public function logIn($username, $password) {
    // check password_verify() to verify hash
    // set the fact that we're logged in on the session
  }
}

?>
