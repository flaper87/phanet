<?php 

function show_404() {
	global $srv;
	
	$output[] = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

	$output[] = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">';
	$output[] = '<head>';
	$output[] = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$output[] = '<title>Phanet: Page Not Found!!</title>';
	$output[] = '<link rel="stylesheet" type="text/css" href="'.$srv->getPath("themes/phanet_dark/styles/style.css").'">';
	$output[] = '</head>';

	$output[] = '<body>';
	$output[] = '<div id="site">';
	$output[] = '<div id="content">';
	$output[] = '<div id="posts">';
	$output[] = '<div id="logo"><img src="'.$srv->getPath("media/phaneticon-big.png").'" width="80px"></div>';
	$output[] = '<div class="title"><h1>Phanet</h1>';
	$output[] = '<div class="subtitle">Just a feed agregator</div>';
	$output[] = '</div>';
	$output[] = '<div id="not_found">';
	$output[] = 'The page requested was not Found!!';
	$output[] = '</div>';	
	$output[] = '</div>';
	$output[] = '<div id="site_bottom">(c)2008 - Phanet is under GPLv2</div>';
	$output[] = '</div>';
	$output[] = '</div>';
	$output[] = '</body>';
	$output[] = '</html>';
	
	echo join("\n", $output);
}
