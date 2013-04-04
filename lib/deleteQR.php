<?php
include "../qr/qr.php";

if (isset ($_GET["p"])) {
	$MD5 = trim(htmlentities($_GET['p']));
}

$qr = new qr();

$qr->distroyqr($MD5);

echo "QR Code Deleted";

?>