console.log("Running up JavaScript");
window.onload = initAll;
var ajaxMyCourse = false;
var ajaxMyAttend = false;
var ajaxShowQR = false;
var dataArray = new Array();
var url = 'lib/courses.php';
var MyCourseurl = 'mycourses.php';
var currentCourse = 0;



function initAll() {
	console.log("initAll");
	
	if (window.XMLHttpRequest) {
		//xhr = new XMLHttpRequest();
		ajaxMyAttend = new XMLHttpRequest();
		ajaxShowQR = new  XMLHttpRequest();
	}
	else {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { }
		}
	}

	if (ajaxMyAttend) {
		ajaxMyAttend.onreadystatechange = showMyAttend;
	}
	
	if (ajaxShowQR) {
		ajaxShowQR.onreadystatechange = showQRCode;
	}
	
	
	
	
	
	else {
		alert("Sorry, but I couldn't create an XMLHttpRequest for XML");
	}

}


function getCourseInfo(obj){
	
	console.log(obj);
	currentCourse = obj;
	//objText = obj.innerHTML;
	ajaxMyAttend.open("GET","lib/courses.php?q="+ obj,true);
	ajaxMyAttend.send();
	
}

//function runClicked(obj) {

//	objText = obj.innerHTML;
//	xmlCourse.open("GET","courses.php?q="+ objText,true);
//	xmlCourse.send();

//}

//function courseClicked(obj) {

//	objText = obj.innerHTML;
//	console.log(obj.innerHTML);
//}




function showMyAttend() {
	document.getElementById("mainContent").innerHTML = "<img class='ajaxLoader' src='img/icon/loaderB64.gif'>";
	var outXML = "";
	var outHTML = "";
	if (ajaxMyAttend.readyState == 4) {
		if (ajaxMyAttend.status == 200) {
			outXML = ajaxMyAttend.responseXML;
			console.log("XML BACK");
			if (!outXML){
				console.log("Nothing Returned in XML");
			}
			
		}
		else {
			outHTML = "There was a problem with the request " + ajaxMyAttend.status;
		}
		
		if (outXML.documentElement.nodeName == "Module"){

					outHTML = formatStuAttend(outXML);
			
		}else if (outXML.documentElement.nodeName == "Overall") {

					outHTML = formatTutorAttend(outXML);
		};
		
				
		document.getElementById("mainContent").innerHTML = outHTML;
		
	}
}



function formatStuAttend(xmlIn){


	xmlDoc = xmlIn.getElementsByTagName("Class");
	
	numnodes = xmlDoc.length;
	
	classStart =  xmlIn.getElementsByTagName("dateClassStart");
	classAttend = xmlIn.getElementsByTagName("bAttend");
	classReason = xmlIn.getElementsByTagName("txtReason");



	output ="";
	output += "<div class='classAttend'>";
	output +=  "<div class='classDate'>Class Date & Time</div>";
	output +=  "<div class='classAttended'>Attendance</div>";
	output +=  "<div class='classReason'>Reason<br></div>";
	
	
	for (var i = 0 ; i < numnodes ; i ++){


		output +=  "<div class='classDate'>";
			output +=  classStart[i].textContent;
		output +=  "</div>";
		
		output +=  "<div class='classAttended'>";
			output +=  classAttend[i].textContent;
		output +=  "</div>";

		output +=  "<div class='classReason'>";
			output +=  classReason[i].textContent;
		output +=  "<br></div>";

	}
	output += "</div>";
	return output;
}



function formatTutorAttend(xmlIn){

	xmlDoc = xmlIn.getElementsByTagName("Class");
	
	numnodes = xmlDoc.length;
	
	classStart =  xmlIn.getElementsByTagName("dateClassStart");
	classAttend = xmlIn.getElementsByTagName("bAttend");
	classUserID = xmlIn.getElementsByTagName("fkeyUserID");

	output = tutorAdminButtons();
	
	output += "<div class='classAttend'>";
	output +=  "<div class='classDate'>Class Date & Time</div>";
	output +=  "<div class='classAttended'>User ID</div>";
	output +=  "<div class='classReason'>Attendance<br></div>";
	
	
	
	
	for (var i = 0 ; i < numnodes ; i ++){


		output +=  "<div class='classDate'>";
			output +=  classStart[i].textContent;
		output +=  "</div>";
		output +=  "<div class='classUserID'>";
			output +=  classUserID[i].textContent;
		output +=  "</div>";		
		output +=  "<div class='classAttended'>";
			output +=  classAttend[i].textContent;
		output +=  "</div>";

	}
	output += "</div>";
	return output;
}


function newQR(id){
	
	console.log("newQR Clicked");
	console.log(id);
	window.location="testindex.php";
		
	//document.getElementById("mainContent").innerHTML = testindex.php;
	
}



function goHome(){
	window.location.href = 'index.php';
}

function tutorAdminButtons(){
	
	courseID = currentCourse;
	
	output ="";
	output += "<h1>Class Administration Area</h1>";
	
	output += "<div class='newQRButton' onClick='createQRCode("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>Take Attend Now</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>Redisplay Prev</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>View Averages</div>";
	output += "<div class='newQRButton' onClick='createQRCode("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>Better Version</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>CREATE NEW CODE</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000' onMouseOut=this.style.backgroundColor='#FFFFFF'>CREATE NEW CODE</div>";
	
	
	return output;
}

function createQRCode(courseID){
	
	console.log(courseID);
	
	var date = new Date();

	var month = String(date.getMonth() +1);
	if (month.length == 1){
		month = '0' + month;
	}
	
	var day = String(date.getDate());
	if (day.length == 1){
		day = '0' + day;
	}
	
	var startHour = String(date.getHours());
	var endHour = String(date.getHours() + 1);
	
	var classStart = '"' + date.getFullYear() + "-" + month + "-"+ day + " "+ startHour + ':00:00"';
	var classFinish = '"' + date.getFullYear() + "-" + month + "-"+ day + " "+ endHour + ':00:00"';
	
	outHTML = "<h1>Content Cleared</h1>";
	
	document.getElementById("mainContent").innerHTML = outHTML;
	
	var QRrun = "lib/showQR.php?p=" + currentCourse +  "&q=" + classStart + "&r=" + classFinish;
	
	console.log(QRrun);
//	currentCourse = obj;
	//objText = obj.innerHTML;
	ajaxShowQR.open("GET",QRrun,true);
	ajaxShowQR.send();
	
	
	
	
}


function showQRCode() {
	document.getElementById("mainContent").innerHTML = "<img class='ajaxLoader' src='img/icon/loaderB64.gif'>";
	var outXML = "";
	var outHTML = "";
	if (ajaxShowQR.readyState == 4) {
		if (ajaxShowQR.status == 200) {
			outXML = ajaxShowQR.responseText;
			console.log("TEXT BACK");
			if (!outXML){
				console.log("Nothing Returned in TXT");
			}
			
		}
		else {
			outHTML = "There was a problem with the request " + ajaxShowQR.status;
		}
		
		outHTML = outXML;
				
		document.getElementById("mainContent").innerHTML = outHTML;
		
	}
}







console.log(".. END JAVASCRIPT LOAD");
