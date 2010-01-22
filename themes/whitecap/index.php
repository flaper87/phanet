<?php getHeader(); ?>

<div id="posts">
<?php if(!is404() && !isPage()) : ?><div class="trimmer"><a class="collapse_expand_all">Trim</a></div> <!-- hides/shows content of all posts on this page -->
	
	<div class="paging"><b>Run to page: </b><?php createPaging(); ?></div><?php endif; ?>
	
		<?php getLoop(); // Iterates posts as specified by the limit. ?>
		
	<?php if(!is404() && !isPage()) : ?><div class="paging"><b>Run to page: </b><?php createPaging(); ?></div><?php endif; ?>
</div>

<?php getSidebar(); ?>

<?php getFooter(); ?>