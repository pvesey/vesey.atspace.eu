<?php

include "qrlib.php";


class qr{

  private $_cssStyle = "";
  private $_InputTempFile = "";
  private $_SQLTempInsert = "";
  private $_dirName = "";
  private $_qrImageFile ="";
  private $_libDir = "http://localhost/vesey.atspace.eu/lib/";
  private $_styleDir = "http://localhost/vesey.atspace.eu/style/";
  private $_sitePath = "http://localhost/vesey.atspace.eu/";

 
  
  function distroyqr(){

  echo "<br>Deleting Files<br>";
  
  	unlink($this->_qrImageFile);
    unlink($this->_InputTempFile);
    unlink($this->_SQLTempInsert);
    unlink($this->_cssStyle);
    rmdir($this->_dirName);
    
  }
  

  function makeQRCode($md5){
  	$errorCorrectionLevel = 'H';
  	$matrixPointSize = 10;

  	 
  	/// NEED TO LOOK AT DIRECTORYS AGAIN...
  	
  	
  	
  	
  	$dirName = $md5;
  	$this->_dirName = $this->_sitePath . $md5;

  	echo $dirName . "<br>";
  	echo $this->_dirName . "<br>";
  	 
  	
  	
  	mkdir($dirName);
  	
  	//$tempURL = 'http://vesey.atspace.eu/CMI'.$timestamp.'/';
  	$tempURL = 'http://localhost/vesey.atspace.eu/'.$md5.'/';
  
  	$CMITempDir = $this->_dirName;
  	
    $this->_qrImageFile = $CMITempDir.$md5.'.png';
    $filename = $md5.DIRECTORY_SEPARATOR.$md5.'.png';

    $InputFile = $this->_libDir."takeattend.php";
  	$this->_InputTempFile = $CMITempDir."index.php";

  	$SQLInsertFile = $this->_libDir."insertdata.php";
  	$this->_SQLTempInsert = $CMITempDir."insertdata.php";

  	$CSSFile = $this->_styleDir."qrstyle.css";
  	$this->_cssStyle = $CMITempDir."qrstyle.css";
  

  
  	QRcode::png($tempURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
 	echo $filename;
  	copy($InputFile, $this->_InputTempFile);  // copy the php/html form
  	copy($SQLInsertFile, $this->_SQLTempInsert); //php script to put data into database
  	copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)

  	echo '<img src="'. $filename . '" /><hr/>';
  
  }
  

  
}
?>