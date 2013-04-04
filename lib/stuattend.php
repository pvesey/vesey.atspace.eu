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

if (isset ($_GET["r"])) {
  $r = trim(htmlentities($_GET['r']));
}
else{
  $r='1';
}

if ($dbAttend->getModAccessLevel($r) != 2){
  echo "You do not have access to this page";
  
} elseif ($dbAttend->getModAccessLevel($r) == 2){
    $result = $dbAttend->getLectStuAttend($q, $r);
    $dbAttend->formatXML($result, "Module", "Class");
}
$dbAttend->closedb();
?>