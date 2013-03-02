<?php 
session_start();

  include 'db/db.php';

function returnheader($location){
  $returnheader = header("location: $location");
  return $returnheader;
}

$dbco = new db();

$dbco->condb();


if ($dbco->checklogin() != true){
  returnheader("lib/login.php");
} else {
  include 'lib/sloggedin.php';
}
$dbco->closedb();

?>

