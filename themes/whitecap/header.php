<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $stgs->getConf("sitename"); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $srv->getPath('themes/whitecap/styles/style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $srv->getPath('media/js/thickbox/ThickBox.css'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo $srv->buildUrl('?feed='); ?>"  />
<link rel="search" type="application/opensearchdescription+xml" href="<?php echo $srv->buildUrl('?openSearch='); ?>" title="<?php echo $stgs->getConf("sitename"); ?>" />
<link rel="icon" type="image/png" title="favicon" href="<?php echo $srv->getPath('media/phaneticon.png'); ?>"  />

<script src="<?php echo $srv->getPath('media/js/jquery/jquery.js'); ?>" type="text/javascript"></script>
<script src="<?php echo $srv->getPath('media/js/jquery/ui/ui.base.js'); ?>" type="text/javascript"></script>
<script src="<?php echo $srv->getPath('media/js/jquery/ui/ui.sortable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo $srv->getPath('themes/whitecap/styles/collapsible.js'); ?>" type="text/javascript"></script>
<script src="<?php echo $srv->getPath('media/js/thickbox/thickbox.js'); ?>" type="text/javascript"></script>
</head>

<body>
	<div id="header">
		<div class="title">
			<h1><a href="<?php siteInfo('url'); ?>"><?php siteInfo('name'); ?></a></h1>
			<div class="description"><?php siteInfo('description'); ?></div>
		</div>
		<div class="nav">
			<ul>
		<?php listPages(); adminLink(); ?>
			</ul>
		</div>
	</div>
	</div>
	<div id="content">