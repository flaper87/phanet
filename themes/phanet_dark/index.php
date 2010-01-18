<div class="single_post">
<div class="title_date">
	<p class="days"><?php postDate('j'); ?></p>
	<p class="month"><?php postDate('m'); ?></p>
</div>
<div class="title">
<h4 id="blogname" name="<?php blogName(); ?>"><?php blogName(); ?></h4>
<h4><?php postTitle(); ?></h4>
</div>
<span class="footnote">
<?php footnote(); ?>
</span>
<div class="post_content"><?php postContent(); ?></div>
</div>