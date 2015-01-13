<?
	if (count($posts)) {
		$x = 0;
		foreach ($posts as $post) {
			$x++;
			if ($x == count($posts)) {
				$last = true;
			} else {
				$last = false;
			}
			include "_post.php";
		}
	} else {
?>
<p>Sorry, no posts found.</p>		
<?
	}
?>