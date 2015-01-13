<? 
	$caseMod = new NCMCaseStudies;
	$case = $caseMod->getByRoute($bigtree["commands"][0]);
	
	$creativeMod = new NCMCreativeItems;
	
	$gallery = array();
	if ($case["creative_items"]){ 
		foreach($case["creative_items"] as $item){
			$creative = $creativeMod->get($item);
			foreach($creative["gallery"] as $image){
				$gallery[] = array($image["image"],$image["caption"]);
			}
		}
	}
	
	$bigtree["page"]["title"] = $creative["client"]["name"];
	
	$pageLink = $cms->getLink($page["id"]);
?>
<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$case["header1"]?></span>
		</div>
	</div>
	<? if ($case["header2"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$case["header2"]?></span>
		</div>
	</div>
	<? } ?>
	<? if ($case["header3"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$case["header3"]?></span>
		</div>
	</div>
	<? } ?>
	<? if ($case["header4"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$case["header4"]?></span>
		</div>
	</div>
	<? } ?>
</h1>
<div class="row">
	<div class="desktop-11 desktop-push-1 tablet-6 mobile-full header_padded">
		<div class="back right">
			<a class="action" href="<?=$pageLink?>">Back to Case Studies</a>
		</div>
	</div>
	<div class="desktop-7 desktop-push-1 tablet-4 mobile-full page_content">
		<?=$case["intro_p"]?>
	</div>
	<div class="desktop-4 tablet-2 mobile-full intro_img">
		<figure>
			<img src="<?=$case["intro_img"]?>" alt="" />
			<figcaption><?=$case["intro_caption"]?></figcaption>
		</figure>
	</div>
</div>
<? if (!empty($gallery)){ ?>
<div class="bg_white section featured_projects creative_execution">
	<div class="row block">
		<h2>Creative Execution</h2>
		<hr class="short centered" />
		<div class="roller projects has_counter sizer sizer-update">
			<menu class="controls roller-controls">
				<span class="roller-control previous">Previous</span>
				<span class="current">1</span>/<span class="count">1</span>
				<span class="roller-control next">Next</span>
			</menu>
			<div class="roller-canister">
				<? foreach ($gallery as $item){	?>
				<div class="roller-item sizer-item">
					<figure>
						<img src="<?=$item[0]?>" alt="" />
						<figcaption><?=$item[1]?></figcaption>
					</figure>
				</div>
				<? } ?>
			</div>
		</div>
	</div>	
</div>
<? } ?>
<div class="row block">
	<div class="desktop-7 desktop-push-1 tablet-4 mobile-full page_content">
		<?=$case["content"]?>
	</div>
	<? if ($case["sidebar_gallery"]){ ?>
	<div class="desktop-4 tablet-2 mobile-full sidebar_images">
		<? foreach ($case["sidebar_gallery"] as $figure){ ?>
		<figure>
			<img src="<?=$figure["image"]?>" alt="" />
			<figcaption><?=$figure["caption"]?></figcaption>
		</figure>
		<? } ?>
	</div>
	<? } ?>
</div>
