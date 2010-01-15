<?php 

@session_start();

function loadLogin() {
	loginHeader();
	loginBody();
}


function loginHeader() {
	global $srv;
	
	$output .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
	
	$output .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">";
	$output .= "<head>";
	$output .= "<title>Phanet: Admin</title>";
	
	$output .= "<link rel=\"stylesheet\" href=\"".$srv->getPath('/modules/admin/styles/admin-style.css')."\" type=\"text/css\" media=\"screen, projector\" />";
	
	
	$output .= "</head>";
	$output .= "<body>";
	echo $output;
}


function loginBody($body='login'){
	global $srv, $stgs;
	
	$output .= "<form action=\"".$srv->reqUri."\" method=\"post\">";
	$output .= "<div id=\"login\">";
	$output .= "<a href=\"".$srv->getInstallRadix()."\">";
	$output .= "<img src=\"".$srv->getPath('media/phaneticon-big.png')."\" id=\"logo\">";
	$output .= "<h2>".$stgs->getConf('sitename')."</h2>";
	$output .= "</a>";
	$output .= "<h3>".$stgs->getConf('sitedescription')."</h3>";
	$output .= "<p>Username: </p>";
	$output .= "<p><input type=\"text\" id=\"login_name\" name=\"login_name\" size=\"30\"></p>";		
	$output .= "<p>Password: </p>";
	$output .= "<p><input type=\"password\" id=\"login_pass\" name=\"login_pass\" size=\"30\"></p>";
	$output .= "<p><a href=\"".$srv->buildUrl('?user=lostpass')."\">Lost your password?</a></p>";
	$output .= "<p><input type=\"submit\" name=\"login\" value=\"Login\"></p>";  
					
	$output .= "</div>";
	$output .= "</form>";
	$output .= "</body>";
	$output .= "</html>";
	echo $output;

}
