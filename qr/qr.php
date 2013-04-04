<?php

include "qrlib.php";


class qr{

  private $_cssStyle = "";
  private $_InputTempFile = "";
  private $_dirName = "";
  private $_qrImageFile ="";
  private $_libDir = "";
  private $_qrhtml ="";
  private $_styleDir ="";
  
  
  function distroyqr($MD5){


    $qrImageFile = ".." . DIRECTORY_SEPARATOR . $MD5 . DIRECTORY_SEPARATOR . $MD5 .".html";
    $InputTempFile = ".." . DIRECTORY_SEPARATOR . $MD5 . DIRECTORY_SEPARATOR . $MD5 .".png";
    $cssStyle = ".." . DIRECTORY_SEPARATOR . $MD5 . DIRECTORY_SEPARATOR . "auto.php";
    $AndroidTempInsert = ".." . DIRECTORY_SEPARATOR . $MD5 . DIRECTORY_SEPARATOR . "index.php";
    $qrhtml = ".." . DIRECTORY_SEPARATOR . $MD5 . DIRECTORY_SEPARATOR . "qrstyle.css";
    $dirName = ".." . DIRECTORY_SEPARATOR . $MD5;
      
      
    unlink($qrImageFile);
    unlink($InputTempFile);
    unlink($cssStyle);
    unlink($AndroidTempInsert);
    unlink($qrhtml);
    rmdir($dirName);
    echo "<br>Deleted Files<br>";
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
     
    $QRlinkURL = 'http://vesey.atspace.eu/'.$md5.'/';
   
    $this->_qrImageFile =$this->_dirName.$md5.'.png';
    $this->_qrhtml =$this->_dirName.$md5.'.html';
    $filename = $md5.DIRECTORY_SEPARATOR.$md5.'.png';

    $InputFile = $this->_libDir."takeattend.php";
    $this->_InputTempFile = $this->_dirName ."index.php";

    $AndroidInsertFile = $this->_libDir."auto.php";
    $this->_AndroidTempInsert = $this->_dirName ."auto.php";
    
    $CSSFile = $this->_styleDir."qrstyle.css";
    $this->_cssStyle = $this->_dirName ."qrstyle.css";
  
    QRcode::png($QRlinkURL, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    copy($InputFile, $this->_InputTempFile);  // copy the php/html form
    copy($AndroidInsertFile, $this->_AndroidTempInsert); //php script to put data into database via Android APP
    copy($CSSFile, $this->_cssStyle);  //CSS style file.  (MAY BE A WORKAROUND HERE)

  }
  

  
}
?>