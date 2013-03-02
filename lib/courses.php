<?php
session_start();

include "../db/db.php";

$dbAttend = new db();

$dbAttend->condb();

if (isset ($_GET["q"])) {
  $q = trim(htmlentities($_GET['q']));
}
else{
  $q='1';
}

if ($dbAttend->getModAccessLevel($q) == 1){
  
  $result = $dbAttend->getModAttend($q);

  $dbAttend->formatXML($result, "Module", "Class");
  
} elseif ($dbAttend->getModAccessLevel($q) == 2){
  
  $result = $dbAttend->getOverallAttend($q);
  
  $dbAttend->formatXML($result, "Overall", "Class");
  
  
}


$dbAttend->closedb();


?>