<?php

$GLOBALS[userErrors] = array(
			"blogExists"		=> "userRegisterError/blogExists",
			"userExists"		=> "userRegisterError/exists",
			"userDontExists"	=> "userRegisterError/dontExists",
			"emptyField"		=> "userRegisterError/emptyField",
			"registerMail"		=> "userRegisterError/regMail",
			"userConfirm"		=> "userRegisterError/confirm"
			);
			
registerModuleErrors();


function registerModuleErrors() {
	global $userErrors;
	
	$reg	 = "#([A-Z+])#";
	
	foreach ( $userErrors as $key => $value ) {
		$descName = preg_replace($reg, '_$1', $key);
		registerError( "users", $key, strtoupper($descName), $value ); 
	}
}


function userRegisterError( $param ) {
	
	switch( $param ) {
		case 'exists':
				header("HTTP/1.0 416 Nickname already in use");
				$message = "The user $_POST[userNickname] is already in use. Please Select another one!!";
				break;
		case 'blogExists':
				header("HTTP/1.0 416 Blog Url registered");
				$message = "The url $_POST[phanetRss] is already in our database.";
				break;
		case 'dontExists':
				header("HTTP/1.0 417 Worng Username or Password");
				$message = "The user $_POST[userNickname] or the Email $_POST[userEmail] doesn't exists!!";
				break;
		case 'emptyField':
				header("HTTP/1.0 418 Empty Fields Found");
				$message = "There cannot be empty fields. Pleas submit all the information!!";
				break;
		case 'regMail':
				$message = "There was an error sending the email.. We'll retry latter.";
				break;
		case 'confirm':
				header("HTTP/1.0 100 Worng Username or Password");
				$message = "There was an error doing the email confirmation. Please check the url,\n".
						   "the Site Admin";
	}
	errorTemplate($message);
}
