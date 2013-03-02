<?php
session_start();
//redirect function
function returnheader($location){
  $returnheader = header("location: $location");
  return $returnheader;
}

setcookie("userloggedin", "");
session_destroy();

//redirect
returnheader("index.php");

?>