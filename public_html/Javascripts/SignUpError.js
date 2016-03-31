function formValidation(){

	//tat ca deu regular expression
	//user name:
	//first name
	//middle name
	//last name
	//
	var numErrors = 0;
	if (document.getElementById("password").value != document.getElementById("password_confirmation").value){
		document.getElementById("passwordConfirmError").innerHTML = "Does not equal password";
		numErrors++;
	}
	else {
		document.getElementById("passwordConfirmError").innerHTML = "";
		
	}
	if (document.getElementById("username").value.length < 6){
		document.getElementById("usernameError").innerHTML = "username have be at least 6 characters";
		numErrors++;
	}
	else {
		document.getElementById("usernameError").innerHTML = "";
		
	}
	if (document.getElementById("password").value.length < 6){
		document.getElementById("passwordError").innerHTML = "password have be at least 6 characters";
		numErrors++;
	}
	else {
		document.getElementById("passwordError").innerHTML = "";
		
	}
	var today = new Date();
	var year = today.getFullYear();
	
	if (((year - document.getElementById("year").value) < 18)){
		document.getElementById("birthdayError").innerHTML = "You are not old enough (below 18)";
		numErrors++;
	}
	else if (isNaN(document.getElementById("year").value)){
		document.getElementById("birthdayError").innerHTML = "Year has to be a number";
		numErrors++;
	}
	else{
		document.getElementById("birthdayError").innerHTML = "";
	}
	if ((document.getElementById("email").value).indexOf('@gmail.com') < 1){
		document.getElementById("emailError").innerHTML = "Need to have @gmail.com";
		numErrors++;
	}
	else{
		document.getElementById("emailError").innerHTML = "";
	}
	if (numErrors == 0)
		return true;
	else
		return false;
}