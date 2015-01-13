<? $page_content = $cms->getSetting("404-content"); ?>
<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full">Uh-oh!</span>
		</div>
	</div>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full">It looks like you're a little lost.</span>
		</div>
	</div>
</h1>
<div class="row">
	<div class="desktop-9 desktop-push-1 tablet-6 mobile-full page_content">
		<?=$page_content?>
	</div>
</div>