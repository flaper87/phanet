<?php
@session_start();

include("core.inc.php");

function admin_actions(){
	return array("admin"=>"admin_adminpanel");
}

function admin_adminpanel($params){
	global $adminCore, $srv;
	
	if (sessionStarted() && isAdmin()) {
		$adminCore->loadAdmin();
	} elseif ( sessionStarted() && !isAdmin() ) {
		header("Location: ". $srv->getInstallRadix());
	} else {
		startSession();
	}
}

function admin_checklogin(){
	if(isset($_SESSION['uid'])){
		global $ptdb;
		$uid=floor($_SESSION['uid']);
		$ptdb->query("SELECT * FROM {users} WHERE id=$uid");
		$userdata=$ptdb->fetchArray();
		return ($userdata['status']==1 && $userdata['type']=='admin');
	}else return false;
}

function admin_login($user,$pass){
	global $_SESSION, $ptdb, $adminCore, $whdg, $srv;
	
	$query = "SELECT id,usertype,email FROM {users} WHERE nickname = '$user' and password = '".md5($pass)."' and status = 'E'";
	$ptdb->query($query);
	
	if (count(( $result = $ptdb->fetchArray() )))
	{
		$_SESSION["userLogged"]		= True;
	    $_SESSION["userNickname"] 	= $user;
	    $_SESSION["userId"] 		= $result[0]['id'];
	    $_SESSION["userEmail"] 		= $result[0]['email'];
	    if ( $result[0]['usertype'] == "A" ) {
	    	$_SESSION['adminLogged'] = True;
			$adminCore->loadAdmin();
		}
		$whdg->writeLog('user', 'User Login', '5', 'userLogin', 'users/main');
	} else {
		loadLogin();
	}
}


function startSession() {
	
	if (isset($_POST['login'])) admin_login($_POST['login_name'], $_POST['login_pass']);
	else loadLogin();
}


function sessionStarted() {
	if ($_SESSION["userLogged"]) return true;
}

function isAdmin() {
	if ($_SESSION['adminLogged']) return true;
}
