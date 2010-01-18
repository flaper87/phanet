<div class="sidebar_left">

<?php sidebarMessages(); // This is always needed with dynamic and non-dynamic sidebars
if (widgetized()): echo $wgts->showSidebar(); endif; // show the dynamic sidebar if it's set up
?>
	
</div>