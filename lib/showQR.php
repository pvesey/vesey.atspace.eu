<?php

include "../db/atadmin.php";
include "../qr/qr.php";

if (isset ($_GET["q"])) {
	$ModID = trim(htmlentities($_GET['q']));
}

if (isset ($_GET["r"])) {
	$classStart = trim(htmlentities($_GET['r']));
}

if (isset ($_GET["s"])) {
	$classEnd = trim(htmlentities($_GET['s']));
}


$timestamp = md5(time());

$db = new atadmin();
$qr = new qr();

// create the class on the database
$db->createClass($ModID, $classStart, $classEnd, $timestamp);


// get the PK for the class..

$classID = $db->getClassID($timestamp);

// create the QR code that will match the systems...

$qr->makeQRCode($timestamp);

//$qr->distroyqr($timestamp);















?>