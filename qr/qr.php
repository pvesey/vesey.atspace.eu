<?php

include "qrlib.php";


class qr{

  private $_cssStyle = "";
  private $_InputTempFile = "";
  private $_SQLTempInsert = "";
  private $_dirName = "";
  private $_qrImageFile ="";
  private $_libDir = "";
  private $_styleDir ="";

  
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

  	chdir("..");
  	
  	$dirName = $md5;
  	$this->_dirName = getcwd(). DIRECTORY_SEPARATOR . $md5 . DIRECTORY_SEPARATOR;
  	$this->_libDir = getcwd(). DIRECTORY_SEPARATOR .  "lib" . DIRECTORY_SEPARATOR;
  	$this->_styleDir = getcwd(). DIRECTORY_SEPARATOR . "style" . DIRECTORY_SEPARATOR;
  	
   	mkdir($dirName); 	
   	
  	$QRlinkURL = 'http://localhost/vesey.atspace.eu/'.$md5.'/';
 	
    $this->_qrImageFile =$this->_dirName.$md5.'.png';
    $filename = $md5.DIRECTORY_SEPARATOR.$md5.'.png';

    $InputFile = $this->_libDir."takeattend.php";
  	$this->_InputTempFile = $this->_dirName ."index.php";

  	$SQLInsertFile = $this->_libDir."insertdata.php";
  	$this->_SQLTempInsert = $this->_dirName ."insertdata.php";

  	$CSSFile = $this->_styleDir."qrstyle.css";
  	$this->_cssStyle = $this->_dirName ."qrstyle.css";
  
  	QRcode::png($QRlinkURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

  	copy($InputFile, $this->_InputTempFile);  // copy the php/html form
  	copy($SQLInsertFile, $this->_SQLTempInsert); //php script to put data into database
  	copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)

  
  }
  

  
}
?>