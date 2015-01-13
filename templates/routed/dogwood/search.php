<?
	// Once a user posts their query we redirect to a bookmarkable link (that is safe to go back to)
	if ($_POST["query"]) {
		BigTree::redirect($blog_link."search/".urlencode($_POST["query"])."/0/");
	}

	// Pull the query and current page
	$query = $bigtree["commands"][0];
	$current_page = isset($bigtree["commands"][1]) ? $bigtree["commands"][1] : 0;

	// Grab a page of results
	$posts = $dogwood->getSearchPageOfPosts($query,$current_page,5);
	if ($current_page) {
		$local_title = "Page ".($current_page + 1)." of search results for &quot;" . htmlspecialchars($query) . "&quot;";	
	} else {
		$local_title = "Search results for &quot;" . htmlspecialchars($query) . "&quot;";
	}
?>
<h3>Search results for &ldquo;<?=htmlspecialchars($query)?>&rdquo;</h3>
<?
	include "_post-loop.php";
?>