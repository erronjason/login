<?php
session_start();
session_regenerate_id(true);
$token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $token;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login | Bravelogin</title>
  <script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
            location.replace("dashboard.php");
          } else {
            //for(var i=0; i < json.length; i++) {
            //  $("#error").append(json[i]+"<br>");
            //}
            $.each(json, function(key, value){
              //add class inputerror to matching ids
              console.log("error type:", key, 'Message:', value);
              if (!value == null){
                document.getElementById(key).className="inputerror";
              }
            });
          }
        }
      })
    })
      return false;
  })
  </script>
</head>


<body>
  <?php require("partials/navbar.php"); ?>
  <div id="login">
    <div class="errors" id="error"></div>
    <p>
      <span id="headertext">Please login:</span>
    </p>
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
