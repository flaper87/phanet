<?php

/*
* Select the current theme
*/
global $ptdb, $activetheme;

$sql = "SELECT * FROM {settings} WHERE `keyid` = 'active_theme'";
$ptdb->query($sql); $theme = $ptdb->fetchArray(); $activetheme = $theme[0][1];

/*
* Set up theme functions like getLoop etc.
*/
require_once('include/themefunctions.inc.php');

/*
* Displays posts/pages
*/
function themeTemplate($id=''){
	global $page, $footnote, $activetheme, $posts, $wgts, $srv, $stgs, $SESSION;
	switch($id){
		case 'post':
			$output[] = include($activetheme.'/index.php');
			break;
		case 'page':
			$posts = getPages( $_GET["static"] );
			$output[] = include($activetheme.'/index.php');
			break;
	}
}

/*
* Render the actual theme
*/
function themeRender($params = array()){
	
	$name = $params; 
	array_shift($params); 
		
		showThemeBody();
}

function showThemeBody() {
	global $srv, $stgs, $pages, $activetheme;
		
		$pages = getPages();
		
        if (isset($_GET['static'])) {
			$output[] = showPage();
		} else {
			$output[] = showPosts();
		}

	// echo '</div>';
}

function showPosts() {
	global $footnote, $post;
		
	echo themeTemplate('post');
}

function showPage() {
	
	global $footnote, $page;

	$pages = getPages( $_GET["static"] );

	if (!$pages) {
		manage_error(404);
	}
		
	foreach ( $pages as $page ) {
		
		$footnote = 'Written on '. get_date('r',$page->page_date);
		$output[] = themeTemplate('page');
	}
	echo $output[1];
}
