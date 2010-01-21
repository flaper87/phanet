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
?>
<?php
// Why should this file be short?
// Let's do it kind of usefull instead.


// Start a session in none present
session_start();

// ***********************
// Checking for existance of
// setting file: settings.inc.php
// if it doesn't exist, redirect to install process
// otherwise we are free to go
// ***********************
if (! file_exists("settings.inc.php") || isset($_POST["installButton"]) || (isset($_GET['a']) && $_GET["a"] == "install") ) {
	include_once ("modules/install/install.php");
	doInstall();
	die();
} 

include "settings.inc.php";
require_once "include/core.inc.php";

$core->callAction();

if ( !$core->showing && !$core->adminLoaded ) $core->callAction("display");
?>
