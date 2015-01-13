<?
	if ($current_page > 0) {
?>
<a class="dogwood_newer_posts" href="<?=$blog_link?><?=($current_page - 1)?>/">&lsaquo; Newer Posts</a>
<?
	}
	
	if ($total_pages > ($current_page + 1)) {
?>
<a class="dogwood_older_posts" href="<?=$blog_link?><?=($current_page + 1)?>/">Older Posts &rsaquo;</a>
<?
	}
?>