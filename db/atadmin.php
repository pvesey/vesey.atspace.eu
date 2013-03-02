<?php

include 'db/db.php';


class atadmin extends db{
	
	function createClass($ModID, $classStart, $classEnd, $qrMD5){
		
		$this->condb();
		
		if ($this->_dcon != ""){
				
			try{
		
				$stmt = $this->_dcon->prepare("CALL procCreateClass(:modid, :cstart, :cend, :qrMD5);");
				$stmt->bindParam(':modid', $ModID);
				$stmt->bindParam(':cstart', $classStart);
				$stmt->bindParam(':cend', $classEnd);
				$stmt->bindParam(':qrMD5', $qrMD5);
				$stmt->execute();
			
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
	
	
	
	
	
	
	
}  // end of class


?>