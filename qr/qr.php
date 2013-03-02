<?php

include "qrlib.php";





class qr{

  private $_cssStyle = "";
  private $_InputTempFile = "";
  private $_SQLTempInsert = "";
  private $_dirName = "";
  private $_qrImageFile ="";
  
 
  function mkcode(){
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 10;
    $timestamp = md5(time());
    $dirName = 'CMI'.$timestamp;
    $this->_dirName = $dirName;
    $tempURL = 'http://vesey.atspace.eu/CMI'.$timestamp.'/';
  
  // Need to modify this as part of a configuration file.
  
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'qr/temp/';
    
    echo "<br>PNG TEMP DIR ". $PNG_TEMP_DIR . "<br>";
    echo "<br>PNG WEB DIR ". $PNG_WEB_DIR . "<br>";
  
    $CMITempDir = getcwd().DIRECTORY_SEPARATOR.$dirName.DIRECTORY_SEPARATOR;
    $filename = $PNG_TEMP_DIR.'CMI'.$timestamp.'.png';
  
    echo "<br>CMITempDIR ". $CMITempDir . "<br>";
    echo "<br>Filename ". $filename . "<br>";
    
    $InputFile = getcwd().DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."takeattend.php";
    $this->_InputTempFile = $CMITempDir."index.php";
  
    $SQLInsertFile = getcwd().DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."insertdata.php";
    $this->_SQLTempInsert = $CMITempDir."insertdata.php";
  
  
    $CSSFile = getcwd().DIRECTORY_SEPARATOR."style".DIRECTORY_SEPARATOR."qrstyle.css";
    $this->_cssStyle = $CMITempDir."qrstyle.css";
  
  
    echo "<h1>Count-Me-In (Alpha)</h1><hr/>";
  
    //set it to writable location, a place for temp generated PNG files
  
    //html PNG location prefix
  
  //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
      mkdir($PNG_TEMP_DIR);
  
  // md5 hash tag of the unix time to create a name and directory
  
  //processing form input
  //remember to sanitize user input in real-life solution !!!
  
  
    echo "<h2>".$timestamp."</h2>";
    echo "<h2>".$dirName."</h2>";
    echo "<h2>".getcwd() ."</h2>";
    
    
    echo "<br>";
  
  
    mkdir($dirName);  
    
    QRcode::png($tempURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
  
  //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';
  
    copy($InputFile, $this->_InputTempFile);  // copy the php/html form
    copy($SQLInsertFile, $this->_SQLTempInsert); //php script to put data into database
    copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)
  
  
  }
  
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
  	
  	$InputFile = getcwd().DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."takeattend.php";
  	$this->_InputTempFile = $CMITempDir."index.php";
  
  	$SQLInsertFile = getcwd().DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."insertdata.php";
  	$this->_SQLTempInsert = $CMITempDir."insertdata.php";
  
  	$CSSFile = getcwd().DIRECTORY_SEPARATOR."style".DIRECTORY_SEPARATOR."qrstyle.css";
  	$this->_cssStyle = $CMITempDir."qrstyle.css";
  
  	mkdir($dirName);
  
  	QRcode::png($tempURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
 	
  	copy($InputFile, $this->_InputTempFile);  // copy the php/html form
  	copy($SQLInsertFile, $this->_SQLTempInsert); //php script to put data into database
  	copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)
  }
  
  
  
  
  
}
?>