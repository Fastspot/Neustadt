<?
	$phraseMod = new NCMPhrases;
	$phrases = $phraseMod->getApproved("RAND()");
	$phrase = $phrases[0];

	$clientsMod = new NCMClients;
	$clients = $clientsMod->getFeatured("position DESC",9);

	$caseMod = new NCMCaseStudies;

	$projectsMod = new NCMHomepageProjects;
	$projects = $projectsMod->getApproved("RAND()",10);

	$creativeMod = new NCMCreativeItems;

	$blurbs = $cms->getSettings(array("strategy-blurb","research-blurb","creative-blurb"));
	$phaseMod = new NCMPhases;
	$researchPhases = $phaseMod->getMatching(array("type","homepage"),array("research","on"),"position DESC");
	$strategyPhases = $phaseMod->getMatching(array("type","homepage"),array("strategy","on"),"position DESC");
	$creativePhases = $phaseMod->getMatching(array("type","homepage"),array("creative","on"),"position DESC");

	$researchMod = new NCMResearchFindings;
	$research = $researchMod->getApproved("RAND()",1);
	$research = $research[0];

	$blogHighlightsMod = new NCMBlogHighlights;
	$highlight = $blogHighlightsMod->getApproved("RAND()",1);
	$highlight = $highlight[0];

	$clientsLink = $cms->getLink(17);
	$casesLink = $cms->getLink(14);
	$portfolioLink = $cms->getLink(6);
	$ncmBlogLink = $cms->getLink(20);
	$markBlogLink = $cms->getLink(21);
?>

<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$phrase["line1"]?></span>
		</div>
	</div>
	<? if ($phrase["line2"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$phrase["line2"]?></span>
		</div>
	</div>
	<? } ?>
	<? if ($phrase["line3"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$phrase["line3"]?></span>
		</div>
	</div>
	<? } ?>
	<? if ($phrase["line4"]){ ?>
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$phrase["line4"]?></span>
		</div>
	</div>
	<? } ?>
</h1>
<div class="home_clients block">
	<div class="row">
		<div class="desktop-11 desktop-push-1 tablet-6 mobile-full">
			<h2>Select Client List</h2>
			<hr class="short" />
		</div>
		<div class="desktop-7 desktop-push-1 tablet-4 mobile-full">
			<ul class="clients">
				<? foreach($clients as $item){ ?>
				<li><?=$item["name"]?></li>
				<? } ?>
			</ul>
		</div>
		<div class="desktop-4 tablet-2 mobile-full">
			<a class="action" href="<?=$clientsLink?>">Complete Client List</a>
			<a class="action" href="<?=$casesLink?>">Case Studies</a>
		</div>
	</div>
</div>
<div class="featured_projects bg_white block">
	<div class="row">
		<h2>Featured Projects</h2>
		<hr class="short centered" />
		<div class="roller projects has_counter sizer sizer-update">
			<menu class="controls roller-controls">
				<span class="roller-control previous">Previous</span>
				<span class="current">1</span>/<span class="count">1</span>
				<span class="roller-control next">Next</span>
			</menu>
			<div class="roller-canister">
				<?
					foreach ($projects as $project){
						$client = $clientsMod->get($project["client"]);
						$gallery = array();
						foreach($project["galleries"] as $item) {
							$creative = $creativeMod->get($item);
							foreach($creative["gallery"] as $image) {
								$gallery[] = $image;
							}
						}
						$phases = array();
						foreach($project["phases"] as $item){
							$phase = $phaseMod->get($item);
							$phases[] = $phase["short_name"];
						}
						if ($cases = $caseMod->getMatching("client",$client["id"])){
							$link = $casesLink."details/".$cases[0]["route"];
						} else if ($creatives = $creativeMod->getMatching("client",$client["id"])){
							$link = $portfolioLink."client/".$client["id"];
						}
				?>
				<div class="roller-item sizer-item">
					<div class="desktop-9 tablet-6 mobile-full gallery roller">
						<menu class="controls">
							<span class="roller-control previous">Previous</span>
							<span class="roller-control next">Next</span>
						</menu>
						<div class="roller-canister">
							<?
								foreach($gallery as $img) {
							?>
							<div class="roller-item">
								<?
									if ($img["video"]) {
										$video = "//player.vimeo.com/video/" . $img["video"];
								?>
								<figure class="video_frame">
									<iframe src="<?=$video?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								</figure>
								<?
									} else {
								?>
								<figure>
									<img src="<?=BigTree::prefixFile($img["image"],"med_")?>" alt="">
								</figure>
								<?
									}
								?>
							</div>
							<?
								}
							?>
						</div>
					</div>
					<div class="desktop-3 tablet-6 mobile-full info">
						<h3><?=$client["name"]?></h3>
						<h4>In Brief</h4>
						<?=$project["in_brief"]?>
						<h4>Project Phases</h4>
						<p><?=implode(", ",$phases)?></p>
						<? if (!$project["hide_link"]) { ?>
						<a href="<?=$link?>" class="action">More About this Project</a>
						<? } ?>
					</div>
				</div>
				<? } ?>
			</div>
		</div>
	</div>
</div>
<div class="home_services block">
	<div class="row">
		<div class="desktop-8 desktop-push-1 tablet-6 mobile-full intro">
			<div class="intro"><?=$services_intro?></div>
		</div>
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
<div class="home_cards block sizer" data-sizer-disable-width="980">
	<div class="row">
		<div class="desktop-6 tablet-6 mobile-full section research">
			<h2>Research Findings</h2>
			<hr class="short" />
			<div class="card bg_white sizer-item">
				<div class="display">
					<span class="number"><?=$research["number"]?></span><span class="percent"><?=$research["label"]?></span>
				</div>
				<p><?=$research["content"]?></p>
				<div class="clear"></div>
				<span class="credit">Credit: <?=$research["credit"]?></span>
				<a href="<?=$ncmBlogLink?>" class="action">More on NCM Blog</a>
			</div>
		</div>
		<div class="desktop-6 tablet-6 mobile-full section blog_blurb">
			<h2>Blog Highlights</h2>
			<hr class="short" />
			<a class="blog_link ncm action" href="<?=$ncmBlogLink?>">NCM Blog</a>
			<a class="blog_link mark action" href="<?=$markBlogLink?>">Mark's Blog</a>
			<div class="card bg_gray sizer-item">
				<?=$highlight["content"]?>
				<h3><?=$highlight["post_title"]?></h3>
				<? foreach ($highlight["links"] as $link){ ?>
				<a href="<?=$link["link_url"]?>" class="action"><?=$link["link_title"]?></a>
				<? } ?>
			</div>
		</div>
	</div>
</div>