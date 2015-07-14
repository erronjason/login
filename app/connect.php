<?php
include("settings.php");
try {
    $handler = new PDO($dsn, $username, $password);
    // Clean values
    $statement = $handler->prepare("insert into users (username, email, password) values (:username, :email, :password)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $username = 'Bryce';
    $email    = 'bryce@example.com';
    $password = password_hash('password4', PASSWORD_DEFAULT);
    $statement->execute();
    foreach($handler->query('select * from users') as $row) {
      print_r($row);
      print "<br>";
    }
   $handler = null; // Unset the credentials in memory
} catch (PDOException $error) {
  print "Error!: " . $error->getMessage() . "<br>";
  die();
}
?>
