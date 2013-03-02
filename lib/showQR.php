<?php
include "../db/atadmin.php";
include "../qr/qr.php";

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

$timestamp = md5(time());

$db = new atadmin();
$qr = new qr();

// create the class on the database

$db->createClass($ModID, $classStart, $classEnd, $timestamp);


// get the PK for the class..

$classID = $db->getClassID($timestamp);

// create the QR code that will match the systems...

$qr->makeQRCode($timestamp);

$qrImageFile = $timestamp . DIRECTORY_SEPARATOR . $timestamp . ".png";

echo '<img src="'. $qrImageFile . '"/>';

//$qr->distroyqr($timestamp);


?>