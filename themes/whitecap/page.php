<?php // This is the template for a single page. ?>
<div class="single_post">
	<div class="post_title">
		<h3><a><?php pageTitle(); ?></a></h3>
	<div class="meta">posted on <span><?php pageDate('F j, Y'); ?></span>
	</div>
	</div>
	<div class="post_content">
		<?php pageContent(); ?>
	</div>
</div>