<?
	$peopleMod = new NCMPeople;
	$people = $peopleMod->getApproved("RAND()",false);
	$peopleOrdered = $peopleMod->getApproved("position DESC",false);
	
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
		<?=$page_content?>
	</div>
</div>
<div class="block bg_white people_grid">
	<div class="row">
		<div class="desktop-12 tablet-6 mobile-full">
			<h2 class="centered">Our Team</h2>
			<hr class="short centered" />
		</div>
	</div>
	<div class="row grid">
		<? if (count($people)){ ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[0]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[0]["image"],"th_")?>" />
				<div class="info">
					<h3><?=$people[0]["name"]?></h3>
					<span class="title"><?=$people[0]["title"]?></span>
				</div>
			</a>
		</div>
		<? } ?>
		<? if (count($people) > 1) { ?>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<div class="desktop-4 tablet-2 mobile-half double">
			<a href="#<?=$people[1]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[1]["image"],"wide_")?>" />
				<div class="info">
					<h3><?=$people[1]["name"]?></h3>
					<span class="title"><?=$people[1]["title"]?></span>
				</div>
			</a>
		</div>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<? } ?>
		<? if (count($people) > 2) { ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[2]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[2]["image"],"th_")?>" />
				<div class="info left">
					<h3><?=$people[2]["name"]?></h3>
					<span class="title"><?=$people[2]["title"]?></span>
				</div>
			</a>
		</div>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<? } ?>
		<? if (count($people) > 3) { ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[3]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[3]["image"],"th_")?>" />
				<div class="info">
					<h3><?=$people[3]["name"]?></h3>
					<span class="title"><?=$people[3]["title"]?></span>
				</div>
			</a>
		</div>
		<? } ?>
		<? if (count($people) > 4) { ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[4]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[4]["image"],"th_")?>" />
				<div class="info">
					<h3><?=$people[4]["name"]?></h3>
					<span class="title"><?=$people[4]["title"]?></span>
				</div>
			</a>
		</div>
		<? } ?>
		<? if (count($people) > 5) { ?>
		<div class="desktop-4 tablet-2 mobile-half double">
			<a href="#<?=$people[5]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[5]["image"],"wide_")?>" />
				<div class="info left">
					<h3><?=$people[5]["name"]?></h3>
					<span class="title"><?=$people[5]["title"]?></span>
				</div>
			</a>
		</div>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<? } ?>
		<? if (count($people) > 6) { ?>
		<div class="desktop-4 tablet-2 mobile-half double">
			<a href="#<?=$people[6]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[6]["image"],"wide_")?>" />
				<div class="info">
					<h3><?=$people[6]["name"]?></h3>
					<span class="title"><?=$people[6]["title"]?></span>
				</div>
			</a>
		</div>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<? } ?>
		<? if (count($people) > 7) { ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[7]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[7]["image"],"th_")?>" />
				<div class="info">
					<h3><?=$people[7]["name"]?></h3>
					<span class="title"><?=$people[7]["title"]?></span>
				</div>
			</a>
		</div>
		<div class="desktop-2 tablet-1 mobile-half placeholder_1">
			
		</div>
		<? } ?>
		<? if (count($people) > 8) { ?>
		<div class="desktop-2 tablet-1 mobile-half single">
			<a href="#<?=$people[8]["route"]?>">
				<img src="<?=BigTree::prefixFile($people[8]["image"],"th_")?>" />
				<div class="info left">
					<h3><?=$people[8]["name"]?></h3>
					<span class="title"><?=$people[8]["title"]?></span>
				</div>
			</a>
		</div>
		<? } ?>
	</div>
</div>
<div class="block people_list">
	<? foreach ($peopleOrdered as $profile) { ?>
	<div class="row profile" id="<?=$profile["route"]?>">
		<div class="desktop-4 desktop-push-1 tablet-2 mobile-full">
			<img src="<?=$profile["image"]?>" />
		</div>
		<div class="desktop-6 tablet-4 mobile-full info">
			<h2><?=$profile["name"]?></h2>
			<span class="title"><?=$profile["title"]?></span>
			<?=$profile["bio"]?>
		</div>
	</div>
	<? } ?>
</div>
