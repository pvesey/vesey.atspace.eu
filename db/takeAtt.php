<?php
include getcwd().DIRECTORY_SEPARATOR. '../db/db.php';

class takeAtt extends db{
	
	function getClassID($qrMD5){
	
		$this->condb();
	
	
		if ($this->_dcon != ""){
	
			try{
	
				$stmt = $this->_dcon->prepare("CALL procClassMD5(:qrMD5);");
				$stmt->bindParam(':qrMD5', $qrMD5);
				$stmt->execute();
	
	
				if ($stmt->rowCount() == 1){
					$rows = $stmt->fetch(PDO::FETCH_NUM);
					return $rows[0];
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
		} else {
	
			echo "no connection to datbase";
	
		}
	
		$this->closedb();
	
	}
	
	
	function logAttend($class, $username, $password){
	
		
		$this->condb();
		
		
		if ($this->_dcon != ""){
	
			try{
	
				$stmt = $this->_dcon->prepare("CALL procLogin(:uname, :pass);");
				$stmt->bindParam(':uname', $username, PDO::PARAM_STR);
				$stmt->bindParam(':pass', $password,  PDO::PARAM_STR);
				$stmt->execute();
	
				$row = $stmt->fetch();
	
				if ($stmt->rowCount() == 1){
					// insert attendance record into DB here
					
					$user = $row['intUserID'];
						
						$stmt->closeCursor();
		
						$atnd = $this->_dcon->prepare("CALL procQRAttend(:class, :user);");
		
						$atnd->bindParam(':class', $class, PDO::PARAM_INT);
						$atnd->bindParam(':user', $user, PDO::PARAM_INT);
						$atnd->execute();
						$atnd->closeCursor();
						
				}
	
				else{
					// echo "Username or Password incorrect";
				}
				//$stmt->closeCursor();
	
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}
	
		else {
	
			echo "no connection to datbase";
	
		}
	
		$this->closedb();
	
	
	}  // end of function
	
	
	
	function testPrevAttend($class, $user){

		$this->condb();
		
		
		if ($this->_dcon != ""){
	
			try{
	
				$stmt = $this->_dcon->prepare("CALL procCheckDuplicate(:class, :user;");
				$stmt->bindParam(':class', $class, PDO::PARAM_INT);
				$stmt->bindParam(':user', $user, PDO::PARAM_INT);
				$stmt->execute();
	
				$row = $stmt->fetch();
	
				if ($stmt->rowCount() != 0){

					$stmt->closeCursor();	
					return TRUE;
				}
	
				else{
					
					return FALSE;
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
	
		$this->closedb();
	
	
	}  // end of function
	

	
	function testUserClassReg($class, $user){
	
		$this->condb();
	
	
		if ($this->_dcon != ""){
	
			try{
	
				$stmt = $this->_dcon->prepare("CALL procCheckDuplicate(:class, :user;");
				$stmt->bindParam(':class', $class, PDO::PARAM_INT);
				$stmt->bindParam(':user', $user, PDO::PARAM_INT);
				$stmt->execute();
	
				$row = $stmt->fetch();
	
				if ($stmt->rowCount() != 0){
	
					$stmt->closeCursor();
					return TRUE;
				}
	
				else{
						
					return FALSE;
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
	
		$this->closedb();
	
	
	}  // end of function
		
////  Pocedure to check if username and password combination, and if the user is regisered to the correct class.	
	
	
	function checkAttendCriteria($class, $username, $password){
	
	
		$this->condb();
	
	
		if ($this->_dcon != ""){
	
			try{
	
				$stmt = $this->_dcon->prepare("CALL procLogin(:uname, :pass);");
				$stmt->bindParam(':uname', $username, PDO::PARAM_STR);
				$stmt->bindParam(':pass', $password, PDO::PARAM_STR);
				$stmt->execute();
	
				$row = $stmt->fetch();
	
				if ($stmt->rowCount() == 1){
						
					$user = $row['intUserID'];
					$stmt->closeCursor();
					
					$classreg = $this->_dcon->prepare("CALL procCheckDuplicate(:class, :user;");
					$classreg->bindParam(':class', $class, PDO::PARAM_INT);
					$classreg->bindParam(':user', $user, PDO::PARAM_INT);
					$classreg->execute();
					$row = $classreg->fetch();
					
					if ($classreg->rowCount() != 0){
					
						$classreg->closeCursor();
						return TRUE;
					} else{
					
						return FALSE;
					}
					$stmt->closeCursor();
				} else{
					return FALSE;
				}
	
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}
	
		else {
	
			echo "no connection to datbase";
	
		}
	
		$this->closedb();
	
	
	}  // end of function
	
	
	
	
	
}






?>