<?php

class db{

  protected $_dcon = "";
  
  function condb(){
    try{
     // $dbcon = new PDO('mysql:host=localhost;dbname=1293294_cmi', "1293294_cmi", "cmipass");
     $dbcon = new PDO('mysql:host=fdb5.atspace.com;dbname=1293294_cmi', "1293294_cmi", "cmipass");
      
      $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      
      $this->_dcon = $dbcon;

    
      }
    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
  }

  
  function closedb(){

    $this->_dcon = null;
    
  }

  function checklogin(){
    
    if (isset($_SESSION["SESS_ID"]) && isset($_SESSION["SESS_USERNAME"])){
      return true;
    }
    else{ 
      return false;
    }
    
  }
  
  function login($username, $password){
    
    if ($this->_dcon != ""){
      try{

        $stmt = $this->_dcon->prepare("CALL procLogin(:uname, :pass);");
        $stmt->bindParam(':uname', $username);
        $stmt->bindParam(':pass', $password);
        $stmt->execute();
        
        $row = $stmt->fetch();
        
        if ($stmt->rowCount() == 1){
          
          
             
          setcookie("userloggedin", $username, 0);
          
          $_SESSION["SESS_ID"] = $row['intUserID'];
          $_SESSION["SESS_USERNAME"] = $username;
          $_SESSION["SESS_USERFNAME"] = $row['txtFirstName'];;
          $_SESSION["SESS_USERSNAME"] = $row['txtSurname'];;
          $_SESSION["SESS_FAIL"] = "";
        }
                        
        else{
          $_SESSION["SESS_FAIL"] = "Username or Password Incorrect";
        }
        
        $stmt->closeCursor();
        
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
    
    else {
      
      echo "no connection to datbase"; 
      
    }
    
  }
  
  function logAttend($class, $username, $password){
    
    if ($this->_dcon != ""){
        
      try{
        $stmt = $this->_dcon->prepare("CALL procLogin(:uname, :pass);");
        $stmt->bindParam(':uname', $username);
        $stmt->bindParam(':pass', $password);
        $stmt->execute();
    
        $row = $stmt->fetch();
    
        if ($stmt->rowCount() == 1){
          // insert attendance record into DB here
          $user = $row['intUserID'];
          
          $stmt->closeCursor();
          
          $atnd = $this->_dcon->prepare("CALL procLogAttend(:user, :class);");
            
          $atnd->bindParam(':class', $class, PDO::PARAM_INT);
          $atnd->bindParam(':user', $user, PDO::PARAM_INT);
          $atnd->execute();
          $atnd->closeCursor();
          return 1;
        }
      
        else{
          return 2;
        }
        //$stmt->closeCursor();
    
      }
      catch (PDOException $e) {

        if ($e->getCode()==23000){
            //echo "YOU HAVE ALREADY LOGGED YOUR ATTEND";
            return 3;
        } else {
            //print "Error!: " . $e->getMessage() . "<br/>";
        }
        die();
        return 4;
      }
    }
    
    else {
      //echo "no connection to datbase";
      return 4;  
    }
    
    
    
    
  }  // end of function
  
  function getUsername(){
    $errors = array();
    if(isset($_POST["loginPanel"])){
    
      $uname = trim(htmlentities($_POST['username']));
    
      if(empty($uname)){
        $errors[] = "Please input a username";
      }
    
      if(!$errors){
    
        $username = $uname;
          
      } else {
        $errors[] = "There has been an error!";
        $username = "";
    
      }
    
    } else {
      $username = "";
    }
    return $username;
  }
  
  function getPassword(){
    $errors = array();
    if(isset($_POST["loginPanel"])){
  
      $passw = trim(htmlentities($_POST['password']));
  
      if(empty($passw)){
        $errors[] = "Please input a password";
      }
  
      if(!$errors){
  
        $password = $passw;
          
      } else {
        $errors[] = "There has been an error!";
        $password = "";
  
      }
  
    } else {
      $password = "";
    }
    return $password;
  }

  function getCourses($UserID){
    
    if ($this->_dcon != ""){
        
      try{

        $stmt = $this->_dcon->prepare("CALL procUserCourses(:uname);");
        $stmt->bindParam(':uname', $_SESSION["SESS_ID"]);
        $stmt->execute();
      
        $output = "<div class='nav' onClick='goHome()'>Home</div>";

        if ($stmt->rowCount() > 0){
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $output .= "<div class='nav' id='". $row['intModule']. "' onClick='getCourseInfo(" .$row['intModule'] .")'>" . $row['txtModuleName']. "</div>";

          }
          echo $output;            
        }
    
        else{
          echo "No Courses found for User";
        }
    
        $stmt->closeCursor();
    
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
    
    else {
        
      echo "no connection to datbase";
        
    }
    
    
  }
  
    
  function getStuOverallAttend(){
      
    if ($this->_dcon != ""){
        
      try{

        $stmt = $this->_dcon->prepare("CALL procStuOverallAttend(:uname);");
        $stmt->bindParam(':uname', $_SESSION["SESS_ID"]);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $output = "<div class='stuAttendRecord'><div class='' id='". $row['fkeyModule']. "' onClick='getCourseInfo(" .$row['fkeyModule'] .")'>"; 
              $output .=  "<div class='stuModName'>" . $row['txtModuleName'] . "</div>"; 
              $output .=  "<div class='stuModAverage'>" . $row['Average'] . "</div>";
              $output .= "</div></div>"; 
              echo $output;
          }
            
        }
    
        else{
          echo "No attendance records found for User " . $_SESSION["SESS_USERNAME"]; 
        }
        $stmt->closeCursor();
    
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
    
    else {
        
      echo "no connection to datbase";
        
    }    
      
  }
  
  
    function getLectStuAttend($studentID, $module){
      
    if ($this->_dcon != ""){

      try{
    
        $stmt = $this->_dcon->prepare("CALL procStuAttendRpt(:uname, :module);");
        $stmt->bindParam(':uname', $studentID);
        $stmt->bindParam(':module', $module);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0){
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
          return $rows;
        }
    
        else{
          echo "No Attendance found";
        }
    
        $stmt->closeCursor();
    
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
    
    else {
    
      echo "no connection to datbase";
    
    }
    
    
  }
  
  function getModAttend($module){
    
    if ($this->_dcon != ""){

      try{
    
        $stmt = $this->_dcon->prepare("CALL procStuAttendRpt(:uname, :module);");
        $stmt->bindParam(':uname', $_SESSION["SESS_ID"]);
        $stmt->bindParam(':module', $module);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0){
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
          return $rows;
        }
    
        else{
          echo "No Attendance found";
        }
    
        $stmt->closeCursor();
    
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
    
    else {
    
      echo "no connection to datbase";
    
    }
    
    
  }
  
  
  function formatXML($result, $rootElementName, $childElementName){
  
    $keys = array_keys($result[0]);
  
    header('Content-Type: text/xml');

    $xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
    $xmlData .= "<" . $rootElementName . ">";    
    for ($i = 0; $i < count($result); $i++){
      $xmlData .= "<" . $childElementName . ">";
      for ($j=0; $j < count($result[$i]); $j++){

        $xmlData .= "<". $keys[$j] . ">";
         
        if (!empty($result[$i][$keys[$j]])) {
          $xmlData .= $result[$i][$keys[$j]];
        } else {
          $xmlData .= "null";  
        }
        $xmlData .= "</". $keys[$j] . ">";
      
      }  
      $xmlData .= "</" . $childElementName . ">";   
    }
    $xmlData .= "</" . $rootElementName . ">";    
    
    echo $xmlData;
    $file = 'xml.xml';
    file_put_contents($file, $xmlData);    
    
  }
  
  
  function getModAccessLevel($module){
  
    if ($this->_dcon != ""){
  
      try{
  
        $stmt = $this->_dcon->prepare("CALL procModAccessLevel(:module, :uname);");
        $stmt->bindParam(':uname', $_SESSION["SESS_ID"]);
        $stmt->bindParam(':module', $module);
        $stmt->execute();
  
               
        if ($stmt->rowCount() == 1){
          $rows = $stmt->fetch(PDO::FETCH_NUM);
          
          $level = $rows[0];

          return $level;
        }
  
        else{
          echo "Access Level Not found";
        }
  
        $stmt->closeCursor();
  
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
  
    else {
  
      echo "no connection to datbase";
  
    }
  
  
  }
  
  
  function getOverallAttend($module){
  
    if ($this->_dcon != ""){
  
      try{
  
        $stmt = $this->_dcon->prepare("CALL procShowQuickAttend(:module);");
        $stmt->bindParam(':module', $module);
        $stmt->execute();
  
        if ($stmt->rowCount() > 0){
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //var_dump($rows);
          return $rows;
        }
  
        else{
          echo "No Attendance found";
        }
  
        $stmt->closeCursor();
  
      }
      catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
    }
  
    else {
  
      echo "no connection to datbase";
  
    }
  
  
  }
  
}  // end of class

?>