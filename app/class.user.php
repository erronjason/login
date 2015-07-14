<?php

class User {
  /// Handles user interaction when
  /// provided a database connection.

  private $handler;

  function __construct($priv_handler) {
    $this->handler = $priv_handler;
  }

  public function logout() {
    session_destroy();
    unset($_SESSION['username']);
    setcookie ('PHPSESSID', "", 1);
    setcookie ('PHPSESSID', false);
    unset($_COOKIE['PHPSESSID']);
    header('Location: login.php');
  }



  public function register($username, $email, $password) {
    try {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $statement = $this->handler->prepare("
      insert into users (username, email, password)
      values (:username, :email, :password)");
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
    $statement = $handler->prepare("
    select * from users
    where username=:username
    limit 1");
    $statement->execute(array(':username'=>$username));
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($rows[0][username] === $username) {
      return "Username already in use!";
    } else {
      return "Username is available";
    }
  }

  public function checkLogin($username) {
    return true;
  }

  public function login($username, $password) {
    // Return false if username or password are wrong.
    // If true, set id on session.
    try {
      $statement = $this->handler->prepare("
      select * from users
      where username=:username
      limit 1");
      $statement->execute(array(':username'=>$username));
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if($row['username'] === $username) {
        if(password_verify($password, $row['password'])) {
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
