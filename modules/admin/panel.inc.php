<?php 


function panelTemplate() {
		global $srv,$stgs, $admldr;
		
		$output[] = "<script src=\"".$srv->getPath('modules/admin/styles/dashboard.js')."\" type=\"text/javascript\"></script>";

		$output[] = "<div id=\"content\">";
		
/*		$output[] = "<div id=\"panelTitle\">";
		$output[] = $stgs->getConf('sitename')."&#8217;s Dashboard";
		$output[] = "</div><br class=\"clear\">";
*/
		
		preg_match_all("%\(1\)\[(?<first>.*?)\]\(2\)\[(?<second>.*?)\]\(3\)\[(?<third>.*?)\]%is", $stgs->getConf('dashboard_widgets'), $dashSettings);

		$dashWidgets['list1'] = array("");
		
		$output[] = "<ul id=\"dashWidgets1\" class=\"dashLists\">";
		 	
		 	$avWidgets = $admldr->recDirScan(dirname(__FILE__)."/dashWidgets", "widget");
		 	
		 	foreach ( $avWidgets as $key => $widget ) {
		 			
		 			if (!in_array($widget['name'], explode(',', $dashSettings['first'][0]))) continue;
		 			
		 			require_once($widget['path'].$widget['name'].".widget");
		 			
		 			$title = preg_replace("#(.*?)([A-Z].*?)#", "$1 $2", $widget['name']);
		 			
		   			$output[] = '<li id="dashWidItem" name="'.$widget['name'].'" class="dashItem">';
					$output[] = '<div id="widget container" class="dashWCont">';
					$output[] = '<div class="widgHeader">';
					$output[] = '<img state="shown" id="widgetArrow" class="widgetArrow" src="'.$srv->getPath("media/arrow_down.png").'" alt="arrow"><h4>'.ucwords($title).'</h4></div>';
					$output[] = $widget['name'](); //widget content
					$output[] = '</div>'; //widget container
					$output[] = '</li>';
		 	}
		 	
		$output[] = "</ul>";

		$output[] = "<ul id=\"dashWidgets2\" class=\"dashLists\">";
		 	
		 	foreach ( $avWidgets as $key => $widget ) {
		 		
		 			if (!in_array($widget['name'], explode(',', $dashSettings['second'][0]))) continue;
		 			
		 			require_once($widget['path'].$widget['name'].".widget");
		 			
		 			$title = preg_replace("#(.*?)([A-Z].*?)#", "$1 $2", $widget['name']);
		 			
		   			$output[] = '<li id="dashWidItem" name="'.$widget['name'].'" class="dashItem">';
					$output[] = '<div id="widget container" class="dashWCont">';
					$output[] = '<div class="widgHeader">';
					$output[] = '<img state="shown" id="widgetArrow" class="widgetArrow" src="'.$srv->getPath("media/arrow_down.png").'" alt="arrow"><h4>'.ucwords($title).'</h4></div>';
					$output[] = $widget['name'](); //widget content
					$output[] = '</div>'; //widget container
					$output[] = '</li>';
		 	}
		 	
		$output[] = "</ul>";
		
		$output[] = "<ul id=\"dashWidgets3\" class=\"dashLists\">";
		 	
		 	foreach ( $avWidgets as $key => $widget ) {
		 			
		 			if (!in_array($widget['name'], explode(',', $dashSettings['third'][0]))) continue;
		 			
		 			require_once($widget['path'].$widget['name'].".widget");
		 			
		 			$title = preg_replace("#(.*?)([A-Z].*?)#", "$1 $2", $widget['name']);
		 			
		   			$output[] = '<li id="dashWidItem" name="'.$widget['name'].'" class="dashItem">';
					$output[] = '<div id="widget container" class="dashWCont">';
					$output[] = '<div class="widgHeader">';
					$output[] = '<img state="shown" id="widgetArrow" class="widgetArrow" src="'.$srv->getPath("media/arrow_down.png").'" alt="arrow"><h4>'.ucwords($title).'</h4></div>';
					$output[] = $widget['name'](); //widget content
					$output[] = '</div>'; //widget container
					$output[] = '</li>';
		 	}
		 	
		$output[] = '</ul><br style="clear:both;"';
		
		$output[] = "</div>";
		echo join("\n", $output);
}
