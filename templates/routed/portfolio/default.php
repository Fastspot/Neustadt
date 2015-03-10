<?
	$creativeMod = new NCMCreativeItems;

	$categoriesMod = new NCMCreativeCategories;
	$categories = $categoriesMod->getAll();

	$clientsMod = new NCMClients;
	$catMod = new NCMCreativeSubcategories;

	$clientFilter = false;

	if ($bigtree["commands"][0] == "category"){
		$activeRoute = $bigtree["commands"][1];
		$activeCat = $categoriesMod->getByRoute($activeRoute);
		$creative = $creativeMod->getByCategories($activeCat["subcategories"]);
	} else if ($bigtree["commands"][0] == "client"){
		$clientFilter = true;
		$activeClient = $clientsMod->get($bigtree["commands"][1]);
		$creative = $creativeMod->getMatching("client",$bigtree["commands"][1],"position DESC, id ASC");
	} else {
		$creative = $creativeMod->getAll("position DESC");
	}

	$threeRowCount = ceil(count($creative)/3);
	$twoRowCount = ceil(count($creative)/2);
	$pageLink = $cms->getLink($page["id"]);


?>
<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header1?></span>
		</div>
	</div>
	<? if ($header2){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header2?></span>
		</div>
	</div>
	<? } ?>
	<? if ($header3){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header3?></span>
		</div>
	</div>
	<? } ?>
	<? if ($header4){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$header4?></span>
		</div>
	</div>
	<? } ?>
</h1>
<div class="row">
	<div class="desktop-9 desktop-push-1 tablet-6 mobile-full page_content">
		<?=$page_intro?>
	</div>
	<div class="desktop-11 desktop-push-1 tablet-6 mobile-full">
		<div class="contain left">
			<h2>Our Work<? if ($clientFilter){ echo " for ".$activeClient["name"]; } ?></h2>
			<hr class="short" />
		</div>
		<div class="filters">
			<? if ($clientFilter == false){ ?>
			<? foreach ($categories as $cat){ ?>
			<a <? if ($cat["route"] == $activeCat["route"]){ echo "class='active'"; } ?> href="<?=$pageLink?>category/<?=$cat["route"]?>"><?=$cat["title"]?></a>
			<? } ?>
			<? } ?>
			<a <? if (!$activeCat){ echo "class='active'"; } ?> href="<?=$pageLink?>">Show All</a>
		</div>
	</div>
	<div class="case_studies">
		<?
			$i = 0;
			$j = 0;
			foreach($creative as $item){
				$i++;
				$classes = array();
				if ($i % 3 == 0){
					$classes[] = "last_of_row3";
				}
				if ($i % 2 == 0){
					$classes[] = "last_of_row2";
				}
				if ($i > ($threeRowCount-1)*3){
					$classes[] = "bottom_row3";
				}
				if ($i > ($twoRowCount-1)*2){
					$classes[] = "bottom_row2";
				}

				$client = $clientsMod->get($item["client"]);
				$type = $catMod->get($item["type"]);
		?>
		<div class="desktop-4 tablet-3 mobile-full padded client_logo creative_item <?=implode(" ",$classes)?>">
			<a href="<?=$pageLink?>details/<?=$item["route"]?>/">
				<figure>
					<img src="<?=$item["cover"]?>" alt="">
					<div class="info">
						<div class="title"><?=$client["name"]?></div>
						<div class="type"><?=$type["title"]?></div>
					</div>
				</figure>
			</a>
		</div>
		<? } ?>
	</div>
</div>
