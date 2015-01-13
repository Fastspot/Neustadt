<?
	$blurbs = $cms->getSettings(array("strategy-blurb","research-blurb","creative-blurb"));
	$phaseMod = new NCMPhases;
	$researchPhases = $phaseMod->getMatching("type","research","position DESC");
	$strategyPhases = $phaseMod->getMatching("type","strategy","position DESC");
	$creativePhases = $phaseMod->getMatching("type","creative","position DESC");
?>
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
		<?=$page_content_above?>
	</div>
</div>
<div class="home_services block">
	<div class="row">
		<div class="desktop-push-1 desktop-3 tablet-2 mobile-half min-full margin_top">
			<h2>Research</h2>
			<p><?=$blurbs["research-blurb"]?></p>
			<hr class="short" />
			<ul>
				<? foreach ($researchPhases as $item){ ?>
				<li><?=$item["long_name"]?></li>
				<? } ?>
			</ul>
		</div>
		<div class="desktop-3 tablet-2 mobile-half min-full margin_top">
			<h2>Strategy</h2>
			<p><?=$blurbs["strategy-blurb"]?></p>
			<hr class="short" />
			<ul>
				<? foreach ($strategyPhases as $item){ ?>
				<li><?=$item["long_name"]?></li>
				<? } ?>
			</ul>
		</div>
		<div class="desktop-3 tablet-2 mobile-full margin_top">
			<h2>Creative</h2>
			<p><?=$blurbs["creative-blurb"]?></p>
			<hr class="short" />
			<ul>
				<? foreach ($creativePhases as $item){ ?>
				<li><?=$item["long_name"]?></li>
				<? } ?>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="desktop-9 desktop-push-1 tablet-6 mobile-full page_content">
		<?=$page_content_below?>
	</div>
</div>