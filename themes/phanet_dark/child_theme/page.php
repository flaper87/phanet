<div class="single_post">
<div class="title_date">
<p class="days"><?php echo get_date('j',$page->page_date); ?></p>
<p class="month"><?php echo get_date('M',$page->page_date); ?></p>
</div>
<div class="title">
<h4><?php echo $page->page_title; ?></h4>
</div>
<span class="footnote">
<?php echo $footnote; ?>
</span>
<div class="post_content"><?php echo html_entity_decode($page->page_content); ?></div>
</div>
<?php echo get_date('j',$page->page_date);