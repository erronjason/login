<?php
require_once("settings.php");



class User {
  /// Handles user interaction when
  /// provided a database connection.

  private $handler;

  public __construct($_handler) {
    $this->handler=$_handler;
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

      $statement = $this->handler->prepare("insert into users (username, email, password) values (:username, :email, :password)");
      $statement->bindParam(':username', $username);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':password', $password);
      $statement->execute();
      return $statement;
    } catch(PDOException $error) {
      echo $error->getMessage();
    }
  }

  public function checkUsername($username) {
    $statement = $handler->prepare("select * from users where username=:username limit 1");
    $statement->execute(array(':username'=>$username));
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

  public function login($username, $password) {
    // check password_verify() to verify hash
    // set the fact that we're logged in on the session
    try {
      $statement = $this->db->prepare("select * from users where username=:username limit 1");
      $statement->execute(array(':username'=>$username));
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if($row['username'] === $username) {
        if(password_verify($row['password'], $password)) {
          $_SESSION['session'] = $row['id'];
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
    catch(PDOException $error) {
      echo $error->getMessage();
    }
  }
}

?>
