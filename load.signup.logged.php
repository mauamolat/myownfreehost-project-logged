<?php

$inc_config = true;
require_once 'config.logged.php';

# MessageAPI
    if(!isset($_SESSION['showMsg'])){
        $_SESSION['showMsg'] = array();
    }

/* POST Logic */
if($_SERVER['REQUEST_METHOD'] == 'POST'){

	# Check if MILD API was enabled
	if(!$config['Enable MILD API']){
		$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
	}

	# Check if MILD API was either set to DEVELOPEMENT or PRIVATE mode
	if(!$mild_api['Type'] == 'PRIVATE' OR !$mild_api['Type'] == 'DEVELOPEMENT'){
		$_SESSION['showMsg'][] = '[TYPE:DANGER]Something went wrong with the server configuration...<br/>Don\'t worry! It\'s not your fault.<br/>Please try again.';
	}
    
	/* Validate token */
    if(isset($_POST['csrf_token'])){
        if(!$csrf->validateToken('signup')){
            $_SESSION['showMsg'][] = '[TYPE:WARNING]The page has expired due to inactivity.<br/>Please try again.';
            $csrf->reissueToken('signup'); # Reissue the token
        }
    }else{
        $_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    }

    if($_SESSION['showMsg']){

    	function validateCredentials(){

    		global $config;
    		global $mild_api;

    		$min_pass = $config['Minimum Password Length'];

    		# Check if variable is present
    		if(!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['id'], $_POST['captcha'], $_POST['terms_of_service'], $_POST['csrf_token'])){
    			$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    			return false;
    		}

    		if($config['Enable Site Category Option']){
    			if(!isset($_POST['website_category'])){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		if($config['Enable Site Language Option']){
    			if(!isset($_POST['website_language'])){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		# Prevent Array Injection
    		if(is_array($_POST['username']) || is_array($_POST['email']) || is_array($_POST['password']) || is_array($_POST['password_confirm']) || is_array($_POST['id']) || is_array($_POST['captcha']) || is_array($_POST['terms_of_service']) || is_array($_POST['csrf_token'])){
    			$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    			return false;
    		}

    		if($config['Enable Site Category Option']){
    			if(is_array($_POST['website_category'])){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		if($config['Enable Site Language Option']){
    			if(is_array($_POST['website_language'])){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		# Check if variable is empty
    		if(empty(trim($_POST['username']) && trim($_POST['email']) && trim($_POST['password']) && trim($_POST['password_confirm']) && trim($_POST['id']) && trim($_POST['captcha']) && trim($_POST['terms_of_service']) && trim($_POST['csrf_token']))){
    			$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    			return false;
    		}

    		if($config['Enable Site Category Option']){
    			if(empty(trim($_POST['website_category']))){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		if($config['Enable Site Language Option']){
    			if(empty(trim($_POST['website_language']))){
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    				return false;
    			}
    		}

    		# Check if username is atleast 4 characther and less than 16
    		if(strlen($_POST['username']) < 4 || strlen($_POST['username']) > 16){
    			$_SESSION['showMsg'][] = '[TYPE:WARNING]Username is too short/long!<br/>Minimum 3 and maximum 16 characthers.';
    			return false;
    		}

    		# Check if email is valid
    		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    			$_SESSION['showMsg'][] = '[TYPE:WARNING]Please enter a valid email';
    			return false;
    		}

    		# Check if password is atleast 6 characther
    		if(strlen($_POST['password']) < $min_pass || strlen($_POST['password']) > 25){
    			$_SESSION['showMsg'][] = '[TYPE:WARNING]Password is too short/long!<br/>Minimum '.$min_pass.' and maximum 25 characthers.';
    			return false;
    		}

    		# Check if password and confirm password matched
    		if(!$_POST['password'] === $_POST['password_confirm']){
				$_SESSION['showMsg'][] = '[TYPE:WARNING]Confirm password does not match!';
    			return false;
    		}

    		# Check if user agreed to terms or service
    		if(!$_POST['terms_of_service'] == 'agreed'){
    			$_SESSION['showMsg'][] = '[TYPE:WARNING]You had to agree to the terms of service.';
    			return false;
    		}

    		# Check if domain is available
	    	$domain = $_POST['username'].'.'.$config['Reseller Domain'];
	    	$result = file_get_contents($mild_api['Server'].'/public/availability.public.php?domain='.$domain.'&response_type=bool');
	    	if($result == 0){
	    		$_SESSION['showMsg'][] = '[TYPE:WARNING]The chosen subdomain has been taken!';
	    		return false;
	    	}

    		return true;

    	}

    	if(validateCredentials()){
    		
    		switch ($mild_api['Type']) {
    			case 'PRIVATE':
    				$call = file_get_contents($mild_api['Server'].'/private/signup.private.php');
    				break;

    			case 'DEVELOPEMENT':
    				$call = file_get_contents($mild_api['Server'].'/dev/signup.private.php');
    				break;
    			
    			default:
    				$_SESSION['showMsg'][] = '[TYPE:DANGER]Something went wrong with the server configuration...<br/>Don\'t worry! It\'s not your fault.<br/>Please try again.';
    				break;
    		}

    		echo 'PASSED';

    	}

    }

}

$page = 'signup';
require ROOT.'/view.logged.php';

?>
