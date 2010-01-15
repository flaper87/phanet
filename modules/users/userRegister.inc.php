<?php
/**
* Written by Flavio Percoco Premoli, started January 2008.
*            Samuele Santi
*            Francesco Angelo Brisa
*
* Copyright (C) 2008 Flavio Percoco Premoli - http://www.flaper87.org
*
* This file is part of Phanet.
*
* Phanet is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* (at your option) any later version.
*
* Foobar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?><?php
/**
 * PHP Template.
 */

// Start a session in none present
session_start();

/**
*Functions for urm discovering
*/

define ('_MODE_','standard');

function userRegister() {
	global $core, $mTpr;
	
	if (!isset($_POST['userNickname'])) {
		$mTpr->userRegisterTheme();
	} elseif (isset($_POST['userNickname'])) {
		doRegisterUser();
	}
}

function doRegisterUser() {
	global $srv, $ptdb, $stgs, $mailer;
	
	if (checkIfUserExists()) {
		manage_error('userExists');
	} elseif (!$_POST['userNickname'] || !$_POST['userPass'] || !$_POST['userFullName'] 
									  || !$_POST['userEmail'] || !$_POST['userWebsite']) {
		manage_error('emptyField');
	} else {
		$query = "INSERT INTO {users} (nickname, password, fullname, email, website,status, usertype) " .
	             "VALUES ( '".fixApostrofe($_POST["userNickname"])."', '".md5($_POST["userPass"])."', '".
				 fixApostrofe($_POST["userFullName"])."', '".fixApostrofe($_POST["userEmail"])."', '".
				 fixApostrofe($_POST["userWebsite"])."','M', 'U')";
				
	    $ptdb->query($query);
	    $num = $ptdb->affectedRows();
	
	    if ($num>0) {
	        // at least one record created, sending email
	        
	        $result = $mailer->send( array (
							'From' 		=> $stgs->getConf("smtp_sender"),
							'To' 		=> $_POST["userEmail"],
							'Subject' 	=> "Confirm subscription",
							'body'		=> confirmationBody(),
	        					) 
			        	);

			if (!$result) {
				manage_error('registerMail');
			}
	        
		}
		
		$_SESSION["logMessage"] = "Hey Feeding friend!!<br /><br />".
								  "An email has been sent to you.<br />".
								  "Please check your inbox.";
	}
		
}

function checkIfUserExists() {
	global $srv, $ptdb;

	$query = "SELECT * FROM {users} where nickname='".fixApostrofe($_POST['userNickname'])."';";
			
	$ptdb->query($query);
	$list=$ptdb->fetchArray();

	if ( count($list) ) return True;
	else return False;
}

function doConfirmUser() {
	global $srv, $ptdb, $core;
	
	if ( !$_GET['nick'] && !$_GET['pass']) {
		$user = preg_replace("#.*confirm/nick/([^/]+)(.*)#", "$1", $srv->reqUri);
		$pass = preg_replace("#.*confirm/.*pass/(.*?)[\/$]#", "$1", $srv->reqUri);
	} else {
		$user = $_GET['nick'];
		$pass = $_GET['pass'];
	}
	
	$query = "UPDATE {users} SET status='E' where nickname='".fixApostrofe($user)."' AND password='".fixApostrofe($pass)."' AND status='M'";		
	$ptdb->query($query);
	
	if ($ptdb->affectedRows() == 0) {
		manage_error("userConfirm");
	}
	
	$_SESSION["logMessage"] = "Hey Feeding friend!!!<br /><br />".
						  "Your e-mail has been confirmed. Now<br />".
						  "you can start enjoing.<br /><br />".
						  "<b>Happy feeding!!!</b>";
	
	$core->callAction('display');
}


function confirmationBody() {
	global $srv, $stgs;
	
	$message  = "Hello $_POST[FullName]\n";
	$message .= "\nThis is a confirmation e-mail sent from ".$srv->getInstallRadix().
				"\n\nIn order to complete your subscription you have to confirm this e-mail by clicking the link".
				"showed bellow.\n\n";
	$message .= "\t".$srv->buildUrl("?user=confirm&nick=$_POST[userNickname]&pass=".md5($_POST["userPass"]))."";
	$message .= "\n\nIf you haven't ask for this subscription then just forget this mail";
	$message .= "\n\n--\n";
	$message .= "The Happy ".$stgs->getConf('sitename')." Team.";
	
	return $message;
}
