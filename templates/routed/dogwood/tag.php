<?
	$tag = $cms->getTagByRoute($bigtree["commands"][0]);
	// If this isn't a valid tag, throw a 404.
	if (!$tag) {
		$cms->catch404();
	}
	
	if (is_numeric(end($bigtree["commands"]))) {
		$current_page = end($bigtree["commands"]);
	} else {
		$current_page = 0;
	}

	$posts = $dogwood->getPageOfPostsWithTag($current_page, $tag["id"], 5);
	if ($current_page) {
		$local_title = "Page ".($current_page + 1)." of posts tagged &quot;".$tag["tag"]."&quot;";		
	} else {	
		$local_title = "Tagged &quot;".$tag["tag"]."&quot;";
	}
?>
<h3>Tagged &ldquo;<?=$tag["tag"]?>&rdquo;</h3>
<?
	include "_post-loop.php";
?>