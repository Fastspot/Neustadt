<?
	$clientsMod = new NCMClients;
	$caseMod = new NCMCaseStudies;
	$creativeMod = new NCMCreativeItems;
	
	$casesLink = $cms->getLink(14);
	$portfolioLink = $cms->getLink(6);
	
	$colleges = $clientsMod->getMatching("type","college","name ASC",false);
	$independent = $clientsMod->getMatching("type","independent","name ASC",false);
	$institutes = $clientsMod->getMatching("type","institute","name ASC",false);
	$other = $clientsMod->getMatching("type","other","name ASC",false);
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
<div class="client_list block">
	<div class="row">
		<div class="desktop-8 desktop-push-1 tablet-6 mobile-full intro">
			<?=$page_content?>
		</div>
		<div class="desktop-push-1 desktop-3 tablet-2 mobile-full margin_top">
			<h2>Colleges and Universities</h2>
			<hr class="short" />
			<ul>
				<? 
					foreach ($colleges as $item){ 
					if ($cases = $caseMod->getMatching("client",$item["id"])){
						$caseLink = $casesLink."details/".$cases[0]["route"];
					}
					
					if ($creatives = $creativeMod->getMatching("client",$item["id"])){
						$creativeLink = $portfolioLink."client/".$item["id"];
					}
				?>
				<li>
					<?=$item["name"]?>
					<? if ($cases || $creatives){ ?>
					<ul class="sub">
						<? if ($cases){ ?><li><a href="<?=$caseLink?>">Case Study</a></li><? } ?>
						<? if ($creatives){ ?><li><a href="<?=$creativeLink?>">Samples</a></li><? } ?>
					</ul>
					<? } ?>
				</li>
				<? } ?>
			</ul>
		</div>
		<div class="desktop-3 tablet-2 mobile-full margin_top">
			<h2>Independent Schools</h2>
			<hr class="short" />
			<ul>
				<? 
					foreach ($independent as $item){ 
					if ($cases = $caseMod->getMatching("client",$item["id"])){
						$caseLink = $casesLink."details/".$cases[0]["route"];
					}
					
					if ($creatives = $creativeMod->getMatching("client",$item["id"])){
						$creativeLink = $portfolioLink."client/".$item["id"];
					}
				?>
				<li>
					<?=$item["name"]?>
					<? if ($cases || $creatives){ ?>
					<ul class="sub">
						<? if ($cases){ ?><li><a href="<?=$caseLink?>">Case Study</a></li><? } ?>
						<? if ($creatives){ ?><li><a href="<?=$creativeLink?>">Samples</a></li><? } ?>
					</ul>
					<? } ?>
				</li>
				<? } ?>
			</ul>
		</div>
		<div class="desktop-3 tablet-2 mobile-full margin_top">
			<h2>Professional Schools, Centers, and Institutes</h2>
			<hr class="short" />
			<ul>
				<? 
					foreach ($institutes as $item){ 
					if ($cases = $caseMod->getMatching("client",$item["id"])){
						$caseLink = $casesLink."details/".$cases[0]["route"];
					}
					
					if ($creatives = $creativeMod->getMatching("client",$item["id"])){
						$creativeLink = $portfolioLink."client/".$item["id"];
					}
				?>
				<li>
					<?=$item["name"]?>
					<? if ($cases || $creatives){ ?>
					<ul class="sub">
						<? if ($cases){ ?><li><a href="<?=$caseLink?>">Case Study</a></li><? } ?>
						<? if ($creatives){ ?><li><a href="<?=$creativeLink?>">Samples</a></li><? } ?>
					</ul>
					<? } ?>
				</li>
				<? } ?>
			</ul>
			<h2>Other Nonprofit Organizations</h2>
			<hr class="short" />
			<ul>
				<? 
					foreach ($other as $item){ 
					if ($cases = $caseMod->getMatching("client",$item["id"])){
						$caseLink = $casesLink."details/".$cases[0]["route"];
					}
					
					if ($creatives = $creativeMod->getMatching("client",$item["id"])){
						$creativeLink = $portfolioLink."client/".$item["id"];
					}
				?>
				<li>
					<?=$item["name"]?>
					<? if ($cases || $creatives){ ?>
					<ul class="sub">
						<? if ($cases){ ?><li><a href="<?=$caseLink?>">Case Study</a></li><? } ?>
						<? if ($creatives){ ?><li><a href="<?=$creativeLink?>">Samples</a></li><? } ?>
					</ul>
					<? } ?>
				</li>
				<? } ?>
			</ul>
		</div>
	</div>
</div>
