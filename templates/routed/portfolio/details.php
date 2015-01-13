<? 
	$creativeMod = new NCMCreativeItems;
	$creative = $creativeMod->getByRoute($bigtree["commands"][0]);
	
	$pageLink = $cms->getLink($page["id"]);
	
	$bigtree["page"]["title"] = $creative["descriptive_title"];
	
	// OPEN GRAPH TAGS IN HEAD FOR PINTEREST / FACEBOOK
	$includeOG = true;
?>
<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$creative["client"]["name"]?></span>
		</div>
	</div>
</h1>
<div class="row">
	<div class="desktop-12 tablet-6 mobile-full featured_projects creative_gallery">
		<div class="roller projects has_counter sizer sizer-update<? if ($creative["attribution"]){ echo " w_attribution"; } ?>">
			<div class="header_padded">
				<div class="type left"><?=$creative["type"]["title"]?></div>
				<div class="back right">
					<a class="action" href="<?=$pageLink?>category/<?=$creative["category"]["route"]?>">Back to <?=$creative["category"]["title"]?></a>
				</div>
				<menu class="controls roller-controls">
					<span class="roller-control previous">Previous</span>
					<span class="current">1</span>/<span class="count">1</span>
					<span class="roller-control next">Next</span>
				</menu>
			</div>
			<div class="roller-canister">
				<? foreach ($creative["gallery"] as $item){	?>
				<div class="roller-item sizer-item">
					<figure>
						<img src="<?=$item["image"]?>" alt="" />
					</figure>
					
						<div class="desktop-10 desktop-push-1 tablet-6 mobile-full">
							<p><?=$item["caption"]?></p>
						</div>
				</div>
				<? } ?>
			</div>
			<? if ($creative["attribution"]){ ?>
			<div class="attribution desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$creative["attribution"]?></div>
			<? } ?>
		</div>
	</div>
</div>
<? if ($creative["related"]) { ?>
<div class="bg_white block">
	<div class="row">
		<div class="desktop-12 tablet-6 mobile-full related_work sizer">
			<h2>Related Work</h2>
			<hr class="short" />
			<div class="row">
				<? 
					foreach ($creative["related"] as $item) { 
						/*
						$client = $clientsMod->get($item["client"]);
						$type = $subcategoriesMod->get($item["type"]);
						*/
				?>
				<a href="<?=$pageLink?>details/<?=$item["route"]?>">
					<div class="desktop-2 tablet-2 mobile-half">
						<div class="sizer-item">
							<h3><?=$item["client"]["name"]?></h3>
							<h4><?=$item["type"]["title"]?></h4>
							<figure>
								<img src="<?=$item["cover"]?>" alt />
							</figure>
						</div>
					</div>
				</a>
				<? } ?>
			</div>
		</div>
	</div>
</div>
<? } ?>