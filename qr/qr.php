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

  	$dirName = $md5;
  	$this->_dirName = $dirName;
  	//$tempURL = 'http://vesey.atspace.eu/CMI'.$timestamp.'/';
  	$tempURL = 'http://localhost/CMI/'.$md5.'/';
  
  	$CMITempDir = getcwd().DIRECTORY_SEPARATOR.$dirName.DIRECTORY_SEPARATOR;
  	
    $this->_qrImageFile = $CMITempDir.$md5.'.png';
    $filename = $md5.DIRECTORY_SEPARATOR.$md5.'.png';

    $InputFile = $this->_libDir."takeattend.php";
  	$this->_InputTempFile = $CMITempDir."index.php";

  	$SQLInsertFile = $this->_libDir."insertdata.php";
  	$this->_SQLTempInsert = $CMITempDir."insertdata.php";

  	$CSSFile = $this->_styleDir."qrstyle.css";
  	$this->_cssStyle = $CMITempDir."qrstyle.css";
  
  	mkdir($dirName);
  
  	QRcode::png($tempURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
 	
  	copy($InputFile, $this->_InputTempFile);  // copy the php/html form
  	copy($SQLInsertFile, $this->_SQLTempInsert); //php script to put data into database
  	copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)
  }
  
  
  
  
  
}
?>