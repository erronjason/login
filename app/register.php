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
      password=$("#password").val();
      $.ajax({
        url: "process.php",
        dataType: 'json',
        data: "username="+username+"&email="+email+"&password="+password,
        success: function(json) {
          if (json[0] == 'success') {
            console.log("Registration successful!");
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
      <?php if(isset($_SESSION['username'])){
      ?>
      <a href='logout.php' id='logout'>Logout</a>
    <?php }else {?>
    <a id="login" href="login.php">login</a>
        <?php } ?>
  </div>
  <div id="register">
    <div class="errors" id="error"></div>
    <form id="form" method="post" onsubmit="return false;" action="process.php">
      <p>
        <label>Username:</label>
        <input type="text" id="username" name="username" />
      </p>
      <p>
        <label>Email:</label>
        <input type="text" id="email" name="email" />
        </p>
      <p>
        <label>Password:</label>
        <input type="password" id="password" name="password" />
      </p>
      <p>
        <label></label><br/>
        <input type="submit" id="submit" value="Register" />
      </p>
    </form>
  </div>
</body>
</html>
