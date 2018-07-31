<?php

/**
*
*	ANTI-CSRF v1.0 (PRODUCTION READY)
*	by PlanetCloud
*	A Flame & Blade class file
*
*	WARNING : Session MUST BE STARTED first!
*
**/

if(!isset($config_is_loaded)){
	header("Location: /");
	exit;
}

if(session_status() == PHP_SESSION_NONE){
    die('<h2>Anti-CSRF : Session MUST BE STARTED first!</h2>');
}

class csrf
{
	
	function createToken($for){

		if(!isset($_SESSION[$for.'_token'])){
			$_SESSION[$for.'_token'] = md5(uniqid(microtime(), true).rand(100,1000));
		}

		if(!isset($_COOKIE['PHPSESSID'])){
			return 'COOKIES_NOT_ENABLED';
		}

		return $_SESSION[$for.'_token'];

	}

	function reissueToken($for){

		$_SESSION[$for.'_token'] = md5(uniqid(microtime(), true).rand(100,1000));

		if(!isset($_COOKIE['PHPSESSID'])){
			return 'COOKIES_NOT_ENABLED';
		}
		
		return $_SESSION[$for.'_token'];

	}	

	function validateToken($for){

		if(!isset($_COOKIE['PHPSESSID'])){
			$_SESSION['showMsg'][] = '[TYPE:DANGER]Cookies must be enabled in order to continue.';
			return false;
		}

		if(isset($_POST['csrf_token'])){
			if($_SESSION[$for.'_token'] == $_POST['csrf_token']){
				return true;
			}
		}

		return false;

	}

}

$csrf = new csrf;

?>