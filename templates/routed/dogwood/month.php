<?
	$month = $bigtree["commands"][0];
	if (is_numeric(end($bigtree["commands"]))) {
		$current_page = end($bigtree["commands"]);
	} else {
		$current_page = 0;
	}

	$posts = $dogwood->getPageOfPostsInMonth($current_page,$month,5);
	if ($current_page) {
		$local_title = "Page ".($current_page + 1)." of stories posted in " . date("F Y",strtotime($month));	
	} else {
		$local_title = "Posted in ".date("F Y",strtotime($month));
	}
?>
<h3>Posted in <?=date("F Y",strtotime($month))?></h3>
<?
	include "_post-loop.php";
?>