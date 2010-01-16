<h2><p style="font-size: 16px; float:left;">
	<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?>" />
  <a style="color: #999999 !important;" href=<?php echo $srv->getInstallRadix(); ?>">Home</a> 
	
<?php foreach ( $pages as $page ) { ?>
	<img alt="pageicon" src=<?php echo $srv->getPath("themes/phanet_dark/styles/images/page.gif"); ?>" />
	  <a style="color: #999999 !important;" href=<?php echo $srv->buildUrl("?static=".$page->id); ?>"><?php echo $page->page_title; ?></a> 
<?php }

if ($_SESSION['userLogged'] && $_SESSION['adminLogged']) { ?>
</p>
	<a style="text-align:right;" href="'.$srv->buildUrl('?admin=').'"><span class="footnote">Admin Panel</span></a></h2>
<?php } ?>
</div>
<div id="posts">

<?php if ($_GET["static"]) {
	showPage();
} else {
	showPosts();
} ?>