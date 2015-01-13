<?
	//$bigtree["layout"] = "blog_detail";

	// Tell the footer to draw the comment thread if we're using Disqus
	$post_detail = true;
	// We've appended the route to the URL, so we're going to grab the last route of the URL and look it up.
	$post = $dogwood->getPostByRoute(end($bigtree["commands"]));
	// Get tags related to this post
	$tags = $dogwood->getTagsForPost($post);
	// Get comments related to this post
	$comments = $dogwood->getCommentsForPost($post);
	// Get comment count
	$commentCount = $dogwood->getCommentCountForPost($post);
	// Set the page title
	$local_title = $post["title"];
	
	$bigtree["page"]["title"] = $local_title;
	
	$comment_values = $_SESSION["comment_values"];
	$comment_errors = $_SESSION["comment_errors"];
	$comment_submitted = $_SESSION["comment_submitted"];
	unset($_SESSION["comment_values"]);
	unset($_SESSION["comment_errors"]);
	unset($_SESSION["comment_submitted"]);
	
	
	// Draw threaded comments
	function _recurseComments($comments) {
		foreach ($comments as $comment) {
			echo '<div class="comment" id="comment_' . $comment["id"] . '" data-comment="' . $comment["id"] . '">';
			echo '<p class="meta">' . $comment["name"] . ' on ' . date("F j, Y",strtotime($comment["date"])) . '</p>';
			echo '<p>' . $comment["comment"] . '<p>';
			echo '<span class="reply">Reply to ' . $comment["name"] . '</span>';
			if (count($comment["replies"])) {
				_recurseComments($comment["replies"]);
			}
			echo '</div>';
		}
	}
	
?>
<article class="post">
	<h2><?=$post["title"]?></h2>
	<p class="meta">
		By <a href="<?=$blog_link?>author/<?=$post["author"]["route"]?>/" class="author"><?=$post["author"]["name"]?></a> on <span class="date"><?=date("F j, Y",strtotime($post["date"]))?></span>
	</p>
	<?
		// If there's an image, draw it.
		if ($post["image"]) {
	?>
	<figure class="image">
		<img src="<?=$post["image"]?>" alt="Image" />
		<figcaption class="caption"><?=$post["caption"]?></figcaption>
	</figure>
	<?
		}
		
		// Echo the full blog post.
		echo $post["content"];
		
		// If we have tags on the post, draw them.
		if (count($tags)) {
			$tag_links = array();
			foreach ($tags as $tag) {
				$tag_links[] = '<a href="'.$blog_link.'tag/'.$tag["route"].'/">'.$tag["tag"].'</a>';
			}
			echo '<p>Tagged: '.implode(", ",$tag_links).'</p>';
		}
	?>
	<div class="author_info clear contain">
		<div class="split left">
			<a href="<?=$blog_link?>author/<?=$post["author"]["route"]?>/">
				<? 
					// If we have an author image we're going to grab the small version (prefixed with "sm_").
					if ($post["author"]["image"]) { 
				?>
				<img src="<?=BigTree::prefixFile($post["author"]["image"], "sm_")?>" alt="" />
				<? 
					}
				?>
				<strong><?=$post["author"]["name"]?></strong>
				<?=$post["author"]["title"]?>
			</a>
		</div>
		<div class="sharing split right">
			<? /* Add This Sharing Widgets */ ?>
			<div class="addthis_toolbox addthis_default_style right">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
			</div>
		</div>
	</div>
	<div class="comments clear" id="comments">
		<h3><?=$commentCount?> Comment<? if ($commentCount != 1) echo 's'; ?></h3>
		<?
			if ($comment_submitted) {
		?>
		<p>Your comment has been submitted and is awaiting approval. 
		<?
			} else if ($commentCount == 0) {
		?>
		<p>Be the first to comment</p>
		<?
			} 
			
			_recurseComments($comments);
		?>
		<div class="comment_form" id="comment_form">
			<div class="form_builder_required_message">
				<p><span class="form_builder_required_star">*</span> = required field</p>
			</div>
			<form method="POST" action="<?=$blog_link?>comment/" enctype="multipart/form-data" class="form_builder">
				<?
					if (count($comment_errors) > 0) {
				?>
				<div class="form_builder_errors">
					<? if ($error_count == 1) { ?>
					<p>A required field was missing. Please fill out all required fields and submit again.</p>
					<? } else { ?>
					<p>Required fields were missing. Please fill out all required fields out and submit again.</p>
					<? } ?>
				</div>
				<?
					}
				?>
				<input type="hidden" name="post" value="<?=$post["id"]?>" />
				<input type="hidden" name="parent" value="0" />
				<input type="hidden" name="return" value="<?=BigTree::currentURL()?>" />
				<input type="text" name="website" class="website" />
				<fieldset>
					<label for="form_name">Name<span class="form_builder_required_star">*</span></label>
					<input type="text" id="form_name" name="name" class="form_builder_text form_builder_required<? if ($comment_errors["name"]) echo ' form_builder_error'; ?>" value="<?=$comment_values["name"]?>" placeholder="" />
				</fieldset>
				<fieldset>
					<label for="form_email">Email Address<span class="form_builder_required_star">*</span></label>
					<input type="text" id="form_email" name="email" class="form_builder_text form_builder_email form_builder_required<? if ($comment_errors["email"]) echo ' form_builder_error'; ?>" value="<?=$comment_values["email"]?>" placeholder="" />
				</fieldset>
				<fieldset>
					<label for="form_comment">Comment<span class="form_builder_required_star">*</span></label>
					<textarea id="form_comment" name="comment" class="form_builder_required<? if ($comment_errors["comment"]) echo ' form_builder_error'; ?>" placeholder=""><?=$comment_values["comment"]?></textarea>
				</fieldset>
				<input type="submit" class="form_builder_submit" value="Submit" />
			</form>
		</div>
	</div>
</article>