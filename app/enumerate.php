<?php
include("settings.php");
try {
    $handler = new PDO($dsn, $db_username, $db_password);

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
