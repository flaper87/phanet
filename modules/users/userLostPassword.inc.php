<?php

function generatePassword($length) {
	$chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$i = 0;
	$password = "";
	while ($i <= $length) {
		$password .= $chars{mt_rand(0,strlen($chars))};
		$i++;
	}
	return $password;
}

function lostPassword() {
	global $core, $mTpr;
	
	if (isset($_POST['userEmail']) && isset($_POST['userNickname'])) {
		execGeneration();
	} else {
		$mTpr->lostPaswordTheme();
	}
}

function isRealUser() {
	global $ptdb;

	$query = "SELECT * FROM {users} where nickname='".fixApostrofe($_POST[userNickname]).
									  "' AND email='".fixApostrofe($_POST[userEmail])."'";
			
	$ptdb->query($query);
	$list = $ptdb->fetchArray();

	if ( !count($list) > 0) return False;
	
	return True;
}

function execGeneration() {
	global $ptdb, $stgs;
	
	if ( !$_POST["userNickname"] || !$_POST["userEmail"] ) {
		manage_error('emptyField');
	} elseif ( !isRealUser() ) {
		manage_error("userDontExists");
	} else {
	    $password = generatePassword(8);
	
	    $query ="UPDATE {users} SET password='".md5($password)."' WHERE nickname='".fixApostrofe($_POST["userNickname"])."'";					
	    $ptdb->query($query);
	
	    $num = $ptdb->affectedRows();
	
	    if ( $num > 0 ) {
	        
	        $result = $mailer->send( array (
							'From' 		=> $stgs->getConf("smtp_sender"),
							'To' 		=> $_POST["userEmail"],
							'Subject' 	=> "Confirm subscription",
							'body'		=> lostPasswordBody($password),
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

function lostPasswordBody( $password ) {
	global $stgs;
	
	$message  = "Hi!!\n";
	$message .= "\nIt seems that you forgot your password, ".
				"well that's not a problem here's a new one just for you.\n";
	$message .= "\n\nYou're new password is: $password";
	$message .= "\n\nSee you, and Happy Feed Reading!!!";
	$message .= "\n\n--\n";
	$message .= "The Happy ".$stgs->getConf("sitename")." Team.";
	
	return $message;
}
