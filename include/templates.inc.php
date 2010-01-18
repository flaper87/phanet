<?php

$mTpr = new mainTpter();

class mainTpter {
	
	var $theme;
	
	function mainTpter() {
		
	}
	
	function loadTheme() {
		global $ptdb, $stgs;
		
		$theme = $stgs->getConf('active_theme');
		
		$this->theme = (object) array( "name" => $theme, "path" => getThemePath($theme));;
	}
	
	/**
	 * launchTheme()
	 *
	 * launch selected theme
	 *
	 * @param $name The name of the theme, if $name='' the default theme will be used.
	 *
	 * @return true if succed
	 * @return false if any problem
	 * @version 0.1
	 */
	function launchTheme( $name='' ) {
		
		if(file_exists("themes/theme.inc.php")){
			include "themes/theme.inc.php";
	
			if(function_exists("themeRender")) {
				themeRender();
				return true;
			}else{
				manage_error(303);
				return false;
			}
		}else{
			manage_error(303);
			return false;
		}
	}
	
	function userRegisterTheme() {
		global $srv, $stgs;
		
			$output[] = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";

			$output[] = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">";
			$output[] = "<head>";
				$output[] = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
				$output[] = "<title>Phanet: Error</title>";
				$output[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$srv->getPath('modules/admin/styles/admin-style.css')."\">";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/jquery.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/plugins/jquery.form.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/plugins/jquery.validate.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script type=\"text/javascript\" src=\"".$srv->getPath('media/js/thickbox/thickbox.js')."\"></script>";
				$output[] = "<script src=\"".$srv->getPath('modules/users/js/users.js')."\" type=\"text/javascript\"></script>";
			$output[] = "</head>";
		
			$output[] = "<body>";
		
	        $output[] = "<form  id=\"registerForm\" action=\"".$srv->buildUrl('?user=register')."\" method=\"post\">";
	        	$output[] = "<div style=\"height: 400px !important; width: 700px !important;\" id=\"login\">";
	        	$output[] = '<div style="padding-left: 50px; list-style-type: none; color: red; height: 30px; float:right; padding-right: 150px;" id="errorsBox"></div>';
				$output[] = "<div style=\"float:right; padding-right: 150px;\" id=\"loading\"></div>";
				$output[] = "<a href=\"".$srv->getInstallRadix()."\">";
				$output[] = "<img src=\"".$srv->getPath('media/phaneticon-big.png')."\" id=\"logo\">";
				$output[] = "<h2>".$stgs->getConf('sitename')."</h2></a>";
				$output[] = "<h3>".$stgs->getConf('sitedescription')."</h3><br />";
	            $output[] = "<div style=\"float:left;\"><p>Nickname: </p> <p><input class=\"required\" type=\"text\" title=\"Your Nickname, please!\" name=\"userNickname\"></p></div>";
	            $output[] = "<div style=\"float:left;\"><p>Password: </p> <p><input class=\"required\" type=\"password\" title=\"Your Password, please!\" name=\"userPass\"></p></div>";
	            $output[] = "<div style=\"float:left;\"><p>FullName: </p> <p><input class=\"required\" type=\"text\" title=\"Your Full name, please!\" name=\"userFullName\"></p></div>";
	            $output[] = "<div style=\"float:left;\"><p>Email: </p> <p><input class=\"required\" type=\"text\" title=\"Your Email, please!\" name=\"userEmail\"></p></div>";
	            $output[] = "<div style=\"float:left;\"><p>Website: </p> <p><input class=\"required\" type=\"text\" name=\"userWebsite\"></p></div><br />";
	            $output[] = "<div style=\"float:left;\"><p><input type=\"submit\" value=\"Create New Account\" name=\"registerUser\"></p></div>";
	            $output[] = "</div>";
	        $output[] = "</form>";
	       
	        $output[] = "</body>";
	        $output[] = "</html>";
		echo join( "\n", $output);
		die();
	}

	function lostPaswordTheme() {
		global $srv, $stgs;
			
			$output[] = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";

			$output[] = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">";
			$output[] = "<head>";
				$output[] = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
				$output[] = "<title>Phanet: Error</title>";
				$output[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$srv->getPath('modules/admin/styles/admin-style.css')."\">";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/jquery.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/plugins/jquery.form.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script src=\"".$srv->getPath('media/js/jquery/plugins/jquery.validate.js')."\" type=\"text/javascript\"></script>";
				$output[] = "<script type=\"text/javascript\" src=\"".$srv->getPath('media/js/thickbox/thickbox.js')."\"></script>";
				$output[] = "<script src=\"".$srv->getPath('modules/users/js/users.js')."\" type=\"text/javascript\"></script>";
		
			$output[] = "</head>";
		
			$output[] = "<body>";
		
	        $output[] = "<form id=\"lostPassForm\" action=\"".$srv->buildUrl("?user=lostpass")."\" method=\"post\">";
	        	$output[] = "<div style=\"height: 310px !important;\" id=\"login\">";
				$output[] = "<a href=\"".$srv->getInstallRadix()."\">";
				$output[] = "<img src=\"".$srv->getPath('media/phaneticon-big.png')."\" id=\"logo\">";
				$output[] = "<h2>".$stgs->getConf('sitename')."</h2></a>";
				$output[] = "<h3>".$stgs->getConf('sitedescription')."</h3><br />";
				$output[] = "<div style=\"padding-left: 150px;\" id=\"loading\"></div>";
				$output[] = '<div style="padding-left: 50px; list-style-type: none; color: red; height: 30px;" id="errorsBox"></div>';
	            $output[] = "<p>Nickname: </p> <p><input class=\"required\" type=\"text\" title=\"Your Nickname, please!\" name=\"userNickname\"></p>";
	            $output[] = "<p>Email: </p> <p><input class=\"required\" type=\"text\" title=\"Your Email, please!\" name=\"userEmail\"></p>";
	            $output[] = "<p><input type=\"submit\" value=\"Re-Generate Password\" name=\"regenPassword\"></p>";
	            $output[] = "</div>";
	        $output[] = "</form>";;

	        $output[] = "</body>";
	        $output[] = "</html>";
		echo join( "\n", $output);
		die();
	}
	
	function launch404() {
		require_once("themes/".$this->theme->path.'/404.inc.php');
	 	show_404();
	 	die();
	}
}
	
function errorTemplate($message) {
	global $srv;
	
	$output = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";

	$output .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">";
	$output .= "<head>";
	$output .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
	$output .= "<title>Phanet: Error</title>";
	$output .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$srv->getPath('modules/admin/errors.css')."\">";
	$output .= "</head>";

	$output .= "<body>";
	$output .= "<div id='page'>";
	$output .= "<div id='head'>";
	$output .= "<div id='logo'><img src=\"".$srv->getPath('media/phaneticon-big.png')."\" width=80px></div>";
	$output .= "<div id='title'><h1>Phanet</h1>";
	$output .= "<div class='subtitle'>Just a feed agregator</div>";
	$output .= "</div>";
	$output .= "</div>";
	$output .= "<div id='pagetitle'>Error</div>";
	$output .= "<div id='posts'>";
	$output .= $message;
	$output .= "</div>";
	$output .= "<div id='footer'>(c)2008 - Phanet is under GPLv2</div>";
	$output .= "</div>";
	$output .= "</body>";
	$output .= "</html>";
	
	echo $output;
	die();
}

