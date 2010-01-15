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
 * 
 * Internal Errors Array
 *
 * Contains all the internal handled errors ordered by numbers like this:
 * [101-200] Database Errors,
 * [201-300] Warnings,
 * [301-400] Actions Errors,
 * [401-501] Headers Errors
 */
$int_errors = array(

		101 => "E_DATABASE_URL",
		102 => "E_DATABASE_NAME",
		103 => "E_DATABASE_QUERY",
		
		201 => "WARNING",
		
		301 => "E_UNKNOWN_ACTION",
		302 => "E_REGISTER_ERROR",
		303 => "E_THEME",
		
		404 => "NOT_FOUND",
		
		1000 => "SMTP_ERROR"
		);

/**
 *
 * Errors Action Array
 *
 * Contains all the functions to call for the handled errors.
 *
 */
$err_actions = array( 
		"E_DATABASE_URL"   => "database_error/url",
		"E_DATABASE_NAME"  => "database_error/dbname",
		"E_DATABASE_QUERY" => "database_error/query",
		"WARNING"          => "warnings",
		"E_UNKNOWN_ACTION" => "default_error/action",
		"E_REGISTER_ERROR" => "default_error/register",
		"NOT_FOUND"        => "not_found",
		"E_THEME"          => "default_error/theme",
		"SMTP_ERROR"	   => "smtp_error"
		);

/**
 *
 * Array Containing not internal errors like plugins erros, themes errors.... 
 * The errors must be registered first.
 *
 */		
$ext_errors = array();

/**
 * manage_error
 *
 * Manages all the errors.
 *
 * @param $num The number identifier of the error.
 */
function manage_error($err) {
	global 	$int_errors, $ext_errors, $err_actions;
	
	if ($int_errors[$err]) {
		list($function, $param) = explode("/",$err_actions[$int_errors[$err]]);
		$function($param);
	} else {
		foreach ( $ext_errors as $modErrors) {
			if ( $modErrors[$err] ) {
				list($function, $param) = explode("/", $err_actions[$modErrors[$err]]);
				$function($param);
			}
		}
	}
} 

function registerError($mod, $errName, $descName, $action) {
	global $int_errors, $ext_errors, $err_actions;
	
	if ( $ext_errors[$mod][$errName] ) {
		echo "Error Exists";
	} else {
		$ext_errors[$mod][$errName]	 = $descName;
		$err_actions[$descName] 	 = $action;
	}
}

function not_found() {
	global $srv, $mTpr, $whdg;

	$_GET['404'] = True;
	$whdg->writeLog('404', 'Page '.$srv->reqPath.' Not Found', '4', 'not_found', 'included/errors');
	$mTpr->launch404();
}

function smtp_error() {
	global $srv, $mTpr, $whdg;
	
	header("HTTP/1.0 419 Smtp Error");
	$whdg->writeLog('1000', 'Impossible to send Email '.$srv->reqPath, '4', 'smtp_error', 'included/errors');
}

function default_error($type) {
	global $_GET;
	
	switch ($type) {
		case "action":
			$message  = "<br><br>";
			$message .= "The action <code>".$_GET['a']."</code> doesn&#8217;t exist, please check";
			$message .= "your syntax or select another action.";
			$whdg->writeLog('actions', 'Unknown Action', '4', 'default_error', 'included/errors');
			break;
		case "register":
			$message  = "There was an error registering an error handler";
			$message .= "<br></br>The right syntax to register an error is register_error(num, name, action)";
			$whdg->writeLog('actions', 'Error-Handler register error', '4', 'default_error', 'included/errors');
			break;
		case "theme":
			$message  = "There was an error while loading the theme, the possible options are:";
			$message .=	"<ul>";
			$message .= "<li> The theme doesn&#8217;t exists. </li>";
			$message .= "<li> There is an error in the theme code. </li>";
			$message .=	"</ul>";
			$whdg->writeLog('actions', 'Load Theme Error', '4', 'default_error', 'included/errors');
	}
	errorTemplate($message);
}

function database_error($type) {
	global $ptdb, $stgs, $whdg, $srv;

	switch ($type) {
		case "url":
			$message  = "There were problems with the database connection, please check the information of your "; 
			$message .= "<code>settings.inc.php</code> file."; 
			$message .= "<ul>";
			$message .=	"<li> Make sure your username and your password are right.</li>";
			$message .= "<li> Make sure your hostname is right. The hostname i attempted to contact is ";
			$message .= "<code>".$stgs->getConf('db_server')."</code></li>";
			$message .= "<li> Make sure your database server is running</li>";
			$message .= "<li> Make sure Phanet has been installed Correctly. <a href=\"".$srv->getInstallRadix()."?a=install\">Re-Install</a></li>";
			$message .= "</ul>";
			break;
			
		case "dbname":
			$message  = "I was unable to select the database so:";
			$message .=	"<ul>";
			$message .= "<li> Make sure this is your database name: <code>".$stgs->getConf('db_database')."</code> </li>";
			$message .= "<li> Make sure Phanet has been installed Correctly. <a href=\"".$srv->getInstallRadix()."?a=install\">Re-Install</a></li>";
			$message .=	"</ul>";
			$message .=	"Your username and password are right so don&#8217;t modify them.";
			break;
		case "query":
			$message  = "There was an error while executing the query: ".mysql_error($ptdb->dbcon);
			break;
		}
		
		errorTemplate($message);
}
