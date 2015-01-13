<? 
	
	$tags = $dogwood->getTagsForPost($post["id"]);
	$categories = $dogwood->getCategoriesByPost($post["id"]);
	$commentCount = $dogwood->getCommentCountForPost($post["id"]);
	
?>
<article class="post<? if ($last) { ?> last_post<? } ?>">
	<h2><a href="<?=$blog_link?>post/<?=$post["route"]?>/"><?=$post["title"]?></a></h2>
	<p class="meta">
		By <a href="<?=$blog_link?>author/<?=$post["author"]["route"]?>/" class="author"><?=$post["author"]["name"]?></a> on <span class="date"><?=date("F j, Y",strtotime($post["date"]))?></span>
	</p>
	<?=$post["blurb"]?>
	<div class="links">
		<a href="<?=$blog_link?>post/<?=$post["route"]?>/" class="action">Continue Reading</a>
		<br/>
		<a href="<?=$blog_link?>post/<?=$post["route"]?>/#comments" class="action"><?=$commentCount?> Comment<? if ($commentCount != 1) echo 's'; ?></a>
		<br/>
		<?
			if (count($categories)) {
		?>
		<div class="tags">
			<?
				echo "Posted In:&nbsp;&nbsp;";
				$cat_links = array();
				foreach ($categories as $cat) {
					$cat_links[] = '<a href="'.$blog_link.'category/'.$cat["route"].'/">'.$cat["title"].'</a>';
				}
				echo implode(", ",$cat_links);
			?> 
		</div>
		<?
			}
		
			if (count($tags)) {
		?>
		<div class="tags">
		<?
			echo "Tagged:&nbsp;&nbsp;";
			$tag_links = array();
			foreach ($tags as $tag) {
				$tag_links[] = '<a href="'.$blog_link.'tag/'.$tag["route"].'/">'.$tag["tag"].'</a>';
			}
			echo implode(", ",$tag_links);
		?> 
		</div>
		<?
			}
		?>
	</div>
</article>