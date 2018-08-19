<?php

/* Check if core was accessed directly */
if(!isset($include_core)){
    header("HTTP/1.0 403 Forbidden"); 
	die("403 Forbidden.");
}

/* Start Config */
$config = array(

    # About Company
    'Company Name' => 'Planet Cloud Hosting',
    'Company Logo' => 'https://image.ibb.co/hj4W7G/logo.png',
    'Contact Email' => 'hello@planetcloudhosting.cf',
    'Abuse Email' => 'abuse@planetcloudhosting.cf',
    'Primary Site URL' => 'http://planetcloudhosting.cf/',

    # System Configuration
    'Language' => 'EN', 
    'Use HTTPS' => false,
    'Color Scheme' => 'blue',
    'Enable Animations' => true,
    'Reseller Domain' => 'planetcloudhosting.cf',

    # Form Configuration
    'Enable Site Category Option' => true,
    'Enable Site Language Option' => true,
    'Minimum Password Length' => 8,
    
    # API Configuration
    'Enable MILD API' => true,

);

$mild_config = array(

    # Define API Server
    'Server' => 'https://mofh.tariktunaikartukredit.cf/api-v2',

    # Define API type
    'Type' => 'dev',

    # API credentials for Private & Developement API
    'Username' => 'dev_account',
    'Password' => 'dev_password',
    'Secret' => 'dev_secret',
    'Site Key' => 'dev_key',

    # More Options
    'Key Validation' => false,
    'Check if Server is Down' => false,

    # Remember to change the API KEY, only valid on developement stage.
    
);

/* Stop edditing after this line */
/* *** *** *** *** *** *** *** *** *** *** *** *** *** ***
    
    DO NOT MODIFY THE CODE BELOW 
    UNLESS YOU KNOW WHAT YOU'RE DOING.
    ---
    THE CODE BELOW WAS MEANT TO CHECK YOUR CONFIG
    AND LOAD PROPER FILES.

*** *** *** *** *** *** *** *** *** *** *** *** *** *** ***/

session_start();

class csrf
{

	private function session_valid_id(){
	    return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', session_id()) > 0;
	}
	
	public function createToken($for){

		if(!isset($_SESSION[$for.'_token'])){
			$_SESSION[$for.'_token'] = md5(uniqid(microtime(), true).rand(100,1000));
		}

		if(!$this->session_valid_id()){
			return 'COOKIES_NOT_ENABLED';
		}

		return $_SESSION[$for.'_token'];

	}

	public function reissueToken($for){

		$_SESSION[$for.'_token'] = md5(uniqid(microtime(), true).rand(100,1000));

		if(!$this->session_valid_id()){
			return 'COOKIES_NOT_ENABLED';
		}
		
		return $_SESSION[$for.'_token'];

	}	

	public function validateToken($for){

		if(!isset($_COOKIE['PHPSESSID'])){
			$this->showMsg[] = '[TYPE:DANGER]Cookies must be enabled in order to continue.';
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

class Logged
{

	/* Instance Related */
	protected $initialized = false;
		/* Errors */
		protected $has_error;
		protected $error_code = array();
		protected $showMsg = array();

	/* Settings */
	protected $config;

	/* API Related */
	protected $enable_api = false;
	protected $mild_config = null;
	protected $mild_server_url;

	/* Render Related */
	protected $page;
	protected $title = null;
	public $lang;

	/* Response Related */
	protected $accepting_response = false;
	protected $accResp_isSuccess = false;
	protected $accResp_message = null;


	# PUBLIC - Used to construct logic
	public function __construct($page, $title=null){
		global $config;
		global $include_core;

		if(!isset($page)){
			die("<h2>Missing required parameter.</h2>");
		}

		$required = array('Company Name', 'Company Logo', 'Contact Email', 'Abuse Email', 'Primary Site URL', 'Language', 'Use HTTPS', 'Color Scheme', 'Enable Animations', 'Reseller Domain', 'Enable Site Category Option', 'Enable Site Language Option', 'Minimum Password Length', 'Enable MILD API',
		);
		if(!$this->checkReq($required, $config)){
			die("<h2>Config is not properly configured! (Some or all fields are missing or empty)</h2>");
		}

		if($config['Enable MILD API']){
			global $mild_config;

			if(!isset($mild_config)){
				die("<h2>Config is not properly configured! (MILD API config is not present)</h2>");
			}

			$required = array('Server', 'Type', 'Username', 'Password', 'Secret', 'Site Key', 'Key Validation', 'Check if Server is Down',
			);
			if(!$this->checkReq($required, $mild_config)){
				die("<h2>Config is not properly configured! (MILD API config some or all fields are missing)</h2>");
			}

			$mild_config['Type'] = strtolower($mild_config['Type']);
			if($mild_config['Type'] == 'dev' OR $mild_config['Type'] == 'private' OR $mild_config['Type'] == 'public'){
			}else{
				die("<h2>Config is not properly configured! (MILD API config account type invalid.)</h2>");
			}

			$this->config = $config;
			$this->mild_config = $mild_config;
			$this->enable_api = true;
			$this->mild_server_url = $this->mild_config['Server'].'/'.strtolower($this->mild_config['Type']);

			if($this->mild_config['Check if Server is Down']){
		        $res = file_get_contents($this->mild_config['Server'].'/is_down.php');
		        if($res != '1'){
		            $this->enable_api = false;
		        }
		    }

		    if(($this->mild_config['Type'] == 'dev' OR $this->mild_config['Type'] == 'private') AND $this->mild_config['Key Validation'] AND $this->enable_api){
		    	$res = file_get_contents($this->mild_server_url.'/validate_key.php?key='.$this->mild_config['Site Key']);
                if($res != '1'){
                    die("<h2>Config is not properly configured! (Invalid MILD API key)</h2>");
                }
		    }
		}

		if($page === 'login' OR $page === 'signup' OR $page === 'terms' OR $page === 'privacy'){
			$this->page = $page;
		}else{
			die('<h2>Invalid or Undefined page.</h2>');
		}

		if($config['Use HTTPS']){
		    $config['domain'] = "https://".strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
		}else{
		    $config['domain'] = "http://" . strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
		}

		define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));

		if (glob(ROOT."/flame-and-blade-miniframework/lang/".strtolower($config['Language']).".lang.logged.php")) {
		    require ROOT."/flame-and-blade-miniframework/lang/".strtolower($config['Language']).".lang.logged.php";
		} else {
		    die('<h2>WARNING : '.$config['Language'].' Language file does not exsist.</h2>' . PHP_EOL);
		}
		$this->lang = $lang;

		if(isset($title)){
			$this->title = $title;
		}

		

		# Core is ready
		$this->initialized = true;
		return true;
	}

	public function acceptResponse(){

		$this->accepting_response = true;

		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			$this->showMsg[] = '[TYPE:DANGER]405 Method not allowed.';
			return false;
		}

		if(!$this->config['Enable Mild API']){
			$this->showMsg[] = '[TYPE:DANGER]Something went wrong, try again?';
			return false;
		}

		$required = array(
			'username',
			'email',
			'password',
			'password_confirm',
			'id',
			'captcha',
			'csrf_token'
		);
		if(!$this->checkReq($required, $_POST)){
			$this->showMsg[] = '[TYPE:DANGER]Something went wrong, try again?';
			return false;
		}

		foreach ($_POST as $key => $value) {
			if(!$this->validateInputs($value)){
				$this->showMsg[] = '[TYPE:DANGER]Something went wrong, try again?';
				return false;
			}
		}

		$csrf = new csrf;
	    if(!$csrf->validateToken('signup')){
	        $this->showMsg[] = '[TYPE:WARNING]The page has expired due to inactivity.<br/>Please try again.';
	        $csrf->reissueToken('signup');
	        return false;
	    }

	    $min_pass = $this->config['Minimum Password Length'];

	    if($this->config['Enable Site Category Option']){
    		if(!isset($_POST['website_category'])){
    			$this->showMsg[] = '[TYPE:DANGER]Something went wrong, try again?';
    			return false;
    		}
    	}
    	if($this->config['Enable Site Language Option']){
    		if(!isset($_POST['website_language'])){
    			$this->showMsg[] = '[TYPE:DANGER]Something went wrong, try again?';
    			return false;
    		}
    	}

    	if(strlen($_POST['username']) < 4 || strlen($_POST['username']) > 16){
    		$this->showMsg[] = '[TYPE:WARNING]Username is too short or too long!<br/>Minimum 4 and maximum 16 characthers.';
    		return false;
    	}

    	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    		$this->showMsg[] = '[TYPE:WARNING]Please enter a valid email address.';
    		return false;
    	}

    	if(strlen($_POST['password']) < $min_pass || strlen($_POST['password']) > 25){
    		$this->showMsg[] = '[TYPE:WARNING]Password is too short or too long!<br/>Minimum '.$min_pass.' and maximum 25 characthers.';
    		return false;
    	}

    	if(!$_POST['password'] === $_POST['password_confirm']){
			$this->showMsg[] = '[TYPE:WARNING]Confirm password does not match!';
    		return false;
    	}

    	if(!$_POST['terms_of_service'] == 'agreed'){
    		$this->showMsg[] = '[TYPE:WARNING]You had to agree to the terms of service.';
    		return false;
    	}

	    $domain = $_POST['username'].'.'.$this->config['Reseller Domain'];
	    $result = file_get_contents($mild_api['Server'].'/public/availability.public.php?domain='.$domain.'&response_type=bool');
	    if($result == 0){
	    	$_SESSION['showMsg'][] = '[TYPE:WARNING]The chosen subdomain has been taken!';
	    	return false;
	    }

	    return true;

	}

	public function render(){

		# Check state
		if($this->checkState()){
			die("<h2>Logged was unable to render this page.</h2>");
		}

		# Switch what to render
		switch ($this->page) {
			case 'login':
				$title = $this->lang['Login'].' - '.$this->config['Company Name'];
				$render = '';
				break;

			case 'signup':
				$title = $this->lang['Signup'].' - '.$this->config['Company Name'];
				if($this->accepting_response){

				}
				break;

			case 'terms':
				$title = $this->lang['Terms of Service'].' - '.$this->config['Company Name'];
				break;

			case 'privacy':
				$title = $this->lang['Privacy Policy'].' - '.$this->config['Company Name'];
				break;
			
			default:

				break;
		}

		# Custom title
		if(!isset($this->title)){
			$this->title = $title;
		}

		echo '<!DOCTYPE html>
	<html>
	    <head>
	        <meta charset="UTF-8">
	        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	        <title>'.$this->title.'</title>
	        <link rel="icon" href="/favicon.ico" type="image/x-icon">
	        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	        <link href="/material.logged.css" rel="stylesheet">'.PHP_EOL;
	        if($this->config['Enable Animations']){
	        	echo '	        <link href="https://daneden.github.io/animate.css/animate.min.css" rel="stylesheet">'.PHP_EOL;
	        }
	        echo '	        </head>
	    <body class="login-page">
	        <div class="login-box">
	            <div class="logo">
	                <a href="'.$this->config['Primary Site URL'].'">
	                    <p style="text-align:center">
	                        <img src="'.$this->config["Company Logo"].'" alt="'.$this->config["Company Name"].'" align="center">
	                    </p>
	                </a>
	            </div>'.PHP_EOL;

		return true;
	}

	# PROTECTED - Used to safeguard the Query.
	protected function validateInputs($the_inputs){

		if(!is_string($the_inputs)){
			$this->has_error = true;
			return false;
		}
		if(empty(trim($the_inputs))){
			$this->has_error = true;
			return false;
		}

		return true;
	}

	# PROTECTED - This method must be checked by all methods of system class.
	protected function checkState(){

		if(!$this->initialized){
			return true;
		}
		return false;
	}

	# PROTECTED - Used to check if required variable was set
	protected function checkReq($required, $data){
		if(!is_array($data) OR !is_array($required)){
			die("FUNCTION : checkReq -> Data and Required must be an array!");
		}

		foreach ($required as $key => $val) {
			if(!isset($data[$val])){
				return false;
			}
			if(!is_bool($data[$val])){
				if(empty(trim($data[$val]))){
					return false;
				}
			}
		}
		return true;
	}
	
}


?>