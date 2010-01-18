<?php /**
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

function footnote() {
	global $footnote; echo $footnote;
}

function pageTitle() {
	global $page;
	echo $page->page_title;
}

function pageContent() {
	global $page;
	echo html_entity_decode($page->page_content);
}

function pageDate($arg) {
	global $page;
	echo get_date($arg,$page->page_date);
}

function listPages($args = array('default')) {
	global $pages, $page, $activetheme, $srv;
	if($args['icon'] == 'true') { ?>
	<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?> />
	<?php } ?>
  <a class="pagelink<?php echo ' ' . $args['class']; ?>" href="<?php echo $srv->getInstallRadix(); ?>">Home</a>
	<?php
	foreach ( $pages as $page ) {
		if($args['icon'] == 'true') { ?>
		<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?> /> <?php } ?>
		  <a class="pagelink<?php echo ' ' . $args['class']; ?>" href="<?php echo $srv->buildUrl("?static=".$page->id); ?>"><?php echo $page->page_title; ?></a> 
	<?php }
}

function adminLink() {
	global $srv;
	// if ($_SESSION['userLogged'] && $_SESSION['adminLogged']) { ?>
	</p>
		<a style="text-align:right;" href="<?php echo $srv->buildUrl('?admin='); ?>"><span class="footnote">Admin Panel</span></a></h2>
	<?php // }
}