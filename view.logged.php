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
	        <link href="/material.logged.css" rel="stylesheet">
	    </head>
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
	echo '	
	            <div class="card">
	                <div class="body">
	                    <div class="msg">'.$language["Sign up for a free account"].'</div>
	                    <form method="post" action="/signup">
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">person</i>
	                            </span>
	                            <div id="input_username" class="form-line">
	                                <input id="username" type="text" class="form-control" name="username" placeholder="'.$language['your-name'].'.'.$config["Reseller Domain"].'" maxlength="16" onkeyup="return ismaxlength(this)" onblur="checkDomainLength();" required value="">
	                            </div>
	                            <small class="col-pink" style="display: none;" id="username_warn">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">email</i>
	                            </span>
	                            <div id="input_email" class="form-line">
	                                <input id="email" type="email" class="form-control" name="email" placeholder="'.$language["Email Address"].'" onblur="checkEmailValidity();" required value="">
	                            </div>
	                            <small class="col-pink" style="display: none;" id="email_warn">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                            </span>
	                            <div id="input_password" class="form-line">
	                                <input id="password" type="password" class="form-control" name="password" minlength="6" placeholder="'.$language["Password"].'" maxlength="25" onkeyup="return ismaxlength(this)" onblur="checkPwdLength();" required>
	                            </div>
	                            <small class="col-pink" style="display: none;" id="password_warn">{WARNING}</small>
	                        </div>
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                            </span>
	                            <div id="input_password_confirm" class="form-line">
	                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" minlength="6" placeholder="'.$language["Confirm Password"].'" maxlength="25" onkeyup="return ismaxlength(this)" onblur="matchPassword()" required>
	                            </div>
	                            <small class="col-pink" style="display: none;" id="password_confirm_notMatched">{WARNING}</small>
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
	                            <div class="form-line">
	                                <input type="text" class="form-control" name="captcha" placeholder="'.$language["Enter Captcha"].'" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <input type="checkbox" name="terms_of_service" id="terms" class="filled-in chk-col-'.$config['Color Scheme'].' onchange="validateForm();">
	                            <label for="terms">'.$language["I've read and agree to the"].' <a href="'.$config['domain'].'/terms">'.$language["terms of service"].'</a>.</label>
	                        </div>
	                        <button class="btn btn-block btn-lg bg-'.$config['Color Scheme'].' waves-effect" disabled>'.$language["SIGN UP"].'</button>
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

echo '</div>
	        <script src="/material.logged.js"></script>
	        <script src="/custom.js"></script>
	    </body>
	</html>';

?>