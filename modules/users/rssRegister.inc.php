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

/**
*Functions for urm discovering
*/

function rssRegister() {
	global $core, $mTpr, $srv;
	
	if (!$_POST['phanetTitle'] || !$_POST['phanetDesc'] || !$_POST['phanetRss'] || !$_POST['phanetFull'] || !$_POST['phanetNick'] || !$_POST['phanetEmail'] || !$_POST['phanetUrl'] ) {
		$_SESSION["rssRegisterError"] = 'All fields required!!';
	} elseif (!$_POST['phanetRss'] || !checkFeed($_POST['phanetRss'])) {
		$_SESSION["rssRegisterError"] = 'Wrong Feed: ' .$_POST['phanetRss'] . '<br>Please Try Again!';
	} else {
		doRegisterFeed();
	}
}

function singlePostRead() {
	if (!$_POST['postFeed']) {
		$_SESSION["singlePostError"] = 'All fields required!!';
	}
}

function doRegisterFeed() {
	global $srv, $ptdb, $stgs, $mailer, $admldr;
	
	if (checkIfBlogExists()) {
		manage_error('blogExists');
	} else {		
		
		$ownerID = getOwnerId();

		$query = "INSERT INTO {blogs} (name,description,url, feed_url, state, owner_id) 
						VALUES ('".$_POST['phanetTitle']."','".$_POST['phanetDesc']."',
						'".$_POST['phanetUrl']."', '".$_POST['phanetRss']."', 'pending', '".$ownerID."')";
		
		$ptdb->query($query);
		
	    $num = $ptdb->affectedRows();
	
	    if ($num>0) {
			
	        $mailer->send( array (
							'From' 		=> $stgs->getConf("smtp_sender"),
							'To' 		=> $_POST['phanetEmail'],
							'Subject' 	=> "Your blog submission to ".$stgs->getConf("sitename")." has been received",
							'body'		=> emailToUser( $_POST[phanetFull], $_POST['phanetUrl']),
	        					) 
			        	);
			
			foreach ($admldr->getAdmins() as $admin) {
				
				$mailer->send( array (
								'From' 		=> $stgs->getConf("smtp_sender"),
								'To' 		=> $admin["email"],
								'Subject' 	=> "A new blog registration is awaiting approval!",
								'body'		=> emailToAdmin() ,
									) 
							);
			}
		}
		
		$_SESSION["logMessage"] = "Hey Feeding friend!!<br /><br />".
									"Your Registration is waiting for moderation.<br />".
									"Thanks for Feeding!!";
	}
		
}

function checkIfBlogExists() {
	global $srv, $ptdb;

	$query = "SELECT * FROM {blogs} where url='".fixApostrofe($_POST['phanetRss'])."';";
			
	$ptdb->query($query);
	$list=$ptdb->fetchArray();

	if ( count($list) ) return True;
	else return False;
}

function getOwnerId() {
	global $srv, $ptdb;

/*
	$query = "SELECT * FROM {owners} where email='".fixApostrofe($_POST['phanetEmail'])."';";
			
	$ptdb->query($query);
	$list=$ptdb->fetchArray();

	if ( count($list) ) {
		return $list[0]["id"];
	} else {
*/
		$query = "INSERT INTO {owners} (nickname, fullname, email) 
							VALUES ('$_POST[phanetNick]', '$_POST[phanetFull]', '$_POST[phanetEmail]')";	
		$ptdb->query($query);
			
		if (count($ptdb->affectedRows()) != 0) return mysql_insert_id();
	//}
}


function emailToAdmin() {
	global $srv, $stgs;
	

	$message  = "\nA new blog registration is awaiting approval.";

	$message  .=  "\n\nDetails:";
	$message  .=  "\n\nBlog Name: " . $_POST["phanetTitle"];
	$message  .=  "\nBlog Url: " . $_POST["phanetUrl"];

	$message  .= "\n\nTo approve please go to " . $srv->buildUrl("?admin=");

	$message  .= "\n\n".$stgs->getConf("sitename");
	
	return $message;
}

function emailToUser( $fullname, $url) {
	global $srv, $stgs;  

	$message  = "\nDear ".$fullname.",";

	$message  .= "\n\nWe have received your request to add ".$url." to the ".$stgs->getConf("sitename")." aggregator.";
	$message  .= "\n\nApproval to add your site is subject to administrative review.  We will";
	$message  .= "review and process this request as soon as is humanly possible.";

	$message  .= "\n\nThank you,";
	$message  .= "\nThe ".$stgs->getConf("sitename")." Team";

	return $message;
}
