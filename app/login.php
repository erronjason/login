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
  <script type="text/javascript" src="lib/js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $("#submit").click(function(){
      username=$("#username").val();
      email=$("#email").val();
      pass=$("#password").val();
      $.ajax({
        url: "process.php",
        dataType: 'json',
        data: "t=l&username="+username+"&password="+pass,
        success: function(json) {
          if (json[0] == 'success') {
            console.log("Login successful!");
          } else {
            console.log("Error: "+json);
          }
        }
      })
    })
      return false;
  })
  </script>
</head>


<body>
  <div id="dashboard">
    <?php if(isset($_SESSION['session'])){ ?>
      <a href='logout.php' id='logout'>Logout</a>
    <?php }else {?>
      <a id="login" href="register.php">Register</a>
    <?php } ?>
  </div>
  <div id="login">
    <div class="errors" id="error"></div>
    <form id="form" method="post" onsubmit="return false;" action="process.php">
      <p>
        <label>Username:</label>
        <input type="text" id="username" name="username" />
      </p>
      <p>
        <label>Password:</label>
        <input type="password" id="password" name="password" />
      </p>
      <p>
        <label></label><br/>
        <input type="submit" id="submit" value="Login" />
      </p>
    </form>
  </div>
</body>
</html>
