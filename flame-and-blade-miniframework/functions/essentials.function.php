<?php

/**
*
*	ESSENTIALS FUNCTION v1.0
*	by PlanetCloud
*	A Flame & Blade function file	
*
*	-----
*
*	THIS IS A COMPACT VERSION.
*	Some functions are removed to optimize for speed.
*
**/

/**
*	Show Message (MessageAPI)
*	Show all MessageAPI message's.
*	WARNING : BLADE/CSS Needs to be loaded first.
**/

if(!isset($config_is_loaded)){
	header("Location: /");
	exit;
}

function showMessage(){

	if(isset($_SESSION['showMsg']) && !empty($_SESSION['showMsg']) && is_array($_SESSION['showMsg'])){

		$i = 0;
		$len = count($_SESSION['showMsg']);

		foreach ($_SESSION['showMsg'] as $message) {

			if(strpos($message, '[NO_ANIMATION]')){
				switch ($message) {
					case (strpos($message, '[TYPE:SUCCESS]') !== false):
						$message = str_replace("[TYPE:SUCCESS]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-success">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DANGER]') !== false):
						$message = str_replace("[TYPE:DANGER]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-danger">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:PRIMARY]') !== false):
						$message = str_replace("[TYPE:PRIMARY]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-primary">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:SECONDARY]') !== false):
						$message = str_replace("[TYPE:SECONDARY]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-secondary">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:WARNING]') !== false):
						$message = str_replace("[TYPE:WARNING]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-warning">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:INFO]') !== false):
						$message = str_replace("[TYPE:INFO]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-info">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:LIGHT]') !== false):
						$message = str_replace("[TYPE:LIGHT]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-light">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DARK]') !== false):
						$message = str_replace("[TYPE:DARK]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-dark">'.$message.'</div>'.PHP_EOL;
						break;
					
					default:
						echo '	            <div class="alert alert-danger">'.$message.'</div>'.PHP_EOL;
						break;
				}
			}else{
				switch ($message) {
					case (strpos($message, '[TYPE:SUCCESS]') !== false):
						$message = str_replace("[TYPE:SUCCESS]","",$message);
						echo '	            <div class="alert alert-success flash animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DANGER]') !== false):
						$message = str_replace("[TYPE:DANGER]","",$message);
						echo '	            <div class="alert alert-danger shake animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:PRIMARY]') !== false):
						$message = str_replace("[TYPE:PRIMARY]","",$message);
						echo '	            <div class="alert alert-primary pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:SECONDARY]') !== false):
						$message = str_replace("[TYPE:SECONDARY]","",$message);
						echo '	            <div class="alert alert-secondary pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:WARNING]') !== false):
						$message = str_replace("[TYPE:WARNING]","",$message);
						echo '	            <div class="alert alert-warning shake animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:INFO]') !== false):
						$message = str_replace("[TYPE:INFO]","",$message);
						echo '	            <div class="alert alert-info pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:LIGHT]') !== false):
						$message = str_replace("[TYPE:LIGHT]","",$message);
						echo '	            <div class="alert alert-light flash animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DARK]') !== false):
						$message = str_replace("[TYPE:DARK]","",$message);
						echo '	            <div class="alert alert-dark flash animated">'.$message.'</div>'.PHP_EOL;
						break;
					
					default:
						echo '	            <div class="alert alert-danger flash animated">'.$message.'</div>'.PHP_EOL;
						break;
				}
			}



			if($i == $len - 1) {
		        $_SESSION['showMsg'] = array();
		    }
		    $i++;
			
		}

	}elseif(isset($this->errorMsg) && !empty($this->errorMsg) && is_array($this->errorMsg)){

		$i = 0;
		$len = count($this->errorMsg);

		foreach ($this->errorMsg as $message) {

			if(strpos($message, '[NO_ANIMATION]')){
				switch ($message) {
					case (strpos($message, '[TYPE:SUCCESS]') !== false):
						$message = str_replace("[TYPE:SUCCESS]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-success">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DANGER]') !== false):
						$message = str_replace("[TYPE:DANGER]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-danger">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:PRIMARY]') !== false):
						$message = str_replace("[TYPE:PRIMARY]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-primary">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:SECONDARY]') !== false):
						$message = str_replace("[TYPE:SECONDARY]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-secondary">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:WARNING]') !== false):
						$message = str_replace("[TYPE:WARNING]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-warning">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:INFO]') !== false):
						$message = str_replace("[TYPE:INFO]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-info">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:LIGHT]') !== false):
						$message = str_replace("[TYPE:LIGHT]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-light">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DARK]') !== false):
						$message = str_replace("[TYPE:DARK]","",$message);
						$message = str_replace("[NO_ANIMATION]","",$message);
						echo '	            <div class="alert alert-dark">'.$message.'</div>'.PHP_EOL;
						break;
					
					default:
						echo '	            <div class="alert alert-danger">'.$message.'</div>'.PHP_EOL;
						break;
				}
			}else{
				switch ($message) {
					case (strpos($message, '[TYPE:SUCCESS]') !== false):
						$message = str_replace("[TYPE:SUCCESS]","",$message);
						echo '	            <div class="alert alert-success flash animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DANGER]') !== false):
						$message = str_replace("[TYPE:DANGER]","",$message);
						echo '	            <div class="alert alert-danger shake animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:PRIMARY]') !== false):
						$message = str_replace("[TYPE:PRIMARY]","",$message);
						echo '	            <div class="alert alert-primary pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:SECONDARY]') !== false):
						$message = str_replace("[TYPE:SECONDARY]","",$message);
						echo '	            <div class="alert alert-secondary pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:WARNING]') !== false):
						$message = str_replace("[TYPE:WARNING]","",$message);
						echo '	            <div class="alert alert-warning shake animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:INFO]') !== false):
						$message = str_replace("[TYPE:INFO]","",$message);
						echo '	            <div class="alert alert-info pulse animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:LIGHT]') !== false):
						$message = str_replace("[TYPE:LIGHT]","",$message);
						echo '	            <div class="alert alert-light flash animated">'.$message.'</div>'.PHP_EOL;
						break;

					case (strpos($message, '[TYPE:DARK]') !== false):
						$message = str_replace("[TYPE:DARK]","",$message);
						echo '	            <div class="alert alert-dark flash animated">'.$message.'</div>'.PHP_EOL;
						break;
					
					default:
						echo '	            <div class="alert alert-danger flash animated">'.$message.'</div>'.PHP_EOL;
						break;
				}
			}



			if($i == $len - 1) {
		        $this->errorMsg = array();
		    }
		    $i++;
			
		}

	}

}

?>