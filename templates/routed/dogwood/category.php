<?
	$category = $dogwood->getCategoryByRoute($bigtree["commands"][0]);
	// If this category doesn't exist, throw a 404 error.
	if (!$category) {
		$cms->catch404();
	}
	
	if (is_numeric(end($bigtree["commands"]))) {
		$current_page = end($bigtree["commands"]);
	} else {
		$current_page = 0;
	}
	
	if ($marks){
		$posts = $dogwood->getPageOfPostsInCategory($current_page,$category,5,"author = 2");
		$postCount = $dogwood->getPostCountInCategory($category,"author = 2");
	} else {
		$posts = $dogwood->getPageOfPostsInCategory($current_page,$category,5,"author != 2");
		$postCount = $dogwood->getPostCountInCategory($category,"author != 2");
	}
	
	if ($current_page) {
		$local_title = "Page ".($current_page + 1)." of stories posted in " . $category["title"];
	} else {
		$local_title = "Posted in " . $category["title"];		
	}
?>
<h3>Posted in <?=$category["title"]?></h3>
<?
	include "_post-loop.php";
?>