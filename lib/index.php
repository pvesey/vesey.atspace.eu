<!DOCTYPE html>
<script type='text/javascript' src= '../js/indexjs.js'></script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Logging Attendance</title>
  <link href="../style/loginstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">

<div id="Top">
<div id="siteTitle">Logging Attendance</div>
</div>
<?php
session_start();
function loginfail(){
    if (isset($_SESSION["SESS_FAIL"])){
        $msg = $_SESSION["SESS_FAIL"];
        return $msg;
    } else{
        return null;
    }
}
?>


<div id="mainContent">
<h1>Please enter your username and password below</h1>
<form name="Login" action="#" method="post" onsubmit="return checkLoginForm()">
<input name="loginPanel" type="hidden" value="1">
<div class="lbl">Username</div>
<input type="text" name="username" class="requiredField"/><br>
<div class="lbl">Password</div>
<input type="password" name="password" class="requiredField"/><br>
<input name="submit" id="submit" value="Submit" class="button" type="submit"/>
</form>
<div id='loginMSG'><?php echo loginfail(); ?></div>
</div>

<div id="footer">
<div id="footLeft"></div>
<div id="footMiddle">&copy; 2013 Paul Vesey</div>
<div id="footRight"></div>
</div>
</div>

</body>
</html>

