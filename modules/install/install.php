<?php
/**
* Written by Flavio Percoco Premoli, started January 2008.
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


define ('_MODE_','installer');
?> 
<?php

@session_start();

/**
*Functions for database management (needed to create tables)
*/

require_once ("coretables.inc.php");
require_once ("include/parser.inc.php");
require_once ("include/errors.inc.php");
require_once ("include/templates.inc.php");
include_once ("installSteps.inc.php");
include_once ("include/url.inc.php");

if (checkIfSettings()) {
	include_once ("settings.inc.php");
	require_once ("include/stgsManager.inc.php");
	require_once ("include/database.inc.php");
    require_once ("include/db-helpers.inc.php");
    require_once ("include/watchdog.inc.php");
}

function doInstall() {
	
	switch ($_POST["installButton"]) {
		case "Start Install":
			showDataForm();
			break;
		case "Save Settings":
			saveSettings();
			break;
		case "Create Tables":
			showCreation();
			break;
		default:
			showInstallWellcome();
	}
}


function installTemplate( $message, $step ) {
	global $srv;
	
	$output = "<html>";
    	$output .= "<head>";
        	$output .= "<title>Phanet 1.0 installer</title>";
        	$output .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"modules/install/style.css\">";
    	$output .= "</head>";
    
    	$output .= "<body>";    
        	$output .= "<div id=\"menu\">";
            	$output .= "<div class=\"title\">";
                	$output .= "<h1><a href=\"\">Phanet</a></h1>";
                	$output .= "<div class=\"description\"> Just an aggregator of rss feeds..</div>";
            	$output .= "</div>";
        	
            	$output .= "</div>";//Menu div
        	
			$output .= "<div id=\"site\">";
    			$output .= "<div id=\"content\">";
	       			$output .= "<h2 class=\"pagetitle\">Installer $step/4</h2>";		
        			$output .= "<div id=\"posts\">";

        			$output .= "<div class=\"single_post\">";
        				$output .= "<form method=\"post\" action=\"".$srv->getInstallRadix()."\">";
							$output .= $message;
            			$output .= "</form>";
            		$output .= "</div>";//single post
        			$output .= "</div>";//posts
		
            		$output .= "<div id=\"site_bottom\"><span class=\"footnote\">(c)2008 - Phanet is under GPLv2</span></div>";
         		$output .= "</div>";//content
            $output .= "</div>"; //site       
   		 $output .= "</body>";    
	$output .= "</html>";
	
	echo $output;
}

function checkIfSettings() {
	if ( !file_exists("settings.inc.php")) return False;
	
	return True; 
}