<?php
include "../db/atadmin.php";
include "../qr/qr.php";

function createHTML($location){
    // Simple function to create a HTML file for full code display
    
   $contents =   "<!doctype html>";
   $contents .=  "<html>";
   $contents .=  "	<head>";
   $contents .=  "		<title>QR Attend</title>";
   $contents .=  "		<meta charset='utf-8' />";
   $contents .=  "		<link rel='stylesheet' href='qrstyle.css' />";		
   $contents .=  "	</head>";
   $contents .=  "	<body><div class='mainFQR'>";    
   $contents .=  "          <h1>Scan Code below:</h1>";
   $contents .=  "          <img src='". $location.".png" . "'/>";
   $contents .=  "	</div></body>";
   $contents .=  "</html>";
    
   $file = $location . DIRECTORY_SEPARATOR . $location . ".html";
 
   file_put_contents($file, $contents);	
   return $file;
}



if (isset ($_GET["p"])) {
	$ModID = trim(htmlentities($_GET['p']));
}

if (isset ($_GET["q"])) {
	$classStart = trim(htmlentities($_GET['q']));
}

if (isset ($_GET["r"])) {
	$classEnd = trim(htmlentities($_GET['r']));
}

//$today = date("Y-m-d H:i:s");

$today = date("Y-m-d");

$classStart = $today . " " . $classStart . ":00:00";
$classEnd = $today . " " . $classEnd . ":00:00";

$timestamp = trim(md5(time()));

$db = new atadmin();
$qr = new qr();

// create the class on the database

$db->createClass($ModID, $classStart, $classEnd, $timestamp);


// get the PK for the class..

$classID = $db->getClassID($timestamp);

// create the QR code that will match the systems...

$qr->makeQRCode($timestamp);

$qrImageFile = $timestamp . DIRECTORY_SEPARATOR . $timestamp . ".png";

$qrhtml = createHTML($timestamp);

$output = "<div class='fullScreenQR'><a href=" . $qrhtml . " target = _blank>Show Full Screen</a></div>";
$output .=  "<div id='QRName' class='QRName'>$timestamp</div>";
$output .=  "<div class='QRimage'><img src='". $qrImageFile . "'/></div>";

echo $output;

?>