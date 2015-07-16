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
  <script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <script type="text/javascript">
  $(function(){
    $("#submit").click(function(){
      username=$("#username").val();
      email=$("#email").val();
      pass=$("#password").val();
      $.ajax({
        url: "process.php",
        dataType: 'json',
        data: "t=r&username="+username+"&email="+email+"&password="+pass,
        success: function(json) {
          if (json[0] == 'success') {
            console.log("Registration successful!");
            location.replace("login.php");
          } else {
            $("#error").html("")
            //for(var i=0; i < json.length; i++) {
            //  $("#error").append(json[i]+"<br>");
            //}
            $.each(json, function(key, value){
              //add class inputerror to matching ids
              console.log("error type:", key, 'Message:', value);
              document.getElementById(key).className="inputerror";
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
      iscorrect.innerHTML = '<span class="correct">&#10004;</span>';
    } else {
      iscorrect.innerHTML = '<span class="incorrect">&#10008;</span>';
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
          <input type="password" id="password" name="password" />
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
