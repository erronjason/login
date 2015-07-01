<?php
session_start();
session_regenerate_id(true);
$token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $token;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration | Bravelogin</title>
</head>
<body>
  <form action="submit.php" method="post">
    <p>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="" maxlength="32" />
    </p>
    <p>
      <label for="password">Password:</label>
      <input type="text" id="password" name="password" value="" maxlength="64" />
    </p>
    <p>
      <input type="hidden" name="form_token" value="<?php echo $token; ?>" />
      <input type="submit" value="Login" />
    </p>
  </form>
</body>
</html>
