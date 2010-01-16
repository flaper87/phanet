<?php

require_once('updatethemes.inc.php');

function generalTemplate() {
	global $srv, $stgs; ?>

	<div id="content">
		
	<form name="ops" action="<?php echo $srv->buildUrl('?admin=options-general&update=general', 1); ?>" method="post" id="ops">
	
	<div id="navPanel">
		<div id="panelTitle">
			General Settings
		</div>
	
		<div id="navBar" class="optionsBar">
			<input type="submit" id="navButton" value="Save/Update" name="general" tabindex="7" accesskey="s">
		</div>
	</div>
	
	<table id="optionsTable" >
	<tr id="block"><td class="blockSubject">Title: </td><td><input type="text" size=70 name="siteName" tabindex="1" value="<?php $stgs->getConf('sitename'); ?>"> </td></tr>
	<tr id="block"><td class="blockSubject">Description: </td><td><input type="text" size=70 name="siteDescription" tabindex="2" value="<?php $stgs->getConf('sitedescription'); ?>"> </td></tr>
	<tr id="block"><td class="blockSubject">Language: </td><td><input type="text" size=70 name="siteLang" tabindex="3" value="<?php $stgs->getConf('language'); ?>"> </td></tr>
	<tr id="block"><td class="blockSubject">Delete posts:</td><td><input type="text" size=30 name="delPosts" tabindex="3" value="<?php $stgs->getConf('delete_posts'); ?>"> <span class="optDescription">Timeout in days to delete the old posts. Leave blank to keep</span> </td></tr>
	
	<tr id="block"><td class="blockSubject">Theme: </td><td><select class="ops_combobox" name="siteTheme" id="siteTheme" tabindex="4">
	
	<?php listThemes(); ?>
	
	</select></td>		
	
	<?php if ($stgs->getConf('web_update') == 'enabled') $checked = "checked='yes'"; ?>
	
	<tr id="block"><td class="blockSubject">Web Update: </td><td><input type="checkbox" size=30 name="webUpdate" tabindex="5" <?php echo $checked; ?>> </td>
	
	<?php $checked = "";
	if ($stgs->getConf('rewrite_url') == 'enabled') $checked = "checked='yes'"; ?>
	
	<tr id="block"><td class="blockSubject">Rewrite Url: </td><td class="test"><input type="checkbox" size=30 name="rewriteUrl" tabindex="6" <?php echo $checked; ?>> </td>			
	
	</table>
	</form>
	</div>
	</div>
		
<?php }

function readerTemplate() {
	global $srv, $stgs; ?>

	<div id="content">
		
	<form name="ops" action="<?php echo $srv->buildUrl('?admin=options-reader&update=reader', 1); ?>" method="post" id="ops">
	
	<div id="navPanel">
		<div id="panelTitle">
			Feed Reader Settings
		</div>
	
		<div id="navBar" class="optionsBar">
			<input type="submit" id="navButton" value="Save/Update" name="reader" tabindex="4" accesskey="s">
		</div>
	</div>
	
	<table id="optionsTable" >
	<tr id="block"><td class="blockSubject">Cache Refresh: </td>
	<td><input type="text" size=70 name="cacheRefresh" tabindex="1" value="<?php $stgs->getConf('feed_refresh'); ?>"></td>
	<td><span class="optDescription">Set how frequently the cache should be refreshed (in seconds)</span></td></tr>
	
	<tr id="block"><td class="blockSubject">Feed Timeout: </td>
	<td><input type="text" size=70 name="feedTimeOut" tabindex="2" value="<?php $stgs->getConf('feed_timeout'); ?>"></td>
	<td><span class="optDescription">Set how long the reader should wait for an answer (in seconds)</span></td></tr>	

	<?php if ($stgs->getConf('reader_debug') == 'enabled') $checked = "checked='yes'"; ?>
	
	<tr id="block"><td class="blockSubject">Debug: </td><td><input type="checkbox" size=30 name="readerDebug" tabindex="3" "<?php echo $checked; ?>"> </td>
	<td><span class="optDescription">Does the Reader should show the debug info?</span></td></tr>
	
	</table>
	</form>
	</div>
	</div>

<?php }

function smtpTemplate() {
	global $srv, $stgs; ?>
	
	<div id="content">
		
	<form name="ops" action="<?php echo $srv->buildUrl('?admin=options-smtp&update=smtp', 1); ?>" method="post" id="ops">
	
	<div id="navPanel">
		<div id="panelTitle">
			Mail Settings
		</div>
	
		<div id="navBar" class="optionsBar">
			<div id="navButton"><a id="checkSmtp" href="<?php echo $srv->buildUrl('?admin=options-smtp&check=smtp', 1); ?>">Check Smtp</a></div>
			<input type="submit" id="navButton" value="Save/Update" name="smtp" tabindex="5" accesskey="s">
		</div>
	</div>
	
	<table id="optionsTable" >
	<tr id="block"><td class="blockSubject">Smtp Host: </td>
	<td><input type="text" size=70 name="smtpHost" tabindex="1" value="<?php $stgs->getConf('smtp_host'); ?>"></td>
	<td><span class="optDescription">Leave blank if Phanet is installed on the same server as SMTP</span></td></tr>	
	
	<tr id="block"><td class="blockSubject">Smtp User: </td>
	<td><input type="text" size=70 name="smtpUser" tabindex="2" value="<?php $stgs->getConf('smtp_user'); ?>"></td></tr>	

	
	<tr id="block"><td class="blockSubject">Smtp Password: </td>
	<td><input type="password" size=70 name="smtpPassword" tabindex="3" value="<?php $stgs->getConf('smtp_pass'); ?>"></td></tr>
	
	
	<tr id="block"><td class="blockSubject">Smtp Sender: </td>
	<td><input type="text" size=70 name="smtpSender" tabindex="4" value="<?php $stgs->getConf('smtp_sender'); ?>"></td></tr>
	
	<tr id="block"><td class="blockSubject">Smtp Port: </td>
	<td><input type="text" size=70 name="smtpPort" tabindex="5" value="<?php $stgs->getConf('smtp_port'); ?>"></td></tr>
	
	<?php if ($stgs->getConf('smtp_auth') == 'enabled') $checked = "checked='yes'"; ?>
	
	<tr id="block"><td class="blockSubject">Secure Authentication: </td><td><input type="checkbox" name="smtpAuth" tabindex="6" <?php echo $checked; ?>> </td></tr>
	
	</table>
	</form>
	</div>
	</div>
		
<?php }

function widgetsTemplate() {
	global $widgetsPath, $srv, $stgs, $admldr; ?>
	
	<div id="content">
	
	<div id="navPanel">
		<div id="panelTitle">
			Widgets Settings
		</div>
	
		<div id="navBar" class="optionsBar">
			<form id="wEnabledForm" action=<?php echo $srv->buildUrl("?admin=options-widgets&update=widgets", 1); ?>>
			<noscript><input type="submit" id="navButton" value="Save/Update" name="smtp" tabindex="5" accesskey="s"></noscript>
			($stgs->getConf('widgetizer') == "enabled")?$checked="checked":pass;
			<div style="color:#000; float:right; padding-top: 5px; padding-right: 20px;"><b>Enable: </b><input type="checkbox" id="widgetCheck" name="widgetCheck" onclick="updateWidgets( $( \'#wEnabledForm\', document ) );" <?php echo $checked; ?>></div>
			</form>
		</div>
	</div>
	
	<div id="listContainer" style="float:left;">
			
			<h4 id="listsTitle">Available plugins</h4>
			
			<?php $enWidgets = $admldr->getEnWidgets();
			$avWidgets = $admldr->recDirScan($widgetsPath, "widget");
			
			(($navWidgets = count($avWidgets) - count($enWidgets)) >= 0)?pass:$navWidgets = 0; ?>
		
			<div id="availableLog" class="widgetsLog"><b><?php echo $navWidgets; ?>" widgets Available</b></div>
			
			<ul class="widgetsLists" id="availableslist">

		<?php foreach ( $avWidgets as $key => $widget ) {

				if ( is_array($enWidgets) && deepArraySearch( $widget['name'], $enWidgets) ) continue;
				
				$path = "/".preg_replace( "%.*?/included/(.*)%is", "$1", $widget['path']); ?>
				
				<li id="widgetsAvailable" name=<?php echo $widget['name']; ?> class="widgetsItems">
				<h4 id="widgetName">
				<noscript><a id="widgetAction" href=<?php echo $srv->buildUrl("?admin=options-widgets&add=widget&wName=".$widget['name']."&wPath=".$path, 1); ?>>Add</a></noscript>
				$output[] = $widget['name'];
				</h4>	   	
				<input type="hidden" id="widgetPath" value=<?php echo $path; ?>>				
				</li>
		}
			
		</ul>
		</div>
		
		<div id="listContainer" style="float:left;">
		
		<h4 id="listsTitle">Enabled plugins</h4>
		
		<div id="enabledLog" class="widgetsLog"><b><?php echo count($enWidgets); ?>" widgets Enabled</b></div>
			
			<ul class="widgetsLists" id="enabledlist">

		<?php if (is_array($enWidgets)) {		
				for ($i=0; $i<count($enWidgets); $i++) { ?>
					<li id="widgetsEnabled" name=<?php echo $enWidgets[$i]['name']; ?> class="widgetsItems">
					<h4 id="widgetName">
					<noscript><a id="widgetAction" href=<?php echo $srv->buildUrl("?admin=options-widgets&add=widget&wName=".$widget['name']."&wPath=".$path, 1); ?>>Remove</a></noscript>
					<?php echo $enWidgets[$i]['name']; ?>
					</h4>
					<input type="hidden" id="widgetPath" value=<?php echo $enWidgets[$i]['path']; ?>>
					</li>
			<?php	}
			} ?>
			
			</ul>
		</div>
	
	</div><br style="clear:both;">

<?php }
}