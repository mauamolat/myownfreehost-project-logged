<?php

if(!isset($inc_config)){
    header("Location: /");
}

/* Edit the array below! */
$config = array(

    # About Company
    'Company Name' => 'Planet Cloud Hosting',
    'Company Logo' => 'https://image.ibb.co/hj4W7G/logo.png',
    'Contact Email' => 'hello@planetcloudhosting.cf',
    'Abuse Email' => 'abuse@planetcloudhosting.cf',
    'Primary Site URL' => 'http://planetcloudhosting.cf/',

    # System Configuration
    'Language' => 'en', 
    'Use HTTPS' => false,
    'Color Scheme' => 'blue',
    'Reseller Domain' => 'planetcloudhosting.cf',
    'Enable Site Category Option' => true,
    'Enable Site Language Option' => true,

);

/* Stop Editting after this line! */

# Check if config is set properly
    if(!isset($config['Company Name'], $config['Company Logo'], $config['Contact Email'], $config['Abuse Email'], $config['Language'], $config['Use HTTPS'], $config['Primary Site URL'], $config['Color Scheme'])){
        die("<h2>Config is not properly configured!</h2>");
    }

    if (empty($config['Company Name'] && $config['Company Logo'] && $config['Contact Email'] && $config['Abuse Email'] && $config['Language'] && $config['Primary Site URL'] && $config['Color Scheme'])) {
        die("<h2>Config is not properly configured!</h2>");
    }

# Define Root Folder
    define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));

# Get current domain
    if($config['Use HTTPS'] == true){
        $config['domain'] = "https://".strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
    }else{
        $config['domain'] = "http://" . strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
    }

# Load Language
    if (glob(ROOT."/".strtolower($config['Language']).".lang.logged.php")) {
        $config_is_loaded = true;
        require ROOT."/".strtolower($config['Language']).".lang.logged.php";
    } else {
        echo '<h2>WARNING : Language file does not exsist.</h2>' . PHP_EOL;
    }

# Start Session
session_start();

# Load Anti-CSRF Class
    if (glob(ROOT . "/flame-and-blade-miniframework/class/anti-csrf.class.php")) {
        require ROOT . "/flame-and-blade-miniframework/class/anti-csrf.class.php";
    } else {
        echo '<h2>WARNING : Anti-CSRF Class does not exsist.</h2>' . PHP_EOL;
    }



?>