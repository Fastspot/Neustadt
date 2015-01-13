<?
	// Get blog settings
	$settings = $cms->getSetting("btx-dogwood-settings");
	// Setup root link for pages (this is equivalent to $cms->getLink($bigtree["page"]["id"]) but saves a SQL call.
	$blog_link = $cms->getLink($bigtree["page"]["id"]);	
	// Instantiate the Dogwood Blog class.
	$dogwood = new BTXDogwood($marks); // if marks
	// Load all the pages in this module into the blog layout.
	//$bigtree["layout"] = "blog";
	// By default we're going to say it's not a detail page.
	//$post_detail = false;
	
	// $marks = page resource!
	if ($marks) {
		$page_header = "Marketing Education";
		$page_subheader = $cms->getSetting("marks_blog_subheader");
	} else {
		$page_header = "NCM Blog";
		$page_subheader = $cms->getSetting("ncm_blog_subheader");
	}
?>
<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$page_header?></span>
			<? if ($page_subheader) { ?>
			<h2 class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$page_subheader?></h2>
			<? } ?>
		</div>
	</div>
</h1>

<div class="row">
	<div class="desktop-8 desktop-push-1 tablet-4 mobile-full page_content blog_content">