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
 * MODULE MANAGEMENT FUNCTIONS
 */
$MODULES_PATH = "modules/";
$GLOBALS["widgetsPath"] = "modules/widgets/included/";

require_once "include/stgsManager.inc.php";
require_once "include/url.inc.php";
require_once "include/parser.inc.php";
require_once "include/errors.inc.php";
require_once "include/templates.inc.php";
require_once "include/database.inc.php";
require_once "include/loader.inc.php";
require_once "include/watchdog.inc.php";
require_once "include/mail.inc.php";

$core = new phanetCore();

class phanetCore {
	var $stgs;
	var $showing;
	var $adminLoaded;
	var $loadedModules;
	
	function phanetCore() {
		$this->loadPhanet();
	}
	
	private function loadPhanet() {
		global $srv;
		
		$srv->init();
		$srv->applyRules();
		$this->loadModules();
		
	}
	
	/**
	 * isValidModule
	 *
	 * Check if a module is valid
	 *
	 * @param $name The name of the module to check
	 *
	 * @return true if the module is valid.
	 *
	 * @version 0.1
	 */
	function isValidModule($name){
		global $MODULES_PATH;
		$name=str_replace("/","",$name);
		$name=str_replace("\\","",$name);
		return (is_dir("$MODULES_PATH/$name/") && file_exists("$MODULES_PATH/$name/$name.info"));
	}
	
	/**
	 * getModuleList
	 *
	 * Get a list of modules from directory
	 *
	 * @version 0.1
	 */
	function getModuleList() {
		global $MODULES_PATH;
		$modlist=array();
		$fp = opendir($MODULES_PATH);
		while ( $nf = readdir($fp) ){
			if ($nf{0}!='.' && $this->isValidModule($nf)){
				$modlist[]=$nf;
			}
		}
		return $modlist;
	}
	
	/**
	 * loadCoreModules
	 * 
	 * Loads core modules
	 *
	 * @version 0.1
	 */
	function loadCoreModules(){
		global $MODULES_PATH;
		$mlist = $this->getModuleList();
		
		foreach($mlist as $m){
			$mdata = $this->getModuleInfo($m['path']);
			if( $mdata['package'] == 'core.required' && file_exists( "$MODULES_PATH/$m/$m.inc.php" ) ) {
				include_once "$MODULES_PATH/$m/$m.inc.php";
			}
		}
	}
	
	/**
	 * getActiveModules
	 *
	 * Get a list of active modules from database
	 *
	 * @version 0.1
	 */
	function getActiveModules() {
		global $ptdb;
		
		$sql="SELECT * FROM {modules} WHERE enabled = 1 ORDER BY weight";
		
		$ptdb->query($sql);
		$act_mod = $ptdb->fetchArray();
		
		if (!$act_mod) $act_mod = array();
		return $act_mod;
	}

	/**
	 * loadModules
	 *
	 * Loads enabled modules
	 *
	 * Search in the database the enabled modules and include them.
	 *
	 * @version 0.1
	 */
	private function loadModules(){
		global $LOADEDMODULES, $MODULES_PATH;
		
		$mlist = $this->getActiveModules();
		
		foreach($mlist as $mdata){
			$m=$mdata['path'];
			if(file_exists("$MODULES_PATH/$m/main.inc.php")) {
				include_once "$MODULES_PATH/$m/main.inc.php";
				$GLOBALS['LOADEDMODULES'][] = $m;
			}
		}
	}
	
	/**
	 * getModuleInfo
	 *
	 * Get module info
	 *
	 * @param $name The name of the module to check
	 *
	 * @return $moduleinfo An array with the information.
	 * @return false if module was not found.
	 * @version 0.1
	 */
	function getModuleInfo($name){
		global $MODULES_PATH;
		if( $this->isValidModule($name) ) {
			
			$fileinfo   = file("$MODULES_PATH/$name/$name.info");
			$moduleinfo = array();
			
			foreach($fileinfo as $line){
				$data 	 = explode("=",$line,2);
				$data[0] = trim($data[0]);
				$data[1] = trim($data[1]);
				$moduleinfo[strtolower($data[0])]=$data[1];
			}
			
			return $moduleinfo;
		
		}else return false;
	}
	
	/**
	 * callAction
	 *
	 * Loads core modules
	 *
	 * @return False if the action is unknown
	 * @version 0.1
	 */
	function callAction( $action = '' ){
		global $ptdb, $stgs;
		
		if ( $action ) {
			if ( !$stgs->isAction( $action )) manage_error(301);
			if ( $action == "display" ) $this->showing = True;
			if ( $action == "feed" ) $this->showing = True;
			if ( $action == "admin" ) $this->adminLoaded = True;
			$function = getActionFunction( $action );
			$function('');
			return true;
		}
		
		foreach ( $_GET as $action => $param) {
			if ( !$stgs->isAction($action)) continue;
			if ( $action == "display" ) $this->showing = True;
			if ( $action == "feed" ) $this->showing = True;
			if ( $action == "admin" ) $this->adminLoaded = True;	
			$function = getActionFunction( $action );
			$function($param);
		}
	}
	
	/**
	 * string_to_params
	 *
	 * Change a string to an array
	 *
	 * @param $string the string to change
	 *
	 * @return arra The array with the formated string
	 * @version 0.1
	 */
	function string_to_params($string){
		return explode("/",$string);
	}
}
