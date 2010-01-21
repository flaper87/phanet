<?php // This page is the template for a post. On post pages, it's looped; on page pages, it's displayed once. ?>
<div class="single_post">
	<div class="post_title">
		<h3><a href="<?php postPermalink(); ?>"><?php postTitle(); ?></a></h3>
	<div class="meta">via <strong><a href="<?php blogURL(); ?>"><?php blogName(); ?></a></strong> :: posted on <span><?php postDate('F j, Y'); ?></span>
	</div>
	</div>
	<div class="post_content">
		<?php postContent(); ?>
	</div>
</div>