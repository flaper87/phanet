<?php

function generalTemplate() {
	global $srv, $stgs;

	$output[]  = "<div id=\"content\">";
		
	$output[] = "<form name=\"ops\" action=\"".$srv->buildUrl('?admin=options-general&update=general', 1)."\" method=\"post\" id=\"ops\">";
	
	$output[] = "<div id=\"navPanel\">";
		$output[] = "<div id=\"panelTitle\">";
			$output[] = "General Settings";
		$output[] = "</div>";
	
		$output[] = "<div id=\"navBar\" class=\"optionsBar\">";
			$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"general\" tabindex=\"7\" accesskey=\"s\">";
		$output[] = "</div>";
	$output[] = "</div>";
	
	$output[] = "<table id=\"optionsTable\" >";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Title: </td><td><input type=\"text\" size=70 name=\"siteName\" tabindex=\"1\" value=\"".$stgs->getConf('sitename')."\"> </td></tr>";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Description: </td><td><input type=\"text\" size=70 name=\"siteDescription\" tabindex=\"2\" value=\"".$stgs->getConf('sitedescription')."\"> </td></tr>";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Language: </td><td><input type=\"text\" size=70 name=\"siteLang\" tabindex=\"3\" value=\"".$stgs->getConf('language')."\"> </td></tr>";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Delete posts:</td><td><input type=\"text\" size=30 name=\"delPosts\" tabindex=\"3\" value=\"".$stgs->getConf('delete_posts')."\"> <span class=\"optDescription\">Timeout in days to delete the old posts. Leave blank to keep</span> </td></tr>";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Theme: </td><td><select class=\"ops_combobox\" name=\"siteTheme\" id=\"siteTheme\" tabindex=\"4\">";
	
	foreach(installedThemes() as $theme):
		$selected = "";
		if ($theme['name'] == $stgs->getConf('default_theme')) $selected = 'selected="selected"';
		$output [] = "<option $selected value=\"".$theme['name']."\">".$theme['name']."</option>";
	endforeach;
	
	$output[] = "</select></td>";		
	
	if ($stgs->getConf('web_update') == 'enabled') $checked = "checked=\"yes\"";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Web Update: </td><td><input type=\"checkbox\" size=30 name=\"webUpdate\" tabindex=\"5\" ".$checked."> </td>";
	
	$checked = "";
	if ($stgs->getConf('rewrite_url') == 'enabled') $checked = "checked=\"yes\"";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Rewrite Url: </td><td class=\"test\"><input type=\"checkbox\" size=30 name=\"rewriteUrl\" tabindex=\"6\" ".$checked."> </td>";			
	
	$output[] = "</table>";
	$output[] = "</form>";
	$output[] = "</div>";
	$output[] = "</div>";
		
	echo join("\n", $output);
}

function readerTemplate() {
	global $srv, $stgs;

	$output[] = "<div id=\"content\">";
		
	$output[] = "<form name=\"ops\" action=\"".$srv->buildUrl('?admin=options-reader&update=reader', 1)."\" method=\"post\" id=\"ops\">";
	
	$output[] = "<div id=\"navPanel\">";
		$output[] = "<div id=\"panelTitle\">";
			$output[] = "Feed Reader Settings";
		$output[] = "</div>";
	
		$output[] = "<div id=\"navBar\" class=\"optionsBar\">";
			$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"reader\" tabindex=\"4\" accesskey=\"s\">";
		$output[] = "</div>";
	$output[] = "</div>";
	
	$output[] = "<table id=\"optionsTable\" >";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Cache Refresh: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"cacheRefresh\" tabindex=\"1\" value=\"".$stgs->getConf('feed_refresh')."\"></td>";
	$output[] = "<td><span class=\"optDescription\">Set how frequently the cache should be refreshed (in seconds)</span></td></tr>";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Feed Timeout: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"feedTimeOut\" tabindex=\"2\" value=\"".$stgs->getConf('feed_timeout')."\"></td>";
	$output[] = "<td><span class=\"optDescription\">Set how long the reader should wait for an answer (in seconds)</span></td></tr>";	

	if ($stgs->getConf('reader_debug') == 'enabled') $checked = "checked=\"yes\"";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Debug: </td><td><input type=\"checkbox\" size=30 name=\"readerDebug\" tabindex=\"3\" ".$checked."> </td>";
	$output[] = "<td><span class=\"optDescription\">Does the Reader should show the debug info?</span></td></tr>";
	
	$output[] = "</table>";
	$output[] = "</form>";
	$output[] = "</div>";
	$output[] = "</div>";
		
	echo join("\n", $output);
}

function smtpTemplate() {
	global $srv, $stgs;
	
	$output[]  = "<div id=\"content\">";
		
	$output[] = "<form name=\"ops\" action=\"".$srv->buildUrl('?admin=options-smtp&update=smtp', 1)."\" method=\"post\" id=\"ops\">";
	
	$output[] = "<div id=\"navPanel\">";
		$output[] = "<div id=\"panelTitle\">";
			$output[] = "Mail Settings";
		$output[] = "</div>";
	
		$output[] = "<div id=\"navBar\" class=\"optionsBar\">";
			$output[] = "<div id=\"navButton\"><a id=\"checkSmtp\" href=\"".$srv->buildUrl('?admin=options-smtp&check=smtp', 1)."\">Check Smtp</a></div>";
			$output[] = "<input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"smtp\" tabindex=\"5\" accesskey=\"s\">";
		$output[] = "</div>";
	$output[] = "</div>";
	
	$output[] = "<table id=\"optionsTable\" >";
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Smtp Host: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"smtpHost\" tabindex=\"1\" value=\"".$stgs->getConf('smtp_host')."\"></td>";
	$output[] = "<td><span class=\"optDescription\">Leave blank if Phanet is installed on the same server as SMTP</span></td></tr>";	
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Smtp User: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"smtpUser\" tabindex=\"2\" value=\"".$stgs->getConf('smtp_user')."\"></td></tr>";	

	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Smtp Password: </td>";
	$output[] = "<td><input type=\"password\" size=70 name=\"smtpPassword\" tabindex=\"3\" value=\"".$stgs->getConf('smtp_pass')."\"></td></tr>";
	
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Smtp Sender: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"smtpSender\" tabindex=\"4\" value=\"".$stgs->getConf('smtp_sender')."\"></td></tr>";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Smtp Port: </td>";
	$output[] = "<td><input type=\"text\" size=70 name=\"smtpPort\" tabindex=\"5\" value=\"".$stgs->getConf('smtp_port')."\"></td></tr>";
	
	if ($stgs->getConf('smtp_auth') == 'enabled') $checked = "checked=\"yes\"";
	
	$output[] = "<tr id=\"block\"><td class=\"blockSubject\">Secure Authentication: </td><td><input type=\"checkbox\" name=\"smtpAuth\" tabindex=\"6\" ".$checked."> </td></tr>";
	
	$output[] = "</table>";
	$output[] = "</form>";
	$output[] = "</div>";
	$output[] = "</div>";
		
	echo join("\n", $output);
}

function widgetsTemplate() {
	global $widgetsPath, $srv, $stgs, $admldr;
	
	$output[]  = "<div id=\"content\">";
	
	$output[] = "<div id=\"navPanel\">";
		$output[] = "<div id=\"panelTitle\">";
			$output[] = "Widgets Settings";
		$output[] = "</div>";
	
		$output[] = "<div id=\"navBar\" class=\"optionsBar\">";
			$output[] = "<form id=\"wEnabledForm\" action=\"".$srv->buildUrl("?admin=options-widgets&update=widgets", 1)."\">";
			$output[] = "<noscript><input type=\"submit\" id=\"navButton\" value=\"Save/Update\" name=\"smtp\" tabindex=\"5\" accesskey=\"s\"></noscript>";
			($stgs->getConf('widgetizer') == "enabled")?$checked="checked":pass;
			$output[] = '<div style="color:#000; float:right; padding-top: 5px; padding-right: 20px;"><b>Enable: </b><input type="checkbox" id="widgetCheck" name="widgetCheck" onclick="updateWidgets( $( \'#wEnabledForm\', document ) );" '.$checked.'></div>';
			$output[] = "</form>";
		$output[] = "</div>";
	$output[] = "</div>";
	
	$output[] = '<div id="listContainer" style="float:left;">';
			
			$output[] = '<h4 id="listsTitle">Available plugins</h4>';
			
			$enWidgets = $admldr->getEnWidgets();
			$avWidgets = $admldr->recDirScan($widgetsPath, "widget");
			
			(($navWidgets = count($avWidgets) - count($enWidgets)) >= 0)?pass:$navWidgets = 0;
		
			$output[] = "<div id=\"availableLog\" class=\"widgetsLog\"><b>".$navWidgets." widgets Available</b></div>";
			
			$output[] = '<ul class="widgetsLists" id="availableslist">';

		foreach ( $avWidgets as $key => $widget ) {

				if ( is_array($enWidgets) && deepArraySearch( $widget['name'], $enWidgets) ) continue;
				
				$path = "/".preg_replace( "%.*?/included/(.*)%is", "$1", $widget['path']);
				
				$output[] = '<li id="widgetsAvailable" name="'.$widget['name'].'" class="widgetsItems">';
				$output[] = '<h4 id="widgetName">';
				$output[] = '<noscript><a id="widgetAction" href="'.$srv->buildUrl("?admin=options-widgets&add=widget&wName=".$widget['name']."&wPath=".$path, 1).'">Add</a></noscript>';
				$output[] = $widget['name'];
				$output[] = '</h4>';	   	
				$output[] = '<input type="hidden" id="widgetPath" value="'.$path.'">';				
				$output[] = '</li>';
		}
			
			 $output[] = '</ul>';
		$output[] = '</div>';
		
		$output[] = '<div id="listContainer" style="float:left;">';
		
		$output[] = '<h4 id="listsTitle">Enabled plugins</h4>';
		
		$output[] = "<div id=\"enabledLog\" class=\"widgetsLog\"><b>".count($enWidgets)." widgets Enabled</b></div>";
			
			$output[] = '<ul class="widgetsLists" id="enabledlist">';

		if (is_array($enWidgets)) {		
				for ($i=0; $i<count($enWidgets); $i++) {
					$output[] = '<li id="widgetsEnabled" name="'.$enWidgets[$i]['name'].'" class="widgetsItems">';
					$output[] = '<h4 id="widgetName">';
					$output[] = '<noscript><a id="widgetAction" href="'.$srv->buildUrl("?admin=options-widgets&add=widget&wName=".$widget['name']."&wPath=".$path, 1).'">Remove</a></noscript>';
					$output[] = $enWidgets[$i]['name'];
					$output[] = '</h4>';
					$output[] = '<input type="hidden" id="widgetPath" value="'.$enWidgets[$i]['path'].'">';
					$output[] = '</li>';
				}
			}
			
			$output[] = '</ul>';
		$output[] = '</div>';
	
	$output[] = '</div><br style="clear:both;">'; //content
	
	echo join("\n", $output);

}
