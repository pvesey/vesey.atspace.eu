console.log("Running up JavaScript");
window.onload = initAll;
var ajaxMyCourse = false;
var ajaxMyAttend = false;
var ajaxShowQR = false;
var ajaxShowStudentAttend = false;
var ajaxDestroyQR = false;
var dataArray = new Array();
var url = 'lib/courses.php';
var MyCourseurl = 'mycourses.php';

function initAll() {

	if (window.XMLHttpRequest) {
		ajaxMyAttend = new XMLHttpRequest();
		ajaxShowQR = new  XMLHttpRequest();
                ajaxShowStudentAttend = new XMLHttpRequest();
                ajaxDestroyQR = new XMLHttpRequest();
	}
	else {
		if (window.ActiveXObject) {
			try {
				ajaxMyAttend = new ActiveXObject("Microsoft.XMLHTTP");
                                ajaxShowQR = new ActiveXObject("Microsoft.XMLHTTP");
                                ajaxShowStudentAttend = new ActiveXObject("Microsoft.XMLHTTP");
                                ajaxDestroyQR = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { 
                            console.log("Problem with Internet Explorer");
                    
                        }
		}
	}

	if (ajaxMyAttend) {
		ajaxMyAttend.onreadystatechange = showMyAttend;
	}
	
	if (ajaxShowQR) {
		ajaxShowQR.onreadystatechange = showQRCode;
	}
	
	if (ajaxShowStudentAttend) {
		ajaxShowStudentAttend.onreadystatechange = showStudentAttend;
	}	
        if (ajaxDestroyQR) {
		ajaxDestroyQR.onreadystatechange = showDeleteQRCode;
	}
	
	
	else {
		alert("Sorry, but I couldn't create an XMLHttpRequest for XML");
	}

}

function setLiveCourse(x){
    this.liveCourse = x;
}

function getLiveCourse(){
    return this.liveCourse;    
}


function getIndStudentAttend(obj){

	currentCourse = obj;
	ajaxShowStudentAttend.open("GET","lib/stuattend.php?q="+ obj + "&r=" + this.getLiveCourse(),true);
	ajaxShowStudentAttend.send();
	
}


function getCourseInfo(obj){
	
        setLiveCourse(obj);
	currentCourse = obj;
	ajaxMyAttend.open("GET","lib/courses.php?q="+ obj,true);
	ajaxMyAttend.send();
	
}

function destroyQR(){
        var QRDelete = "lib/deleteQR.php?p=" + QR;
	ajaxDestroyQR.open("GET",QRDelete ,true);
	ajaxDestroyQR.send();
}




function showStudentAttend() {
	document.getElementById("mainContent").innerHTML = "<img class='ajaxLoader' src='img/icon/loaderB64.gif'>";
	var outXML = "";
	var outHTML = "";
        if (ajaxShowStudentAttend.readyState == 4) {
		if (ajaxShowStudentAttend.status == 200) {
			outXML = ajaxShowStudentAttend.responseXML;
			if (!outXML){
				console.log("Nothing Returned in XML");
			}
			
		}
		else {
			outHTML = "There was a problem with the request " + ajaxShowStudentAttend.status;
		}
		
		if (outXML.documentElement.nodeName == "Module"){
                                        outHTML = tutorAdminButtons();
					outHTML += formatStuAttend(outXML);
			
		}else if (outXML.documentElement.nodeName == "Overall") {

					outHTML = formatTutorAttend(outXML);
		}
		
				
		document.getElementById("mainContent").innerHTML = outHTML;
		
	}
}



function showMyAttend() {
	document.getElementById("mainContent").innerHTML = "<img class='ajaxLoader' src='img/icon/loaderB64.gif'>";
	var outXML = "";
	var outHTML = "";
	if (ajaxMyAttend.readyState == 4) {
		if (ajaxMyAttend.status == 200) {
			outXML = ajaxMyAttend.responseXML;
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
		}
		
				
		document.getElementById("mainContent").innerHTML = outHTML;
		
	}
}



function formatStuAttend(xmlIn){


	var xmlDoc = xmlIn.getElementsByTagName("Class");
	
	var numnodes = xmlDoc.length;
	
	var classStart =  xmlIn.getElementsByTagName("dateClassStart");
	var classAttend = xmlIn.getElementsByTagName("bAttend");
	var classReason = xmlIn.getElementsByTagName("txtReason");



	var output ="";
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

	var xmlDoc = xmlIn.getElementsByTagName("Class");
	
	var numnodes = xmlDoc.length;
	
	var txtUsername =  xmlIn.getElementsByTagName("txtUsername");
	var txtFirstname = xmlIn.getElementsByTagName("txtFirstname"); 
        var txtSurname =xmlIn.getElementsByTagName("txtSurname");
	var dblAverage = xmlIn.getElementsByTagName("Average");
	var userID = xmlIn.getElementsByTagName("fkeyUserID");

	var output = tutorAdminButtons();
	
	output += "<div><div class='classAttend'>";
	output +=  "<div class='TlectRptUsername'>Username</div>";
	output +=  "<div class='TlectRptName'>Student</div>";
	output +=  "<div class='TlectRptAverage'>Average<br></div></div>";	
	
	for (var i = 0 ; i < numnodes ; i ++){
                output += "<div id='"+ userID[i].textContent + "' onClick='getIndStudentAttend("+ userID[i].textContent +")'";
                output += "onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>";
                output +=  "<div class='lectRptUsername'>";
			output +=  txtUsername[i].textContent;
		output +=  "</div>";
		output +=  "<div class='lectRptName'>";
			output +=  txtFirstname[i].textContent;
			output +=  " ";
			output +=  txtSurname[i].textContent;
		output +=  "</div>";		
		output +=  "<div class='lectRptAverage'>";
			output +=  dblAverage[i].textContent;
		output +=  "</div>";
                output +=  "</div>";
	}
	output += "</div>";

	return output;
}

function goHome(){
	window.location.href = 'index.php';
}

function tutorAdminButtons(){
	
	var courseID = currentCourse;
	
	var output ="";
	output += "<h1>Class Administration Area</h1>";
	
	output += "<div class='newQRButton' onClick='createQRCode("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>Take Attend Now</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>Redisplay Prev</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>View Averages</div>";
	output += "<div class='newQRButton' onClick='createQRCode("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>Better Version</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>CREATE NEW CODE</div>";
	output += "<div class='newQRButton' onClick='newQR("+ courseID + ") 'onMouseOver=this.style.backgroundColor='#A60000';this.style.cursor='pointer' onMouseOut=this.style.backgroundColor='#FFFFFF'>CREATE NEW CODE</div>";
	
	
	return output;
}

function createQRCode(courseID){

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

        var classStart = startHour;
	var classFinish = endHour;

        
	var outHTML = "<h1>Content Cleared</h1>";
	
	document.getElementById("mainContent").innerHTML = outHTML;
	
	var QRrun = "lib/showQR.php?p=" + currentCourse +  "&q=" + classStart + "&r=" + classFinish;

	ajaxShowQR.open("GET",QRrun,true);
	ajaxShowQR.send();

}


function showQRCode() {
	document.getElementById("mainContent").innerHTML = "<img class='ajaxLoader' src='img/icon/loaderB64.gif'>";
	var outXML = "";
	var outHTML = tutorAdminButtons();
	if (ajaxShowQR.readyState == 4) {
		if (ajaxShowQR.status == 200) {
                        outXML = ajaxShowQR.responseText;
			if (!outXML){
				console.log("Nothing Returned in TXT");
			}
			
		}
		else {
			outHTML += "There was a problem with the request " + ajaxShowQR.status;
		}
		
		outHTML += outXML;
				
		document.getElementById("mainContent").innerHTML = outHTML;
		setQRName();
               var QRListen = document.getElementById("QRName");
               
               if (QRListen.addEventListener){
                    QRListen.addEventListener('mouseover', hoverStyle, true);
                    QRListen.addEventListener('mouseout', normalStyle, true);                
                    QRListen.addEventListener('click', destroyQR, false);                 
               } else if (QRListen.attachEvent){
                    QRListen.attachEvent("onmouseover", hoverStyle);
                    QRListen.attachEvent("onmouseout", normalStyle);                    
                    QRListen.attachEvent("onclick", destroyQR);  
               }
                              timer();
	}
}

function showDeleteQRCode() {
	var outXML = "";
	var outHTML = tutorAdminButtons();
	if (ajaxDestroyQR.readyState == 4) {
		if (ajaxDestroyQR.status == 200) {
                        outXML = ajaxDestroyQR.responseText;
			if (!outXML){
				console.log("Nothing Returned in TXT");
			}
		}
		else {
			outHTML += "There was a problem with the request " + ajaxDestroyQR.status;
		}
		outHTML += outXML;
		document.getElementById("mainContent").innerHTML = outHTML;

	}

}

function setQRName(){
    QR = document.getElementById("QRName").innerHTML;
}

function hoverStyle(){
        var doc = document.getElementById("QRName");
        doc.style.backgroundColor = '#A60000';
}

function normalStyle(){
        var doc = document.getElementById("QRName");
        doc.style.backgroundColor = '#6699FF';

}

function timer(){
    
    var counter = 1000;
    console.log("IN TIMER");
    //setInterval(function(){alert("Hello")},counter);
    timercount = 15;
    t = setInterval(displaytimer,counter);
 
}

function displaytimer(){
    timercount--;    
    if (timercount<=0 || (document.getElementById("QRName")== null)){
        console.log("AutoDelete");
        clearInterval(t);
        destroyQR();
    } else if (document.getElementById("QRName")== null){
        clearInterval(t);
    } else {
    
        var min = Math.floor(timercount/60);
        var seconds = timercount%60;
        if (seconds < 10){seconds = "0" + seconds.toString();}
        var output = min + ":" + seconds;
        var doc = document.getElementById("QRName").innerHTML = output;
    }
}