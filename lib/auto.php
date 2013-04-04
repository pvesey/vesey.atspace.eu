<?php 
include getcwd().DIRECTORY_SEPARATOR.'../db/db.php';

function getClassMD5(){
  
  $loc = dirname(__FILE__);
  $loc = substr($loc, -32, 32);
  return $loc;
}
function getOutput($msg, $style){
    
    $output ="<!doctype html>";
    $output .="<html lang='en'>";
    $output .="<head>";
    $output .="<meta charset='utf-8'><title>Logging Attendance</title>" . $style;
    $output .="</head>";
    $output .="<body>";
    $output .="<div class='wrapper'>";
    $output .="<div><h1>Logging Attendance</h1></div>";
    $output .="<div><h2>" . $msg ."</h2></div>";
    $output .="</div>";    
    $output .="<div class='footer'>Count-Me-In &copy 2012 Paul Vesey</h1></div>";
    $output .="</body>";
    $output .="</html>";
    return $output;
}

function getStyle(){
    $style = "<style>";
    $style .= ".wrapper {margin-right: auto; margin-left: auto; width: 960px; height: 440px; background-color: #FFFFFF;}";
    $style .= "body {font-family: Verdana, Arial, Helvetica; background-color: #666666; margin: 0px;}";
    $style .= "h1 {font-family: Verdana, Geneva, sans-serif; font-size: 50px; font-style: italic; text-align:center; padding-top: 5px; padding-bottom: 5px; color: #6699FF;}";    
    $style .= "h2 {font-family: Verdana, Geneva, sans-serif; font-size: 24px; text-align:center; padding-top: 5px; padding-bottom: 5px; color: #003399;}";
    $style .= ".footer{margin-right: auto; margin-left: auto; width: 960px; height: 40px; text-align:center; padding-top: 5px; padding-bottom: 5px; color: #000000; background-color: #6699FF;}";
    $style .= "</style>";
    return $style;
}

$class = getClassMD5();

$dbatt = new db();

$dbatt->condb();
$u = trim(htmlentities($_GET['u']));
$p = trim(htmlentities($_GET['p']));

$flag = $dbatt->logAttend($class, $u, $p);

if ($flag == 1){
    $outmessage = "Attendance Taken";
} else if ($flag == 2){
    $outmessage = "Username/Password combination incorrect";
} else if ($flag == 3){
    $outmessage = "Your Attendance has already been logged for this class";
} else if ($flag == 4){
    $outmessage = "Database Connection Problem";
} else {
    $outmessage = "An unknown error has occured"; 
}

echo getOutput($outmessage, getStyle());
?>