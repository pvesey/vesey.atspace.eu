<?php
		$ttime = time();
		echo $ttime. "<br>";
		

	for ($i=0;$i<300; $i++){
		
		$ttime -= 1;
		
		$result = md5($ttime);
		echo $result . "<br>";

	}


?>

