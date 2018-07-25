<?php

if(!isset($config_is_loaded)){
	header("Location: /");
}

echo '<!DOCTYPE html>
	<html>
	    <head>
	        <meta charset="UTF-8">
	        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	        <title>'.$language["Sign up for a free account"].' - '.$config["Company Name"].'</title>
	        <link rel="icon" href="/favicon.ico" type="image/x-icon">
	        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	        <link href="/material.logged.css" rel="stylesheet">'.PHP_EOL;
	        if($config['Enable Animations'] == true){
	        	echo '	        <link href="https://daneden.github.io/animate.css/animate.min.css" rel="stylesheet">'.PHP_EOL;
	        }

	    echo '	        </head>
	    <body class="login-page">
	        <div class="login-box">
	            <div class="logo">
	                <a href="'.$config["Primary Site URL"].'">
	                    <p style="text-align:center">
	                        <img src="'.$config["Company Logo"].'" alt="'.$config["Company Name"].'" align="center">
	                    </p>
	                </a>
	            </div>'.PHP_EOL;

if($showPage == 'signup'){

	if($config['Enable MILD API']){
		$form_action = '/signup';
	}else{
		$form_action = 'https://securesignup.net/register2.php';
	}

	echo '	
	            <div class="card">
	                <div class="body">
	                    <div class="msg">'.$language["Sign up for a free account"].'</div>
	                    <form method="post" action="'.$form_action.'" id="signup_form">
	                    '.showMessage().'
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">person</i>
	                            </span>
	                            <div id="div_username" class="form-line">
	                                <input id="input_username" type="text" class="form-control" name="username" placeholder="'.$language['your-name'].'.'.$config["Reseller Domain"].'" maxlength="16" onkeyup="checkDomain();return ismaxlength(this);" onblur="checkDomain();" autocomplete="off" required value="">
	                            </div>
	                            <small class="col-pink" style="display: none;" id="warn_username">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">email</i>
	                            </span>
	                            <div id="div_email" class="form-line">
	                                <input id="input_email" type="email" class="form-control" name="email" placeholder="'.$language["Email Address"].'" onkeyup="checkEmail();" autocomplete="off" required value="">
	                            </div>
	                            <small class="col-pink" style="display: none;" id="warn_email">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                            </span>
	                            <div id="div_password" class="form-line">
	                                <input id="input_password" type="password" class="form-control" name="password" minlength="'.$config['Minimum Password Length'].'" placeholder="'.$language["Password"].'" maxlength="26" onkeyup="checkPassword();return ismaxlength(this)" required>
	                            </div>
	                            <small class="col-pink" style="display: none;" id="warn_password">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                            </span>
	                            <div id="div_password_confirm" class="form-line">
	                                <input id="input_password_confirm" type="password" class="form-control" name="password_confirm" minlength="'.$config['Minimum Password Length'].'" placeholder="'.$language["Confirm Password"].'" maxlength="25" onkeyup="checkPasswordMatch();return ismaxlength(this)" required>
	                            </div>
	                            <small class="col-pink" style="display: none;" id="warn_password_confirm">{WARNING}</small>
	                        </div>'.PHP_EOL;

	                        if($config['Enable Site Category Option'] == true){
	                            echo '                        <div class="form-group">
	                            <tr>
	                                <th>Site Category
	                                <td>
	                                    <select  class="form-control" size="1" name="website_category">
	                                        <option>Personal</option>
	                                        <option>Business</option>
	                                        <option>Hobby</option>
	                                        <option>Forum</option>
	                                        <option>Adult</option>
	                                        <option>Dating</option>
	                                        <option>Software / Download</option>
	                                    </select>
	                                </td>
	                            </tr>
	                        </div>'.PHP_EOL;
	                        }

	                        if($config['Enable Site Language Option'] == true){
	                            echo '                        <div class="form-group">
	                            <tr>
	                                <th>Site Language
	                                <td>
	                                    <select  class="form-control" size="1" name="website_language">
	                                        <option>English</option>
	                                        <option>Non-English</option>
	                                    </select>
	                                </td>
	                            </tr>
	                        </div>'.PHP_EOL;
	                        }
	                        
	                        echo '
	                        <input type="hidden" name="id" value="58688f1a8e0f4fa84dffb550b62d80608427e">
	                        <img width="100%" src="https://securesignup.net/image.php?id=58688f1a8e0f4fa84dffb550b62d80608427e">
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                            </span>
	                            <div id="div_captcha" class="form-line">
	                                <input id="input_captcha" type="text" class="form-control" name="captcha" placeholder="'.$language["Enter Captcha"].'" onblur="checkCaptcha();" autocomplete="off" required>
	                            </div>
	                            <small class="col-pink" style="display: none;" id="warn_captcha">{WARNING}</small>
	                        </div>
	                        <div class="form-group">
	                            <input type="checkbox" name="terms_of_service" value="agreed" id="terms" class="filled-in chk-col-'.$config['Color Scheme'].'">
	                            <label for="terms">'.$language["I've read and agree to the"].' <a href="'.$config['domain'].'/terms">'.$language["terms of service"].'</a>.</label>
	                        </div>
	                        <a id="signupBtn" class="btn btn-block btn-lg bg-'.$config['Color Scheme'].' waves-effect" onclick="validateForm();">'.$language["SIGN UP"].'</a>
	                        <div class="m-t-25 m-b--5 align-center">
	                            <a href="'.$config["domain"].'/login">'.$language["Already have a membership"].'?</a>
	                        </div>
	                        <input type="hidden" name="csrf_token" value="'.$csrf->createToken("signup").'">
	                    </form>
	                </div>
	            </div>
	            <script type="text/javascript">
	            	var thisIsPage = "SIGNUP";
	            </script>'.PHP_EOL;
}

echo '			</div>
			<div id="keep_domain" style="display:none;"></div>
			<script type="text/javascript">
				var minPwdLength = "'.$config['Minimum Password Length'].'";'.PHP_EOL;

				if($config['Enable MILD API']){
					echo '				var apiServer = "'.$mild_api['Server'].'";
				var resellerDomain = "'.$config['Reseller Domain'].'";'.PHP_EOL;
				}

			echo '			</script>
	        <script src="/material.logged.js"></script>
	        <script src="/custom.js"></script>
	    </body>
	</html>';

?>