<?php
/*
 * Created on 26/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$whdg = new watchDog();

class watchDog {

	function writeLog( $type, $message, $severity, $function, $file ) {
		global $srv, $core, $ptdb;
		
		$uid = ( $_SESSION["userId"] && $_SESSION["userLogged"])?$_SESSION["userId"]:0;
		
		$query = "INSERT INTO {watchdog} (uid, type, message, severity, function, file, link, timestamp) " .
		"VALUES ('$uid', '$type', '$message', '$severity', '$function', '$file', '$srv->reqUri', '".time()."')";
		
		$ptdb->query( $query );
	}
	
	function watchDog() {
	}
}
