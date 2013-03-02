<?php 
session_start();
ob_start();
  include '../db/db.php';

function returnheader($location){
  $returnheader = header("location: $location");
  return $returnheader;
}

$dbco = new db();

$dbco->condb();


if ($dbco->checklogin() != true){
  include 'slogin.php';  
  $username = $dbco->getUsername();
  $password = $dbco->getPassword();

  $dbco->login($username, $password);
  if ($dbco->checklogin() == true){
    //setcookie("userloggedin", $username, 0);
    returnheader("../index.php");
    
  }
} else {
    returnheader("../index.php");
  
}

$dbco->closedb();

?>