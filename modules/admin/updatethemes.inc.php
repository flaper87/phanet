<?php
function listThemes() {
global $ptdb;
$ptdb->query("SELECT * FROM {settings} WHERE `keyid` = 'active_theme'");
$row = $ptdb->fetchArray();
$activetheme = $row[0][1];

	$installedThemes = array('');
	
	foreach (glob('themes/*') as $file) {
		if(is_dir($file)) {
			$newfile = str_replace("themes/","",$file);
			array_push($installedThemes, $newfile);
		}
	}
	foreach($installedThemes as $theme):
	if(!empty($theme)) {
		$selected = "";
		if($theme == $activetheme) { $selected = ' selected'; }
		$output .= "<option".$selected." value=\"".$theme."\">".$theme."</option>";
	}
	endforeach;
	return $output;
}