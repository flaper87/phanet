<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php siteInfo('name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php siteInfo('theme_path') ?>/style.css" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php feedURL(); ?>"  />
<link rel="search" type="application/opensearchdescription+xml" href="?openSearch=" title="<?php siteInfo('name'); ?>" />
<link rel="icon" type="image/png" title="favicon" href="media/phaneticon.png"  />

<?php loadScript('jquery'); ?>
<?php loadScript('jqueryUIbase'); ?>
<?php loadScript('jqueryUIsortable'); ?>
<?php loadScript('thickbox'); ?>
<script src="<?php siteInfo('theme_path') ?>/styles/collapsible.js" type="text/javascript"></script>
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