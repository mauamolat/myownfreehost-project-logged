function ismaxlength(obj) {
    var mlength = obj.getAttribute ? parseInt(obj.getAttribute("maxlength")) : ""
    if (obj.getAttribute && obj.value.length > mlength)
        obj.value = obj.value.substring(0, mlength)
}

function checkPwdLength(validate=true){

    var password = document.getElementById("password").value;

    if(password.length >= 6 && password.length <= 25){
        document.getElementById("password_warn").style.display = "none";
        document.getElementById("input_password").className = 'form-line focused';
        if(validate == true){
        	validateForm();
        }
        return true;
    }else if(password.length > 25){
    	document.getElementById("password_warn").innerHTML = "Password is too long! 25 characthers maximum.";
    	document.getElementById("password_warn").style.display = "block";
        document.getElementById("input_password").className = 'form-line focused error';
        if(validate == true){
        	validateForm();
        }
        return false;
    }else{
    	document.getElementById("password_warn").innerHTML = "Password is too short! 6 characthers minimum.";
        document.getElementById("password_warn").style.display = "block";
        document.getElementById("input_password").className = 'form-line focused error';
        if(validate == true){
        	validateForm();
        }
        return false;
    }

}

function checkDomainLength(validate=true){

	var domain = document.getElementById("username").value;

	if(domain.length >= 3 && domain.length <= 16){
        document.getElementById("username_warn").style.display = "none";
        document.getElementById("input_username").className = 'form-line focused';
        if(validate == true){
        	validateForm();
        }
        return true;
    }else if(domain.length > 16){
    	document.getElementById("username_warn").innerHTML = "Choosen subdomain is too long! 25 characthers maximum.";
    	document.getElementById("username_warn").style.display = "block";
        document.getElementById("input_username").className = 'form-line focused error';
        if(validate == true){
        	validateForm();
        }
        return false;
    }else{
    	document.getElementById("username_warn").innerHTML = "Choosen subdomain is too short! 3 characthers minimum.";
        document.getElementById("username_warn").style.display = "block";
        document.getElementById("input_username").className = 'form-line focused error';
        if(validate == true){
        	validateForm();
        }
        return false;
    }

}

function checkEmailValidity(validate=true) {

	var email = document.getElementById("email").value;

  	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  	
  	if(re.test(email)){
  		document.getElementById("email_warn").style.display = "none";
        document.getElementById("input_email").className = 'form-line focused';
        if(validate == true){
        	validateForm();
        }
        return true;
  	}else{
  		document.getElementById("email_warn").innerHTML = "Email is invalid! Please enter a valid email.";
        document.getElementById("email_warn").style.display = "block";
        document.getElementById("input_email").className = 'form-line focused error';
        if(validate == true){
        	validateForm();
        }
  		return false;
  	}

}

function checkDomainAvailability(){
	// Initialize QUID:Open-API Project
	// Call -> QUID:API->availability
	// Response -> Catch
	// if Response == available : {tell:Available} ? {tell:Taken}
}

function validateForm(){

	console.log("Validation called");

	var captcha = document.getElementById("captcha").value;
	var agreedToTerms = document.getElementById("terms").checked;
	
	if(checkDomainLength(false) && checkEmailValidity(false) && checkPwdLength(false) && captcha != '' && agreedToTerms){
		document.getElementById('signupBtn').removeAttribute('disabled');
	}

}