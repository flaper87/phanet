<?php

session_start();

include_once ('header.inc.php');
include_once ('sidebar.inc.php');
include_once ('bottom.inc.php');
require_once('include/themefunctions.inc.php');

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
	return $output[1];
}

function themeRender($params = array()){
	
	$name = $params[0]; 
	array_shift($params); 
		
		showThemeBody();
}

function showThemeBody() {
	global $srv, $stgs, $pages, $activetheme;
		
		$pages = getPages();
		
        if ($_GET["static"]) {
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
