<?php 

function show_404() {
	global $srv, $activetheme, $stgs;
	
	$output[] = require($activetheme.'/404.php');
	
	echo $output[1];
}
