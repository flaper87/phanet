<?php

session_start();

global $srv;

include_once ("userRegister.inc.php");
include_once ("rssRegister.inc.php");
include_once ("userLostPassword.inc.php");
include_once ("userErrorHandler.inc.php");

$srv->addPermRule( array( 'nick', 'pass' ) );

function loadUser($params){
	global $core;
	
	if ( userSessionStarted() ) {
		loadUserSettings();
	}
	
	processUserParams();
	$core->callAction('display');
}

function userLogin($user,$pass){
	global $ptdb, $whdg;
	
	$query = "SELECT id,usertype,email FROM {users} WHERE nickname = '$user' and password = '".md5($pass)."' and status = 'E'";
	$ptdb->query($query);

	if (count(( $result = $ptdb->fetchArray() ))) {
		$_SESSION["userLogged"]		= True;
	    $_SESSION["userNickname"] 	= $_POST[phanetUser];
	    $_SESSION["userId"] 		= $result[0]['id'];
	    $_SESSION["userEmail"] 		= $result[0]['email'];
	    if ( $result[0]['usertype'] == "A" ) $_SESSION['adminLogged'] = True;
	    $whdg->writeLog('user', 'User Login', '5', 'userLogin', 'users/main');
	} else {
		$_SESSION["loginMessage"] = "Wrong User and/or Password!!";
		$whdg->writeLog('user', 'User Login Error', '5', 'userLogin', 'users/main');
	}
}


function userStartSession() {
	global $srv;
	if (isset($_POST['phanetUserlogin'])) userLogin($_POST['phanetUser'], $_POST['phanetUserPass']);
}


function userSessionStarted() {
	global $_SESSION;
	if ($_SESSION['userLogged']) return true;
}


function logOut(){
	global $srv, $whdg;
	
	$whdg->writeLog('user', 'User Log Out', '5', 'logOut', 'users/main');
	
	$_SESSION['userId'] 	  = "";
	$_SESSION['userLogged']	  = "";
	$_SESSION['adminLogged']  = "";
	$_SESSION['userNickname'] = "";
	
	header("Location: ".$srv->getInstallRadix());
}

function processUserParams() {
	global $userAction;
	
	$function = getUserAction($_GET['user']);

	if (function_exists($function)) {
		$function();
	} else {
		manage_error(404);
	}
}

function loadUserSettings() {
}

function getUserAction( $action ) {
	$userActions = array(
				"register"  => "userRegister",
				"confirm"   => "doConfirmUser",
				"logout"    => "logOut",
				"login"	    => "userStartSession",
				"lostpass"  => "lostPassword",
				"addRss"		=> "rssRegister",
				);

	return $userActions[$action];
}
