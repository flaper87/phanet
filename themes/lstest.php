<?php // This file is not dynamic. It looks for a table on localhost called phanet wherein the theme table is called ph1_themes. Working with db settings to make it dynamic
require('../settings.inc.php');
$listOfThemes = array('');
foreach (glob('*') as $file) {
	if(is_dir($file)) {
		array_push($listOfThemes, $file);
	}
}

$uninstalledThemes = array('');

$link = mysql_connect($SETTINGS['db_server'], $SETTINGS['db_user'], $SETTINGS['db_password']);
	if($link) {
		if(mysql_select_db($SETTINGS['db_database'], $link)) {
				foreach($listOfThemes as $installed) {
					if(empty($installed)) { continue; }
					$query = "SELECT * FROM `".$SETTINGS['db_prefix']."themes`
					WHERE `name` = '".$installed."'";
				$results = mysql_query($query);
				$results = mysql_fetch_array($results);
				if(!$results) {
					array_push($uninstalledThemes, $installed);
				}
				$query = '';
				$results = '';
			}
		} else {
			echo 'Couldn\'t find the themes table in the database!';
		}
	} else {
		echo 'Couldn\'t connect to the database!';
	}
foreach($uninstalledThemes as $addNewTheme) {
	if(empty($addNewTheme)) { continue; }
	$link = mysql_connect($SETTINGS['db_server'], $SETTINGS['db_user'], $SETTINGS['db_password']);
		if($link) {
			if(mysql_select_db($SETTINGS['db_database'], $link)) {
				$query = "INSERT INTO  `".$SETTINGS['db_prefix']."themes` (
				`id` ,
				`name` ,
				`path` ,
				`enabled`
				)
				VALUES (
				NULL ,  '".$addNewTheme."',  '".$addNewTheme."',  '0'
				);";
				if(mysql_query($query)) {
					echo 'Theme list updated.<br />';
				}
			}
		}
}
?>