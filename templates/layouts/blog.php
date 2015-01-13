<? include "_header.php" ?>
<div class="row">
	<div class="desktop-8 tablet-4 mobile-full page_content">
		<h1><?=$page_header?></h1>
	</div>
</div>
<div class="row">
	<div class="desktop-8 tablet-4 mobile-full">
		<?=$bigtree["content"]?>
	</div>
	<div class="desktop-4 tablet-2 mobile-full blog_sidebar">
		<? include "partial/_blog-sidebar.php"; ?>
	</div>
</div>
<? include "_footer.php" ?>