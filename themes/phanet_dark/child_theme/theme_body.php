<div id="menu">
	<div class="title">
		<h1><a href="<?php echo $srv->getInstallRadix(); ?>"><?php $stgs->getConf("sitename"); ?></a></h1>
		<div class="description"><?php echo $stgs->getConf("sitedescription"); ?></div>
	</div>
	
	<div class="logo">
		<a href="<?php echo $srv->buildUrl('?feed='); ?>">
		<img src="<?php echo $srv->getPath('themes/phanet_dark/styles/images/feed.png'); ?>" alt="feed_icon" class="favicon"/>
		</a>
	</div>
</div>

<div id="site">
	<div id="content">
	<div id="pagetitle">