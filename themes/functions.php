<?php
/**
* A helpful list of functions to be used in the theme.
*/

global $ptdb;

/**
* Set the active theme name for URL building
*/
$ptdb->query("SELECT * FROM {settings} WHERE `keyid` = 'active_theme'");
$row = $ptdb->fetchArray();
$row2 = $row[0];
$activetheme = $row2[1];

/**
* Returns site info based on input, like Wordpress' bloginfo()
*/
function siteInfo($arg) {
	global $srv, $stgs;
	switch($arg) {
		case 'name':
		default:
			echo $stgs->getConf("sitename");
			break;
		case 'url':
			echo $srv->getInstallRadix();
			break;
		case 'description':
			echo $stgs->getConf("sitedescription");
			break;
		case 'feed_url':
			echo $srv->buildUrl('?feed=');
			break;
		case 'admin_url':
			echo $srv->buildUrl('?admin=');
			break;
	}
}