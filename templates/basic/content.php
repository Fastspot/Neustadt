<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header_line1?></span>
		</div>
	</div>
	<? if ($header_line2){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header_line2?></span>
		</div>
	</div>
	<? } ?>
	<? if ($header_line3){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header_line3?></span>
		</div>
	</div>
	<? } ?>
	<? if ($header_line4){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header_line4?></span>
		</div>
	</div>
	<? } ?>
</h1>
<div class="row">
	<div class="desktop-9 desktop-push-1 tablet-6 mobile-full page_content">
		<?=$page_content?>
	</div>
</div>
<div class="row block">
	<? if ($gallery){ ?>
	<div class="desktop-12 tablet-6 mobile-full roller has_counter photo_gallery sizer sizer-update block">
		<h2>The Studio in Pictures</h2>
		<hr class="short centered" />
		<menu class="controls roller-controls">
			<span class="roller-control previous">Previous</span>
			<span class="current">1</span>/<span class="count">1</span>
			<span class="roller-control next">Next</span>
		</menu>
		<div class="roller-canister">
			<? foreach ($gallery as $image){ ?>
			<div class="roller-item sizer-item">
				<a href="<?=$image["image"]?>" class="boxer" title="<?=$image["caption"]?>" rel="gallery">
					<img src="<?=BigTree::prefixFile($image["image"],"lrg_")?>" alt="<?=$image["caption"]?>" />
					<? if ($image["caption"]){ ?>
					<div class="caption">
						<p><?=$image["caption"]?></p>
					</div>
					<? } ?>
				</a>
			</div>
			<? } ?>
		</div>
	</div>
	<? } ?>
</div>
