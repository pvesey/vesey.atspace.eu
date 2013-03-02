<!DOCTYPE html>
<script type="text/javascript" src= "js/jscript.js"></script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Count-Me-In</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">

	<div id="Top">
	
	  <div id="siteTitle">
	    Count-Me-In
	  </div>
	
	  <div id="topNav">
	  	<div id="buttonContainer">
	          <ul>
	            <li id="home" onClick="goHome()">Home</li>
	            <li id="MyCourses" onClick="myCourses()">My Courses</li>
	            <li id="test2">Test</li>
	            <li id="test3">Test</li>
	            <li id="search">Search</li>
	          </ul>
	        </div>
	  </div>
	
	  <div id="topBanner">
	    <img src='img/Banner.jpg' alt='Banner'>
	  </div>
	
	  <div id="loginContainer">
	        <div id="loginStatus">
		        <?php
					if (isset($_SESSION["SESS_ID"]) ) {
		            	$welcomeMsg = "Welcome " . $_SESSION["SESS_USERFNAME"] . " ";
		            	echo $welcomeMsg;
		            	echo "<a href='logout.php'>Logout</a>";
		          	} 
		        ?>
	      	</div>
	  </div>
	</div>
	
	<div id="leftSide">
	
		<div id="mainNav">
	    	<h1>Courses</h1> 
	    		<?php $dbco->getCourses($_SESSION["SESS_ID"]) ?>
	  	</div>
	</div>

	
	<div id="mainContent">
	    <h1>Main Content Here</h1>
	</div>
	
	<div id="footer">
	
		<div id="footLeft"></div>
		<div id="footMiddle">&copy; 2013 Paul Vesey</div>
		<div id="footRight"></div>
	
	</div>

</div>
	
</body>

</html>