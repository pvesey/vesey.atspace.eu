function checkLoginForm(){
    if (Login.password.value == "" && Login.username.value == ""){
        document.getElementById("loginMSG").innerHTML="Please enter a Username and Password";
        return false;    
    } else if (Login.password.value == ""){
        document.getElementById("loginMSG").innerHTML="Please enter a Password";
        return false;    
    } else if (Login.username.value == ""){
        document.getElementById("loginMSG").innerHTML="Please enter a Username";
        return false;
    }
   return true;
}