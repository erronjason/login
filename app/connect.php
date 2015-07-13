<?php
include("settings.php");

try {
    $handler = new PDO($dsn, $username, $password);

    // Clean values
    $statement = $handler->prepare("insert into users (username, email, password, salt) values (:username, :email, :password, :salt)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':salt', $salt);

    $username = 'Bryce';
    $email    = 'bryce@example.com';
    $password = '123pass';
    $salt     = '192847';
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
