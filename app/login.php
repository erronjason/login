<?php
session_start();
session_regenerate_id(true);
$token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $token;
if(isset($_SESSION['session'])){
    header('Location: dashboard.php', true, 302);
}else { ?>

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
      var error = document.getElementById('errors');
      $.ajax({
        url: "process.php",
        dataType: 'json',
        data: "t=l&username="+username+"&password="+pass,
        success: function(json) {
          if (json[0] == 'success') {
            location.replace("dashboard.php");
          } else if (json[0] == 'badlogin') {
            error.innerHTML = '';
            error.innerHTML = 'Incorrect username or password.';
            document.getElementById("username").className="inputerror";
            document.getElementById("password").className="inputerror";
          } else {
            error.innerHTML = '';
            $.each(json, function(key, value){

              if (value !== null) {
                var errlen = value.length;
                for (var i = 0; i < errlen; i++) {
                    var errval = "<p>&#8226; "+value[i]+"</p>";
                    $(errval).appendTo("#errors");
                }
              }
              if (value !== null) {
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
  <?php require("partials/navbar.php");?>
  <div id="container">
    <div id="login">
      <div id="errors"></div>
      <div class="floatleft">
          <?php if (isset($_GET['r'])) {
            if ($_GET['r'] === "s") {
              echo'<p>
                <span id="headertext">Registration successful!</span>
              </p>';
            }
          } elseif (isset($_GET['l'])){
            if ($_GET['l'] === "s") {
              echo'<p>
                <span id="headertext">You have been logged out.</span>
              </p>';
            }
          } else {
            echo '<p>
              <span id="headertext">Please login:</span>
            </p>';
          } ?>
          <form id="form" method="post" onsubmit="return false;" action="process.php">
            <div id="floatleft">
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
          </div>
        </form>
    </div>
  </div>
</div>
</body>
</html>
<?php } ?>
