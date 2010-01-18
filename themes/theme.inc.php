<?php

session_start();

include_once ('header.inc.php');
include_once ('sidebar.inc.php');
include_once ('bottom.inc.php');
require_once('include/themefunctions.inc.php');

function themeTemplate($id=''){
	global $page, $footnote, $activetheme;
	switch($id){
		case 'post':
			$output[] = include($activetheme.'/index.php');
			break;
		case 'page':
			$output[] = include($activetheme.'/page.php');
			break;
	}
	return join("\n", $output);
}

function themeRender($params = array()){
	
	$name = $params[0]; 
	array_shift($params); 

	 	loadThemeHeader();
		
		showThemeBody();
		
		showThemeSidebar();
		
		showThemeBottom();
}

function showThemeBody() {
	global $srv, $stgs, $pages, $activetheme;
		
		$output[] = require_once($activetheme.'/theme_body.php');
		
		$pages = getPages();
		
		$menu[] = require($activetheme.'/menu.php');
		
		if ($_SESSION['userLogged'] && $_SESSION['adminLogged']) {
			$output[] = '<h2><p style="font-size: 16px; float:left;">'.join("\n",$menu).'</p>';
		
			$output[] = '<a style="text-align:right;" href="'.$srv->buildUrl('?admin=').'"><span class="footnote">Admin Panel</span></a></h2>';
		} else {
			$output[] = '<h2 style="font-size: 16px; text-align:left;">'.join("\n",$menu).'</h2>';
		}
		
		$output[] = '</div>';
		$output[] = '<div id="posts">';
		
        if ($_GET["static"]) {
			$output[] = showPage();
		} else {
			$output[] = showPosts();
		}

	echo '</div>';
}

function showPosts() {
	
	global $footnote, $post;

		//Not supported yet.. I'm working on it
	if (!isset($_POST["searchPosts"]) && !isset($_POST["advanceSearch"]) && !isset($_GET["openSearch"])) {
		$output[] = '<div id="paging">';
		$output[] = '<b>Run to page: </b>'.createPaging();
		$output[] = '</div>';
	}
	
	$output[] = '<div class="collapse_expand_all">Collapse All</div>';

	$posts = getPosts(-1);

	if (!$posts) {
	 	echo 'No posts were found!';
	}

	$i = 0;
				 
	foreach( $posts as $post){
		if ( $i == 20 ) break;
		
		$author='';
		
		$title = $post->title;
		
		$blog = 'Source: <a href="'. $post->url .'">' . $post->name . '</a> ';
		$beforelink = '';
		$afterlink = '';
	    
		if ($post->link) {
			$beforelink='<a href="'.$post->link.'" target="_blank">';
	        $afterlink='</a>';
		}
		
		$author = ($post->nickname == "anonymous" or !$post->nickname)?$post->owner_nick:$post->nickname;
		
		$footnote = 'Written by: '. $beforelink . $author . $afterlink .' on '.get_date('r',$post->date);

		$words = 0;

		if ($words != 0 ) {
			$a = explode(' ', $text);
			array_splice( $a, $words);
			$text = implode(' ', $a) . '   <a href="'.$post->link.'">[... Read More ...]</a>';
		} 
		
		$output[] = themeTemplate('post');
		$i++;
	}
	echo $output[1];
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
