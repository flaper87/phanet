<?php

function do_login(){
	get_admin_user();
	
	$login_error="";
	
	if (!($login_name = $_POST[login_name]) != NULL || !($login_pass = $_POST[login_pass]) != NULL){
		$GLOBALS[login_error] = '<div id="login_error">';
		$GLOBALS[login_error] .= '<p>ERROR: </p>';
		$GLOBALS[login_error] .= '<p>All fields required</p>';
		$GLOBALS[login_error] .= '</div>';
	} elseif (!$login_name == admin_nickname() || !md5($login_pass) == admin_password()) {
		$GLOBALS[login_error] = '<div id="login_error">';
		$GLOBALS[login_error] .= '<p>The username or password is wrong. </p>';
		$GLOBALS[login_error] .= '<p>Please Try again.</p>';
		$GLOBALS[login_error] .= '</div>';
	} else {
		
		$_GET['sid'] = generate_id($login_name, $login_password);
	}
	
}

function generate_id($login_name, $login_password) {
	  return md5($login_name.$login_password);
}


function start_session($session_id) {

	if ($session_id != NULL && $session_id != "" && strlen($session_id) > 25){
		session_start();
		return True;
	} else {
		return false;
	}
}

?>
