<?php
function listThemes() {
global $ptdb;
$ptdb->query("SELECT * FROM {settings} WHERE `keyid` = 'active_theme'");
$row = $ptdb->fetchArray();
$row2 = $row[0];
$activetheme = $row2[1]; // UGLY

	$installedThemes = array('');
	
	foreach (glob('themes/*') as $file) {
		if(is_dir($file)) {
			$newfile = str_replace("themes/","",$file);
			array_push($installedThemes, $newfile);
		}
	}
	foreach($installedThemes as $theme):
	if(empty($theme)) {continue;}
		$selected = "";
		if($theme == $activetheme) { $selected = ' selected'; }
		echo "<option$selected value=\"".$theme."\">".$theme."</option>";
	endforeach;
	
}