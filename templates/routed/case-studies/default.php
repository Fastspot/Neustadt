<?
	$caseMod = new NCMCaseStudies;
	$caseStudies = $caseMod->getAll("position DESC, id ASC");
	$threeRowCount = ceil(count($caseStudies)/3);
	$twoRowCount = ceil(count($caseStudies)/2);
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
	<div class="case_studies">
		<? 
			$i = 0;
			$j = 0;
			foreach($caseStudies as $item){
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
		?>
		<div class="desktop-4 tablet-3 mobile-full padded client_logo <?=implode(" ",$classes)?>">
			<a href="<?=$pageLink?>details/<?=$item["route"]?>/">
				<figure>
					<img src="<?=$item["logo"]?>" alt="Madeira" />
				</figure>
			</a>
		</div>
		<? } ?>
	</div>
</div>
