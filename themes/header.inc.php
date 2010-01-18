<?php
global $ptdb, $activetheme;

$sql = "SELECT * FROM {settings} WHERE `keyid` = 'active_theme'";

$ptdb->query($sql); $theme = $ptdb->fetchArray(); $activetheme = $theme[0][1];

function loadThemeHeader() {
	global $srv,$stgs,$activetheme;
	$output[] = require($activetheme.'/header.php');
}
