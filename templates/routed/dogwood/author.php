<?
	$author = $dogwood->getAuthorByRoute($bigtree["commands"][0]);
	// If the author wasn't found throw a 404.	
	if (!$author) {
		$cms->catch404();
	}

	if (is_numeric(end($bigtree["commands"]))) {
		$current_page = end($bigtree["commands"]);
	} else {
		$current_page = 0;
	}

	$posts = $dogwood->getPageOfPostsByAuthor($current_page,$author,5);
	if ($current_page) {
		$local_title = "Page ".($current_page + 1)." of stories posted by " . $author["name"];
	} else {
		$local_title = "Posted by " . $author["name"];
	}
?>
<h3>Posted by <?=$author["name"]?></h3>
<?
	// Show the author's bio if this is the first page.
	if (!$current_page) {
?>
<div class="author_bio contain">
	<? if ($author["image"]) { ?>
	<div class="image">
		<img src="<?=$author["image"]?>" alt="" class="block_left" />
	</div>
	<? } ?>
	<div class="contain">
		<h4><?=$author["name"]?></h4>
		<?=$author["biography"]?>
	</div>
</div>
<?
	}
	
	include "_post-loop.php";
?>