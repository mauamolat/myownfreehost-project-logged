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

$mild_api = array(

    # Define API Server
    'Server' => 'https://mofh.tariktunaikartukredit.cf/api-v2',

    # Define API type
    'Type' => 'DEVELOPEMENT',

    # API credentials for Private & Developement API
    'MILD_API_KEY' => '1005743D73B5C5F8E1C0D28CE225F46C',
    'MILD_API_PASSWORD' => '52B3CDC308E0D6E6ACB5E4EB269D7929F3976B0DCEA9A5522FDF0704A39794DB411E6F82F73174CD973D13B4B4B4BC12BD99810EFD4249E35886434A3B11A33A',
    'MILD_API_SECRET' => 'E645B74E030EB18DBBA2FB3CDDC8E62FC3F158FD',

    # More Options
    'Disable Key Validation' => true,
    'Check if Server is Down' => false,

    # Remember to change the API KEY, only valid on developement stage.
    
);

/* Stop Editting after this line! */

/* *** *** *** *** *** *** *** *** *** *** *** *** *** ***
    
    DO NOT MODIFY THE CODE BELOW 
    UNLESS YOU KNOW WHAT YOU'RE DOING.
    ---
    THE CODE BELOW WAS MEANT TO CHECK YOUR CONFIG
    AND LOAD PROPER FILES.

*** *** *** *** *** *** *** *** *** *** *** *** *** *** ***/

# Check if config is set properly
    if(!isset($config['Company Name'], $config['Company Logo'], $config['Contact Email'], $config['Abuse Email'], $config['Language'], $config['Use HTTPS'], $config['Primary Site URL'], $config['Color Scheme'])){
        die("<h2>Config is not properly configured! (Some or all fields are missing)</h2>");
    }

    if (empty($config['Company Name'] && $config['Company Logo'] && $config['Contact Email'] && $config['Abuse Email'] && $config['Language'] && $config['Primary Site URL'] && $config['Color Scheme'])) {
        die("<h2>Config is not properly configured! (Some or all fields are empty)</h2>");
    }

    if($config['Enable MILD API']){
        if(!isset($mild_api)){
            die("<h2>Config is not properly configured! (MILD API config is not present)</h2>");
        }elseif(!isset($mild_api['Type']) OR !isset($mild_api['Server'])){
            die("<h2>Config is not properly configured! (MILD API config some or all fields are missing)</h2>");
        }else{

            if($mild_api['Check if Server is Down']){
                $res = file_get_contents($mild_api['Server'].'/is_down.php');
                if($res != '1'){
                    $config['Enable MILD API'] = false;
                }
            }

            $mild_api['Type'] = strtoupper($mild_api['Type']);

            switch ($mild_api['Type']) {
                case 'PRIVATE':
                    if(!isset($mild_api['MILD_API_KEY']) OR !isset($mild_api['MILD_API_PASSWORD']) OR !isset($mild_api['MILD_API_SECRET'])){
                        die("<h2>Config is not properly configured! (MILD API config some or all fields are missing)</h2>");
                    }else{
                        if(!isset($mild_api['Disable Key Validation'])){
                            $res = file_get_contents($mild_api['Server'].'/private/validate_key.private.php?key='.$mild_api['MILD_API_KEY']);
                            if($res != '1'){
                                die("<h2>Config is not properly configured! (Invalid MILD API key)</h2>");
                            }
                        }
                    }
                    break;

                case 'DEVELOPEMENT':
                    if(!isset($mild_api['MILD_API_KEY']) OR !isset($mild_api['MILD_API_PASSWORD']) OR !isset($mild_api['MILD_API_SECRET'])){
                        die("<h2>Config is not properly configured! (MILD API config some or all fields are missing)</h2>");
                    }else{
                        if(!isset($mild_api['Disable Key Validation'])){
                            $res = file_get_contents($mild_api['Server'].'/dev/validate_key.dev.php?key='.$mild_api['MILD_API_KEY']);
                            if($res != '1'){
                                die("<h2>Config is not properly configured! (Invalid MILD API key)</h2>");
                            }
                        }
                    }
                    break;
                
                default:
                    /* Do nothing */
                    break;
            }
        }
    }

# Define Root Folder
    define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));

# Prevent null redirect
    $config_is_loaded = true;

# Get current domain
    if($config['Use HTTPS'] == true){
        $config['domain'] = "https://".strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
    }else{
        $config['domain'] = "http://" . strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));
    }

# Load Language
    if (glob(ROOT."/flame-and-blade-miniframework/lang/".strtolower($config['Language']).".lang.logged.php")) {
        require ROOT."/flame-and-blade-miniframework/lang/".strtolower($config['Language']).".lang.logged.php";
    } else {
        die('<h2>WARNING : '.$config['Language'].' Language file does not exsist.</h2>' . PHP_EOL);
    }

# Start Session
    session_start();

# Load Anti-CSRF Class
    if (glob(ROOT . "/flame-and-blade-miniframework/class/anti-csrf.class.php")) {
        require ROOT . "/flame-and-blade-miniframework/class/anti-csrf.class.php";
    } else {
        echo '<h2>WARNING : Anti-CSRF Class does not exsist.</h2>' . PHP_EOL;
    }

# Load Essentials Function (From FNB for MessageAPI)
    if (glob(ROOT . "/flame-and-blade-miniframework/functions/essentials.function.php")) {
        require ROOT . "/flame-and-blade-miniframework/functions/essentials.function.php";
    } else {
        echo '<h2>WARNING : Essential Function does not exsist.</h2>' . PHP_EOL;
    }

?>