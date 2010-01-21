<?php getHeader(); ?>

<div id="posts">
	<div class="trimmer"><a class="collapse_expand_all">Trim</a></div> <!-- hides/shows content of all posts on this page -->
	
	<div class="paging"><b>Run to page: </b><?php createPaging(); ?></div>
	
		<?php getLoop(); // Iterates posts as specified by the limit. ?>
		
	<div class="paging"><b>Run to page: </b><?php createPaging(); ?></div>
</div>

<?php getSidebar(); ?>

<?php getFooter(); ?>