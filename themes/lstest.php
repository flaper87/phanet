<?php
$listOfThemes = array('');
foreach (glob('*') as $file) {
	if(is_dir($file)) {
		array_push($listOfThemes, $file);
	}
}

$uninstalledThemes = array('');

$link = mysql_connect('localhost', 'root', 'root');
	if($link) {
		if(mysql_select_db('phanet', $link)) {
				foreach($listOfThemes as $installed) {
					if(empty($installed)) { continue; }
					$query = "SELECT * FROM `ph1_themes`
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
	$link = mysql_connect('localhost', 'root', 'root');
		if($link) {
			if(mysql_select_db('phanet', $link)) {
				$query = "INSERT INTO  `phanet`.`ph1_themes` (
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