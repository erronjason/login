<?php

class User {
  /// Handles main user related actions

  private $handler;

  function __construct($priv_handler) {
    // Requires an instance of PDO(),
    // I recommend wrapping it in a try
    $this->handler = $priv_handler;
  }

  public function register($username, $email, $password) {
    // Expects sanitized data, and the
    // password should be hashed prior.
    try {
      $statement = $this->handler->prepare("
      insert into users (username, email, password)
      values (:username, :email, :password)");
      $statement->bindParam(':username', $username);
      $statement->bindParam(':email', $email);
      $statement->bindParam(':password', $password);
      return $statement->execute();
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

  public function checkLogin() {
    if(isset($_SESSION['session']))
    {
      return true;
    }
  }

  public function login($username, $password) {
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
