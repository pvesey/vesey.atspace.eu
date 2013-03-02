<?php 
include getcwd().DIRECTORY_SEPARATOR.'../db/db.php';
include dirname(__FILE__).DIRECTORY_SEPARATOR.'insertdata.php';

function getClassMD5(){
	
	$loc = dirname(__FILE__);
	$loc = substr($loc, -33, 32);
	echo $loc . "<br>";
	return $loc;
}


$class = 288;

$dbatt = new db();

$dbatt->condb();
// testing on user 146   KX0000145 pass
// need to build into a transaction to avoid trying to login twice..  SQL Trans for this
// Class ID has to come from QR code... ie directory structure.  know that it is 32 char .. so may 
// be able to use that.

echo __FILE__ . "<br>";
echo getClassMD5();





$username = $dbatt->getUsername();
$password = $dbatt->getPassword();

$dbatt->logAttend($class, $username, $password)


?>


<!DOCTYPE html>
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



<div id="mainContent">
<h1>Please enter your username and password below</h1>
<form action="#" method="post">
<input name="loginPanel" type="hidden" value="1">
<div class="lbl">Username</div>
<input type="text" name="username" class="requiredField"/><br>
<div class="lbl">Password</div>
<input type="password" name="password" class="requiredField"/><br>
<input name="submit" id="submit" value="Submit" class="button" type="submit"/>
</form>
</div>

<div id="footer">
<div id="footLeft"></div>
<div id="footMiddle">&copy; 2013 Paul Vesey</div>
<div id="footRight"></div>
</div>
</div>

</body>
</html>

