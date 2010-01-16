<?php function listThemes() {
	global $SETTINGS;
$link = mysql_connect($SETTINGS['db_server'], $SETTINGS['db_user'], $SETTINGS['db_password']);
if($link) {
	if(mysql_select_db($SETTINGS['db_database'])) {
		$query = "SELECT * FROM `".$SETTINGS['db_prefix']."settings` WHERE `keyid` = 'active_theme'";
		$results = mysql_query($query);
		$row = mysql_fetch_row($results);
		$activetheme = $row[1];
	}
}
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