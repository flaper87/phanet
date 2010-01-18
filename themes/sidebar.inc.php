<?php

session_start();

function showThemeSidebar() {
	global $wgts, $srv, $stgs, $SESSION, $activetheme;
	
		$output[] = require_once($activetheme.'/sidebar.php');
	echo join("\n", $output);
	
}

