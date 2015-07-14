<?php
session_start();

// At some point process.php will resemble this file more
// TODO: Remove test.php from final version

require_once 'class.user.php';
require_once("settings.php");

try {
	$handler = new PDO($dsn,$username,$password);
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error) {
	echo $error->getMessage();
}

$user = new User($handler);

// Testing registration and login functions
// user->register needs to handle errors from
// mysql accordingly and display errors
//print($user->register("Ben", "ben@example.com", password_hash("password", PASSWORD_DEFAULT)));
print($user->login("Ben", "password"));

?>
