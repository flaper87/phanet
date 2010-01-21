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
@session_start();

$srv = new serverHandler();	

class serverHandler {
	var $isNS4;
	var $isIIS;
	var $isLynx;
	var $isGecko;
	var $isOpera; 
	var $isMacIE; 
	var $isWinIE;
	var $isApache;
	var $isRewrite;
	var $isJavascript;
	var $installRadix;

	var $reqUri;
	var $reqPath;
	var $permRules = array();
	
	/**
	 * curPageURL
	 *
	 * get full position of the page
	 *
	 * @return the position such as http://127.0.0.1/phanet/xyz.php 
	 *
	 * @version 0.1
	 */ 
	function getCurUrl() {
	    $pageURL = 'http';
	    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	        $pageURL .= "s";
	    }
	    $pageURL .= "://";
	    if ($_SERVER["SERVER_PORT"] != "80") {
	        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];//.$_SERVER["REQUEST_URI"];
	    } else {
	        $pageURL .= $_SERVER["SERVER_NAME"];//.$_SERVER["REQUEST_URI"];
	    }
	
	
	    $pageURL=substr($pageURL ,0, strlen($pageURL )-strlen(substr(strrchr($pageURL , "?"), 1)));
	
	    if (substr($pageURL,-1)=="?") {
	        $pageURL=substr($pageURL,0, -1);
	    }
	 
	    return $pageURL;
	}
	
	/**
	 * This functions create the required rulse for the .htaccess file
	 *
	 */
	function createFilters() {
	
	}
	
	/**
	* getInstallRadix
	*
	* get the URL name where phanet is installed  with /
	*
	* @param $path the path where we are called from
	*
	* @return the directory name where phanet is installed such as http://127.0.0.1/phanet/
	*
	* @version 0.1
	*/
	function getInstallRadix() {
		$phpSelf = $_SERVER['PHP_SELF'];
		$end = preg_replace("%(.*?)index.php%is", "$1", $phpSelf);
		return $this->getCurUrl().$end;
	}

	/**
	* getServerRadix
	*
	* get the directory name where phanet is installed  with /
	*
	* @param $path the path where we are called from
	*
	* @return the directory name where phanet is installed such as /phanet/
	*
	* @version 0.1
	*/
	function getServerRadix($path='') {
	    if ($path=='') {
	        $path=get_page_name();
	    }
	
	    $curURLvar=$_SERVER["REQUEST_URI"];
	    $curURLvar=substr($curURLvar,0, strlen($curURLvar)-strlen(substr(strrchr($curURLvar, "?"), 1)));
	    if (substr($curURLvar,-1)=="?") {
	        $curURLvar=substr($curURLvar,0, -1);
	    }
	 
	    $dir_name=$curURLvar;
	    if ( substr( $curURLvar, strlen($curURLvar) - strlen( $path) ) == $path ) {
	        $dir_name=substr($curURLvar,0, strlen($curURLvar)-strlen($path));
	    }            
	
	    if (substr($dir_name,-1)!="/") {
	            $dir_name=$dir_name."/";
	    }         
	
	    return $dir_name;         
	}
	
	/**
	 * Builds the URL Path of a file
	 *
	 * @param string $path The path to build
	 * @return The path. E.g http://www.example.com/folder/image.png 
	 */
	function getPath( $path ) {
		return $this->getInstallRadix().$path;
	}
	
	/**
	 * Builds the requested url link
	 *
	 * @param string $path the destination path
	 * @param bool $request Should it be build with the previous requested options. e.g: Page number
	 * @return The url string.
	 */
	function buildUrl( $path = '', $depth = 0, $ignoreRewrite = False, $request = False ) {
		global $stgs;
		
		$url = $this->getInstallRadix();
		
		if ( $this->isRewrite && !$ignoreRewrite) {
				
			if (preg_match('%\?(\w+)=($)%is', $path)) return $url.preg_replace('%\?(\w+)=$%is', '$1', $path)."/";	
			
			preg_match_all('%(?<action>\w+)=(?<param>.*?)(&|$)%is', $path, $match);          
			
			$step = 0;
			foreach ( $match[action] as $key=>$value) { 
				if ( !$depth == 0 && $depth == $step ) break;
				$url .= $value."/".$match[param][$key]."/";
				$path = preg_replace('%'.$value.'='.$match[param][$key].'(&|$)(.*?)%is', '$2', $path);
				$step ++;
			}
			
			return ($path == "?")?$url:$url.$path;
			
		} else {
			return $url.$path;
		}
	}

	/**
	 * Let's see if some apache module is enabled.
	 *
	 * @param string $module The module to check. e.g mod_info
	 * @return unknown
	 */
	function isModuleEnabled( $module ) {
		
		if ( !$this->isApache ) return false;
	
		if ( function_exists('apache_get_modules') ) {
			if ( in_array($module, apache_get_modules()) ) return true;
		} else {
			ob_start();
			phpinfo(8);
			$phpinfo = ob_get_clean();
			if (strpos($phpinfo, $module)) return True;
		}
	}
	
	function getRequestedPart() {
		global $stgs;
		
		if ($_GET['showJust']) 
			return ($this->isRewrite)?$_GET['showJust']."/":"?showJust=".$_GET['showJust']."&";
		
		if ($_GET['search'])
			return ($this->isRewrite)?"search/".$_GET['search']."/":"?search=".$_GET['search']."&";
	}
	
	/**
	 * This function intends to apply the rewrite rules
	 * for the permalinks
	 *
	 */
	function applyRules() {
		
		$reqPath = $this->reqPath = str_replace($this->getInstallRadix(), "", $this->reqUri);
		
		unset($_GET['q']);
		if ( $_GET ) $pass = True;
		
		if ( !$reqPath ) return;
		
		foreach ( $this->permRules as $permRule ) {
			if (preg_match("%$permRule/([^/]+)%is", $reqPath)) {
				$_GET[$permRule] = preg_replace("%(.*/?)$permRule/([^/]+)(.*)%is", "$2", $reqPath);
				$reqPath = str_replace( $permRule."/".$_GET[$permRule]."/", "", $reqPath);
			} elseif (preg_match("%$permRule(/|$)%is", $reqPath)) {
				$_GET[$permRule] = true;
				$reqPath = str_replace( $permRule."/", "", $reqPath);
			}
		}
		
		($reqPath = "/")?$reqPath="":pass;
		if ( $reqPath != "" && !preg_match( "%(?)\w=(.*?)%is", $reqPath) && $_GET['user'] != "confirm" ) manage_error(404);
	}
	
	/**
	 * This function is to register some new permRules in case a plugin use URLs
	 * 
	 * @param string||array $rules
	 */
	 function addPermRule( $rules ) {
	    if ( is_array($rules) ) {
	    	foreach ( $rules as $permRule ) {
	    		if ( in_array( $permRule, $this->permRules ) ) return false;
	    		array_push($this->permRules, $permRule);
	    	}
	    } else {
	    	if ( in_array( $rules ) ) return false;
	    	arary_push( $this->permRules, $rules );
	    }
	}

	/**
	 * This function help us to poppulate the variables used.
	 *
	 */
	private function popVars() {
		global $stgs;
		//Thanks Wordpress....
		
		//To know if we are working with Apache
		$this->isApache = ((strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) ||	
						   (strpos($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false)) ? true : false;
							
		$this->isIIS    = (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) ? true : false;

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Lynx') !== false) {
			$this->isLynx  = true;
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Gecko') !== false) {
			$this->isGecko = true;
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false && 
				  strpos($_SERVER['HTTP_USER_AGENT'], 'Win') !== false) {
			$this->isWinIE = true;
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false && 	
				  strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false) {
			$this->isMacIE = true;
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
			$this->isOpera = true;
		} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Nav') !== false && 
				  strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla/4.') !== false) {
			$this->isNS4   = true;
		}
		
		$this->is_IE = ( $this->isMacIE || $this->isWinIE );
		
		//$_SESSION['isJavascript'] = $_POST['isJavascript']; 
		
		$this->isRewrite = ($stgs->getConf('rewrite_url') == "enabled" && $this->isModuleEnabled('mod_rewrite'))?True:False;
		
		$this->reqUri = $this->getCurUrl().$_SERVER['REQUEST_URI'];
		
		$this->addPermRule( array_merge(getActions(), array('category','tag', 'page', 'advanceSearch', 'static')) );
	}
	
	function init() {
		global $stgs, $mailer;
		
		$stgs->loadSettings();
		$mailer->loadSmtp();
		$this->popVars();
	}
}

/**
 * checkPart
 *
 * Checks the a part of the request_uri
 *
 * Checks if the current part belongs to an action or a theme.
 *
 * @param $uri The part of the uri to be checked.
 *
 * @version 0.1
 */
function checkPart( $uri ) {

	$uri = decodeUrlPiece($uri);
	$actions = getActions();
	$themes = getThemes();
	$tags = getTags();

	if ( deepArraySearch( $uri, $actions) ) return array("action","a");
	elseif ( deepArraySearch( $uri, $themes) ) return array("theme","a");
	elseif ( $uri == "category" ) return array("categories","showJust");
	elseif ( $uri == "tag" ) return array("tags","showJust");
	elseif ( $uri == "page" ) return array("page","page");
	elseif ( $uri == "search" ) return array("search","search");
}


function deepArraySearch($needle, $haystack){
	foreach ($haystack as $key => $value) {
		if (is_array($value)){   
			if (deepArraySearch($needle, $value)) return True;
		} elseif ($value === $needle) {
			return True;
		}
	}
}
