function ismaxlength(obj) {
    var mlength = obj.getAttribute ? parseInt(obj.getAttribute("maxlength")) : ""
    if (obj.getAttribute && obj.value.length > mlength)
        obj.value = obj.value.substring(0, mlength)
}

function checkDomain(){

	var domain = document.getElementById("input_username").value;
	var keep_domain = document.getElementById("keep_domain").innerHTML;
	var reCallReturn = null;

	// Check domain length
    if(domain.length >= 3 && domain.length <= 16){
	    /* Do nothing */
	}else if(domain.length > 16){
		document.getElementById("warn_username").innerHTML = "Choosen subdomain is too long! 16 characthers maximum.";
		document.getElementById("warn_username").className = 'col-pink';
		document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
	    return false;
	}else{
		document.getElementById("warn_username").innerHTML = "Choosen subdomain is too short! 3 characthers minimum.";
		document.getElementById("warn_username").className = 'col-pink';
	    document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
	    return false;
	}

	// Append reseller domain
	domain = domain+".planetcloudhosting.cf";

	// Check domain validity
    if(/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/.test(domain)){
        /* Do nothing */
    }else {
    	document.getElementById("warn_username").innerHTML = "Please enter a valid domain name";
	    document.getElementById("warn_username").className = 'col-pink';
	    document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
        return false;
    }

    if(domain != keep_domain){

    	// Call API
		var xhr = new XMLHttpRequest();
	        xhr.open('GET', 'https://mofh.tariktunaikartukredit.cf/api-v2/public/availability.public.php?domain='+domain+'&response_type=bool');
	        xhr.send();

	    xhr.onload = function() {

	    	if(xhr.status !== 200){
	    		// Server error, do not report to user but log to console
	        	console.log(xhr.responseText);
	        	document.getElementById("warn_username").style.display = "none";
		        document.getElementById("div_username").className = 'form-line focused';
	    		return false;
	    	}

	        if(xhr.responseText == '1'){
	        	document.getElementById("warn_username").innerHTML = "Contragulations! "+domain+" is available!";
	        	document.getElementById("warn_username").className = 'col-green';
		        document.getElementById("warn_username").style.display = "block";
		        document.getElementById("div_username").className = 'form-line focused success';
		        document.getElementById("keep_domain").innerHTML = domain;
	        }else if(xhr.responseText == '0'){
	        	document.getElementById("warn_username").innerHTML = "Unfortunely "+domain+" has been hosted here.";
		        document.getElementById("warn_username").className = 'col-pink';
		        document.getElementById("warn_username").style.display = "block";
		        document.getElementById("div_username").className = 'form-line focused error';
		        document.getElementById("keep_domain").innerHTML = domain;
	        }else{
	        	// Server error, do not report to user but log to console
	        	console.log(xhr.responseText);
	        	document.getElementById("warn_username").style.display = "none";
		        document.getElementById("div_username").className = 'form-line focused';
		        return false;
	        }

	    };

    }

    return true;

}

function checkEmail(){

	var email = document.getElementById("input_email").value;
	
	if(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)){
		document.getElementById("warn_email").style.display = "none";
	    document.getElementById("div_email").className = 'form-line focused success';
	    return true;
	}else{
		document.getElementById("warn_email").innerHTML = "Please enter a valid email.";
	    document.getElementById("warn_email").style.display = "block";
	    document.getElementById("div_email").className = 'form-line focused error';
		return false;
	}

}

function checkPassword(){

	var password = document.getElementById("input_password").value;

	if(password.length >= 6 && password.length <= 25){
	    document.getElementById("warn_password").style.display = "none";
	    document.getElementById("div_password").className = 'form-line focused success';
	    return true;
	}else if(password.length > 25){
		document.getElementById("warn_password").innerHTML = "Password is too long! 25 characthers maximum.";
		document.getElementById("warn_password").style.display = "block";
	    document.getElementById("div_password").className = 'form-line focused error';
	    return false;
	}else{
		document.getElementById("warn_password").innerHTML = "Password is too short! 6 characthers minimum.";
	    document.getElementById("warn_password").style.display = "block";
	    document.getElementById("div_password").className = 'form-line focused error';
	    return false;
	}

}

function checkPasswordMatch(){

	var pwd1 = document.getElementById("input_password").value;
	var pwd2 = document.getElementById("input_password_confirm").value;

	if(pwd1 == pwd2){
		document.getElementById("warn_password_confirm").style.display = "none";
		document.getElementById("div_password_confirm").className = 'form-line focused success';
		return true;
	}else{
		document.getElementById("warn_password_confirm").innerHTML = "Password does not match.";
		document.getElementById("warn_password_confirm").style.display = "block";
		document.getElementById("div_password_confirm").className = 'form-line focused error';
		return false;
	}

}

function checkCaptcha(){

	var captcha = document.getElementById('input_captcha').value;

	if(captcha == ''){
		document.getElementById("warn_captcha").innerHTML = "Captcha cannot be empty.";
		document.getElementById("warn_captcha").style.display = "block";
		document.getElementById("div_captcha").className = 'form-line focused error';
		return false;
	}else{
		document.getElementById("warn_captcha").style.display = "none";
		document.getElementById("div_captcha").className = 'form-line focused success';
		return true;
	}

}

function validateForm(){

	var agreedToTerms = document.getElementById('terms').checked;
	
	if(checkDomain() && checkEmail() && checkPassword() && checkPasswordMatch() && checkCaptcha() && agreedToTerms){
		document.getElementById('signup_form').submit();
	}

}
