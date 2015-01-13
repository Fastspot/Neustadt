<?
	if ($marks) {
		$total_pages = ceil($dogwood->getPostCount("author = 2") / 5);
	} else { 
		$total_pages = ceil($dogwood->getPostCount("author != 2") / 5);
	}
	$total_pages = $total_pages ? $total_pages : 1;
	
	if (is_numeric(end($bigtree["commands"]))) {
		$current_page = end($bigtree["commands"]);
		// Only show the "Page X" if it's not the first page.
		if (end($bigtree["commands"])) {
			$local_title = "Page ".(end($bigtree["commands"])+1);
		}
	} else {
		$current_page = 0;
	}
	if ($marks) {
		$posts = $dogwood->getPageOfPosts($current_page, 5, "author = 2");
	} else {
		$posts = $dogwood->getPageOfPosts($current_page, 5, "author != 2");
	}
	
	include "_post-loop.php";
?>