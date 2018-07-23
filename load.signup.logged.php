<?php

$inc_config = true;
require_once 'config.logged.php';

/* POST Logic */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	/* Validate token */
    if(isset($_POST['csrf_token'])){
        if(!$csrf->validateToken('signup')){
            $_SESSION['showMsg'][] = '[TYPE:WARNING]The page has expired due to inactivity.<br/>Please try again.';
            $csrf->reissueToken('signup'); # Reissue the token
        }
    }else{
        $_SESSION['showMsg'][] = '[TYPE:DANGER]Something\'s not right...<br/>Try again?';
    }

    if(!$_SESSION['showMsg']){

    	function validateCredentials(){

    		if(!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['website_category'], $_POST['website_language'], $_POST['id'], $_POST['captcha'], $_POST['terms_of_service'], $_POST['csrf_token'])){
    			return false;
    		}

    		if(empty(trim(str)))

    	}

    }

	if($config['Enable MILD API'] == true){

	}

}

$showPage = 'signup';
require ROOT.'/view.logged.php';

?>
