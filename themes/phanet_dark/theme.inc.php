<?php 

session_start();

include_once ('header.inc.php');
include_once ('sidebar.inc.php');
include_once ('bottom.inc.php');
require_once('themes/functions.php');

function themeTemplate($id=''){
	global $page;
	global $footnote;
	switch($id){
		case 'post':
		/*	$output[] = '<div class="single_post">';
			$output[] = '<div class="title_date">';
			$output[] = '<p class="days">{%date:j}</p>';
			$output[] = '<p class="month">{%date:M}</p>';
			$output[] = '</div>';
			$output[] = '<div class="title">';
			$output[] = '<h4 id="blogname" name="{%blogName}">{%blog}</h4>';
			$output[] = '<h4>{%title}</h4>';
			$output[] = '</div>';
			$output[] = '<span class="footnote">';
			$output[] = '{%footnote}';
			$output[] = '</span>';
			$output[] = '<div class="post_content">{%text}</div>';
			$output[] = '</div>';
			break; */
			$output[] = require('child_theme/index.php');
		case 'page':
			/* $output[] = '<div class="single_post">';
			$output[] = '<div class="title_date">';
			$output[] = '<p class="days">{%date:j}</p>';
			$output[] = '<p class="month">{%date:M}</p>';
			$output[] = '</div>';
			$output[] = '<div class="title">';
			$output[] = '<h4>{%title}</h4>';
			$output[] = '</div>';
			$output[] = '<span class="footnote">';
			$output[] = '{%footnote}';
			$output[] = '</span>';
			$output[] = '<div class="post_content">{%content}</div>';
			$output[] = '</div>';
			break; */
			$output[] = require('child_theme/page.php');
		default:
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
	global $srv, $stgs;
	
	
	//Start's the real boddy
/*	$output[] = '<div id="menu">';
		$output[] = '<div class="title">';
			$output[] = '<h1><a href="'.$srv->getInstallRadix().'">'.$stgs->getConf("sitename").'</a></h1>';
			$output[] = '<div class="description">'.$stgs->getConf("sitedescription").'</div>';
		$output[] = '</div>'; //-->Title
		
		$output[] = '<div class="logo">';
			$output[] = '<a href="'.$srv->buildUrl('?feed=').'">';
			$output[] = '<img src="'.$srv->getPath('themes/phanet_dark/styles/images/feed.png').'" alt="feed_icon" class="favicon"/>';
			$output[] = '</a>';
		$output[] = '</div>'; //-->logo
	$output[] = '</div>'; //--> Menu

	$output[] = '<div id="site">';
		$output[] = '<div id="content">';
		$output[] = '<div id="pagetitle">'; */
		
		$output[] = require_once('child_theme/theme_body.php');
		
		$pages = getPages();
		
		/* $menu[] = '<img alt="pageicon" src="'.$srv->getPath("themes/phanet_dark/styles/images/page.gif").'" />';
		$menu[] = '  <a style="color: #999999 !important;" href="'.$srv->getInstallRadix().'">Home</a> ';
			
		foreach ( $pages as $page ) {
			$menu[] = '<img alt="pageicon" src="'.$srv->getPath("themes/phanet_dark/styles/images/page.gif").'" />';
			$menu[] = '  <a style="color: #999999 !important;" href="'.$srv->buildUrl("?static=".$page->id).'">'.$page->page_title.'</a> ';
		} */
		$menu[] = require('child_theme/menu.php');
		
		//list($type, $value) = preg_split('/\//', $_GET['showJust'], 2, PREG_SPLIT_NO_EMPTY);
		//if ($type == 'category' || $type == 'tag') $title = 'Showing <i>'.decodeUrlPiece($value).'</i>'. $type;
		
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

           
	$output[] = '</div>'; //-->posts
		
	// Content and Site are closed in the bottom.inc.php
		
	echo join("\n", $output);
}

function showPosts() {

		//Not supported yet.. I'm working on it
	if (!isset($_POST["searchPosts"]) && !isset($_POST["advanceSearch"]) && !isset($_GET["openSearch"])) {
		$output[] = '<div id="paging">';
		$output[] = '<b>Run to page: </b>'.createPaging();
		$output[] = '</div>';
	}
	
	$output[] = '<div class="collapse_expand_all">Collapse All</div>';

	$posts = getPosts( -1 );

	if (!$posts) {
		return "No Posts where found";
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

		$replacements=array(
			'{%blogName}'		=> $post->name,
			'{%blog}'		=> $blog,
			'{%date}'		=> date('r',$post->date),
			'{%date:j}'		=> get_date('j',$post->date),
			'{%date:M}'		=> get_date('M',$post->date),
			'{%title}'		=> '<a style="color: #fff !important;" href="'.$post->link.'">'.html_entity_decode($title).'</a>',
			'{%footnote}'	=> $footnote,
			'{%text}'		=> html_entity_decode($post->text),
			'{%link}'		=> $post->link,
		);
		
		$output[] = strtr(themeTemplate('post'), $replacements);
		$i++;
	}
	
	return join("\n", $output);
}

function showPage() {
	
	global $footnote, $page;

	$pages = getPages( $_GET["static"] );

	if (!$pages) {
		manage_error(404);
	}
		
	foreach ( $pages as $page ) {
		
		$footnote = 'Written on '. get_date('r',$page->page_date);
		
		$needles = array(
			'{%title}',
			'{%content}',
			'{%date}',
			'{%date:j}',
			'{%date:M}',
			'{%footnote}',
			'test',
			);
		$replacements = array(
					$page->page_title,
					html_entity_decode($page->page_content),
					date('r',$page->page_date),
					get_date('j',$page->page_date),
					get_date('M',$page->page_date),
					$footnote,
					'testy',
					);
					
		$output[] = str_replace('{%text}', 'moth', themeTemplate('page'));
		$output[] = 'LOL';
	}
	
	return $output;
}
