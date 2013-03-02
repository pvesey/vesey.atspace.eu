<?php 

include 'db/db.php';
include 'qr/qr.php';

$dbco = new db();

$dbco->condb();


//THIS IS USED TO SIMULATE SOMEONE LOGGED IN
$dbco->login("bob", "pass");
//*******************************8

// check login..  if no login then have to present the login page.

if ($dbco->checklogin() != true){
  echo "<div id='main'> Not logged in </div>";
  $dbco->login("KX0000036", "pass");
  echo "<br>";
  //  echo $_SESSION["SESS_ID"];
  echo "<br>";  
  }


else {
  

  
  echo "<div id='main'>You are logged in </div>";
  
}

//echo "<br>Taking Attend";
//$dbco->logAttend(1, 1, 1, 'bob', 'pass');
//echo "<br>Taking Attend";


$dbco->closedb();


$qrcode = new qr();

$qrcode->mkcode();


echo "<br>end of script";



?>