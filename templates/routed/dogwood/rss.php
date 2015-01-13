<?
	// Send the XML Headers
	header("Content-type: text/xml");
	$bigtree["layout"] = "blank";
	ob_clean();
	// Get the Blog's settings so we can draw the title and tagline in the RSS.
	$settings = $cms->getSettings(array("marks-blog-callout","ncm-blog-callout"));
	$tagline = $marks ? $settings["marks-blog-callout"] : $settings["ncm-blog-callout"];
	$title = $marks ? "Marketing Education" : "NCM Blog";
	// Get the 15 most recent posts.
	if ($marks) {
		$posts = $dogwood->getPageOfPosts(0, 15, "author = 2");
	} else {
		$posts = $dogwood->getPageOfPosts(0, 15, "author != 2");
	}
	
?><rss version="2.0">
	<channel>
		<title><?=$title?></title>
		<link><?=$blog_link?></link>
		<description><?=$tagline?></description>
		<language>en-us</language>
		<generator>BigTree CMS (http://www.bigtreecms.org/)</generator>
		<? foreach ($posts as $post) { ?>
		<item>
			<title><?=$post["title"]?></title>
			<description><![CDATA[<?=$post["blurb"]?>]]></description>
			<link><?=$blog_link."post/".$post["route"]?>/</link>
			<author><?=$post["author"]["email"]?></author>
			<pubDate><?=date("D, d M Y H:i:s T",strtotime($post["date"]))?></pubDate>
		</item>
		<? } ?>
	</channel>
</rss><? die(); ?>