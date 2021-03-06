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
  <title>Registration | Bravelogin</title>
  <script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <script type="text/javascript">
  $(function(){
    $("#submit").click(function(){
      username=$("#username").val();
      email=$("#email").val();
      pass=$("#password").val();
      var error = document.getElementById('errors');
      $.ajax({
        url: "process.php",
        dataType: 'json',
        data: "t=r&username="+username+"&email="+email+"&password="+pass,
        success: function(json) {
          if (json[0] == 'success') {
            console.log("Registration successful!");
            location.replace("login.php?r=s");
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
              if (document.getElementById(key) !== null){
                document.getElementById(key).className="inputerror";
              }
            });
          }
        }
      })
    })
      return false;
  })
  function matchPass() {
    var password = document.getElementById("password");
    var cpassword = document.getElementById("cpassword");
    var iscorrect = document.getElementById('iscorrect');
    if (password.value == cpassword.value) {
      iscorrect.innerHTML = '<span class="infotext"><span class="correct">&#10004;</span> Passwords match!</span>';
      return true;
    } else {
      iscorrect.innerHTML = '<span class="infotext"><span class="incorrect">&#10008;</span> Passwords do not match</span>';
      return false;
    }
  }
  </script>
</head>
<body>
  <div id="dashboard">
    <?php
    if(isset($_SESSION['session'])){
    ?>
    <a href='logout.php' id='logout'>Logout</a>
    <?php }else {?>
    <a id="login" href="login.php">login</a>
    <?php } ?>
  </div>
  <div id="container">
    <div id="register">
      <div id="errors"></div>
      <form id="form" method="post" onsubmit="return false;" action="process.php">
        <div class="floatleft">
          <p class="usernamelabel">
            <label>Username:</label>
          </p>
          <input type="text" id="username" name="username" />
          <p id="emaillabel">
            <label>Email:</label>
          </p>
          <input type="text" id="email" name="email" />
        </div>
        <div class="floatright">
          <p id="passwordlabel">
            <label>Password:</label>
          </p>
          <input type="password" id="password" name="password" onkeyup="matchPass(); return false;"/>
          <p id="cpasswordlabel">
            <label>Confirm Password:</label>
          </p>
          <input type="password" id="cpassword" name="cpassword" onkeyup="matchPass(); return false;"/>
          <span id="iscorrect"></span>
          <p>
            <input type="submit" id="submit" value="Register" />
          </p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
<?php } ?>
