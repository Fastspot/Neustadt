<?
	
	$categories = $dogwood->getCategories();
	$settings = $cms->getSettings(array("marks-blog-callout","ncm-blog-callout","ncm-blog-sidebar-header"));
	$marksLink = $cms->getLink(21);
	$ncmLink = $cms->getLink(20);
	
?>
<aside class="desktop-3 tablet-2 mobile-full blog_sidebar">
	<?
		if (!$marks){ 
	?>
	<div class="ncm_blurb">
		<?=$settings["ncm-blog-sidebar-header"]?>
	</div>
	<h3>Categories</h3>
	<ul>
		<? foreach ($categories as $item){ ?>
		<li><a href="<?=$blog_link?>category/<?=$item["route"]?>/"><?=$item["title"]?></a></li>
		<? } ?>
	</ul>
	
	<a href="<?=$marksLink?>">
		<div class="blog_callout mark_callout">
			<h4>Mark's Blog</h4>
			<h3>Marketing Education</h3>
			<p class="clear"><?=$settings["marks-blog-callout"]?></p>
			<span class="action">Read More</span>
		</div>
	</a>
	<? 
		} else { 
		
		$mark = $dogwood->getAuthor(2);
	?>
	<h3>Mark Neustadt</h3>
	<figure class="mark_photo">
 		<img src="<?=$www_root?>images/mark_banner_small.jpg" alt="Mark Neustadt" />
	</figure>
	<div class="mark_bio"><?=$mark["biography"]?></div>
	
	<h3>Categories</h3>
	<ul>
		<? foreach ($categories as $item){ ?>
		<li><a href="<?=$blog_link?>category/<?=$item["route"]?>/"><?=$item["title"]?></a></li>
		<? } ?>
	</ul>
	
	<a href="<?=$ncmLink?>">
		<div class="blog_callout mark_callout">
			<h4>NCM Blog</h4>
			<h3>Research in Action</h3>
			<p class="clear"><?=$settings["ncm-blog-callout"]?></p>
			<span class="action">Read More</span>
		</div>
	</a>
	<? 
		} 
	?>
	
</aside>