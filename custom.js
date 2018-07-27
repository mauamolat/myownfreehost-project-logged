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
    if(domain.length >= 4 && domain.length <= 16){
    	if(typeof apiServer !== 'undefined' && apiServer !== null){/* Do Nothing */}else{
	    	document.getElementById("warn_username").style.display = "none";
		    document.getElementById("div_username").className = 'form-line focused success';
	    }		
	}else if(domain.length > 16){
		document.getElementById("warn_username").innerHTML = lang.subTooLong;
		document.getElementById("warn_username").className = 'col-pink';
		document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
	    return false;
	}else{
		document.getElementById("warn_username").innerHTML = lang.subTooShort;
		document.getElementById("warn_username").className = 'col-pink';
	    document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
	    return false;
	}

	// Append reseller domain
	domain = domain+'.'+String(resellerDomain);

	// Check domain validity
    if(/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/.test(domain)){
    	if(typeof apiServer !== 'undefined' && apiServer !== null){/* Do Nothing */}else{
    		document.getElementById("warn_username").style.display = "none";
	    	document.getElementById("div_username").className = 'form-line focused success';
    	}  
    }else {
    	document.getElementById("warn_username").innerHTML = lang.invalidDomainName;
	    document.getElementById("warn_username").className = 'col-pink';
	    document.getElementById("warn_username").style.display = "block";
	    document.getElementById("div_username").className = 'form-line focused error';
        return false;
    }

    // Check if MILD API is enabled
    if(typeof apiServer !== 'undefined' && apiServer !== null){/* Do Nothing */}else{return true;}

    if(domain != keep_domain){

    	// Call API
		var xhr = new XMLHttpRequest();
	        xhr.open('GET', apiServer+'/public/availability.public.php?domain='+domain+'&response_type=bool');
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
	        	document.getElementById("warn_username").innerHTML = lang.contrags+" "+domain+" "+lang.isAvailable;
	        	document.getElementById("warn_username").className = 'col-green';
		        document.getElementById("warn_username").style.display = "block";
		        document.getElementById("div_username").className = 'form-line focused success';
		        document.getElementById("keep_domain").innerHTML = domain;
	        }else if(xhr.responseText == '0'){
	        	document.getElementById("warn_username").innerHTML = lang.unfortune+" "+domain+" "+lang.isTaken;
		        document.getElementById("warn_username").className = 'col-pink';
		        document.getElementById("warn_username").style.display = "block";
		        document.getElementById("div_username").className = 'form-line focused error';
		        document.getElementById("keep_domain").innerHTML = domain;
		        return false;
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
		document.getElementById("warn_email").innerHTML = lang.invalidEmail;
	    document.getElementById("warn_email").style.display = "block";
	    document.getElementById("div_email").className = 'form-line focused error';
		return false;
	}

}

function checkPassword(){

	var password = document.getElementById("input_password").value;

	if(password.length >= minPwdLength && password.length <= 25){
	    document.getElementById("warn_password").style.display = "none";
	    document.getElementById("div_password").className = 'form-line focused success';
	    return true;
	}else if(password.length > 25){
		document.getElementById("warn_password").innerHTML = lang.pwdTooLong;
		document.getElementById("warn_password").style.display = "block";
	    document.getElementById("div_password").className = 'form-line focused error';
	    return false;
	}else{
		document.getElementById("warn_password").innerHTML = lang.pwdTooShort1+" "+minPwdLength+" "+lang.pwdTooShort2;
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
		document.getElementById("warn_password_confirm").innerHTML = lang.pwdNotMatch;
		document.getElementById("warn_password_confirm").style.display = "block";
		document.getElementById("div_password_confirm").className = 'form-line focused error';
		return false;
	}

}

function checkCaptcha(){

	var captcha = document.getElementById('input_captcha').value;

	if(captcha == ''){
		document.getElementById("warn_captcha").innerHTML = lang.captchaEmpty;
		document.getElementById("warn_captcha").style.display = "block";
		document.getElementById("div_captcha").className = 'form-line focused error';
		return false;
	}else{
		document.getElementById("warn_captcha").style.display = "none";
		document.getElementById("div_captcha").className = 'form-line focused success';
		return true;
	}

}

function checkTerms(){

	var agreedToTerms = document.getElementById('terms').checked;

	if(agreedToTerms){
		document.getElementById("warn_terms").style.display = "none";
		return true;
	}else{
		document.getElementById("warn_terms").innerHTML = lang.termsNotChecked;
		document.getElementById("warn_terms").style.display = "block";
		return false;
	}

}

function validateForm(){

	if(checkDomain() && checkEmail() && checkPassword() && checkPasswordMatch() && checkCaptcha() && checkTerms()){
		document.getElementById('signup_form').submit();
	}

}
