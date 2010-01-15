<?php

@session_start();

function load_header( $pages, $currentPage ) {
	global $srv,$css, $stgs;
	
	$output[]  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
	
	$output[] = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\">";
	$output[] = "<head>";
	
	$output[] = "<title>".$stgs->getConf('sitename').": Admin</title>";
	
	$output[] = "<link rel=\"stylesheet\" href=\"".$srv->getPath('/modules/admin/styles/admin-style.css')."\" type=\"text/css\" media=\"screen, projector\" />";
	$output[] = '<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="'.$srv->buildUrl('feed').'"  />';
	$output[] = '<link rel="search" type="application/opensearchdescription+xml" href="'.$srv->buildUrl('openSearch').'" title="'.$stgs->getConf("sitename").'" />';
	$output[] = '<link rel="icon" type="image/png" title="favicon" href="'.$srv->getPath('media/phaneticon.png').'"  />';
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/jquery.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/ui/ui.base.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('media/js/jquery/ui/ui.sortable.js')."\" type=\"text/javascript\"></script>";
	$output[] = "<script src=\"".$srv->getPath('modules/admin/styles/admin.js')."\" type=\"text/javascript\"></script>";
	
//	$output[] = '<script type="application/javascript">';
//	$output[] = '$.post("?admin=", {isJavascript: true})';
//	$output[] = "</script>";
	
	$output[] = "</head>";
	$output[] = "<body id=\"body\">";
	$output[] = "<div id=\"top-border\"></div>";
	$output[] = "<div id='logOut'>";
	$output[] = "Wellcome ".$_SESSION['userNickname']." | <a href='".$srv->buildUrl('?user=logout')."'>Log Out</a>";
	$output[] = "</div>";
	
	$output[] = "<div id=\"header\">";
	$output[] = "<span class=\"siteName\"><a href=\"".$srv->getInstallRadix()."\">".$stgs->getConf('sitename')."</a></span>";
	$output[] = "<h3>".$stgs->getConf('sitedescription')."</h3>";
	$output[] = "<div id=\"menu\">";
	$output[] = "<ul>";

	foreach( $pages as $page => $items){
		$class='';
	
		if ( $page == $currentPage || is_array($pages[$page]['submenu'][$currentPage])) {
			$subItems = $pages[$page]['submenu'];
			$class= "class='selected'";
		} 
					
		$output[] = "\n\t<li><h4><a href='".$srv->buildUrl('?admin='.$pages[$page]['mainlink'])."' $class>".ucwords($page)."</a></h4></li>";
	}
	$output[] = "</ul>";
	$output[] = "</div>";
	$output[] = "</div>";

	if ($subItems) {
		$output[] = "<div id=\"subMenu\">";
		
		foreach ($subItems as $key => $item) {
			$class = "";	
			if ( $item['name'] == $currentPage ) $class= "class='selected'";
			$output[] = "<h4><a href='".$srv->buildUrl('?admin='.strtolower($item['link']))."' $class>".ucwords($item['name'])."</a></h4>";
		}

		$output[] = "</div>";
	}
	$output[] = "</div>";
	echo join("\n", $output);
}
