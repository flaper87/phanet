<?php 

function show_404() {
	global $srv;
	
	$output[] = require($activetheme.'/404.php');
	
	echo join("\n", $output);
}
