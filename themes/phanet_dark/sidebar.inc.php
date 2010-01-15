<?php

session_start();

function showThemeSidebar() {
	global $wgts, $srv, $stgs, $SESSION;
	
		$output[] = '<div class="sidebar_left">';

		if ($_SESSION['logMessage'] != '') {
			$output[] = '<div class="block">';
				$output[] = '<div class="title"><h2><span style="color:#f67106 !important;" class="dark">Message For You</span></h2></div>';
				$output[] = '<div class="text">';
				$output[] = $_SESSION['logMessage'];
				 $output[] = '</div>';
				$output[] = '<div class="close"></div>';
			$output[] = '</div>';

			$_SESSION['logMessage'] = '';
		}

		if (is_object($wgts) && $stgs->getConf('widgetizer') == "enabled"): $output[] = $wgts->showSidebar();
		else:
		
		if (function_exists('searchForm'))
			$output[] = searchForm();
		
			if ( function_exists('showUsersBlock') ) $output[] = showUsersBlock();
			
			$blogs = getFeeds();
			
			$output[] = '<div class="block">';
				$output[] = '<div class="title"><h2><span class="dark">Registered Blogs ('.count($blogs).')</span></h2></div>';
				$output[] = '<div class="text">';
				$output[] = '<ul id="blog">';
				
				foreach($blogs as $blog) {
					$output[] = '<li><a style="padding-left:5px;" href="'.$blog['url'].'" title="'.$blog['description'].'">'.$blog['name'].'</a></li>';                                  
				}
				
				$output[] = '</ul>';
				$output[] = '</div>';
				$output[] = '<div class="close"></div>';
			$output[] = '</div>';

			//$output[] = sidebarCategories();
	endif;
	$output[] = '</div>';//-->column-left	
	echo join("\n", $output);
	
}

