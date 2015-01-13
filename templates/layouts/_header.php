<?
	$homePage = $cms->getPage(0);
	$siteTitle = $homePage["title"];
	$mainNav = $cms->getNavByParent(0, 2);
	$currentURL = BigTree::currentURL();
	$topLevel = $cms->getTopLevelNavigationId();
	$defaultMeta = $cms->getSetting("default-meta-description");
	$metaDescription = ($bigtree["page"]["meta_description"]) ? $bigtree["page"]["meta_description"] : $defaultMeta;
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		
		<meta name="description" content="<?=$metaDescription?>" />
		<meta name="author" content="Neustadt Creative Marketing" />
		
		<title><?=($bigtree["page"]["id"] ? $bigtree["page"]["title"]."&nbsp;&nbsp;&middot;&nbsp;&nbsp;" : "")?><?=$homePage["title"]?></title>
		
		<link rel="canonical" href="<?=WWW_ROOT?>" />
		<link rel="icon" href="<?=WWW_ROOT?>favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="<?=WWW_ROOT?>favicon.ico" type="image/x-icon" />

		<script src="<?=WWW_ROOT?>js/site.js"></script>
		
		<? if ($includeOG){ ?>
		<!-- G+ AND FACEBOOK META TAGS -->
		<meta property="og:title" content="<?=$siteTitle?> &bull; <?=$client["name"]?>" />
		<meta property="og:url" content="<?=BigTree::currentURL()?>" />
		<meta property="og:type" content="website">
		<meta property="og:image" content="<?=$creative["gallery"][0]["image"]?>" />
		<meta property="og:description" content="<?=$creative["gallery"][0]["caption"]?>" />
		<meta property="og:site_name" content="<?=$siteTitle?>" />
		<? } else { ?>
		<meta property="og:title" content="<?=$bigtree["page"]["title"]?>" />
		<meta property="og:url" content="<?=BigTree::currentURL()?>" />
		<meta property="og:type" content="website">
		<meta property="og:image" content="<?=WWW_ROOT?>images/fb-logo.png" />
		<meta property="og:description" content="<?=$metaDescription?>" />
		<meta property="og:site_name" content="<?=$siteTitle?>" />
		<? } ?>
		
		<!-- TWITTER CARD -->
		<meta name="twitter:card" content="photo" />
		<meta name="twitter:site" content="<?=$siteTitle?>" />
		<meta name="twitter:creator" content="Neustadt Creative Marketing" />
		<meta name="twitter:url" content="<?=BigTree::currentURL()?>" />
		<meta name="twitter:title" content="<?=$bigtree["page"]["title"]?>" />
		<meta name="twitter:description" content="<?=$metaDescription?>" />
		<meta name="twitter:image" content="<?=WWW_ROOT?>images/fb-logo.png" />
		
		<link rel="stylesheet" href="<?=WWW_ROOT?>css/site.css" type="text/css" media="all" />
		<link rel="stylesheet" href="<?=WWW_ROOT?>css/print.css" type="text/css" media="print" />
		<!--[if LTE IE 9]>
			<script>
				var OLDIE = true;
			</script>
		<![endif]-->
		<!--[if (LT IE 9) & (!IEMobile)]>
			<link rel="stylesheet" href="<?=WWW_ROOT?>css/ie.css" type="text/css" media="all" />
			<script src="<?=WWW_ROOT?>js/ie.js"></script>
		<![endif]-->
		<!--[if LTE IE 8]>
			<link href="<?=WWW_ROOT?>components/Gridlock/gridlock-ie.css" rel="stylesheet" type="text/css" media="all" />
		<![endif]-->
		<? include "_analytics.php"; ?>
	</head>
	<body class="gridlock<? if ($marks){ echo " marks_blog"; } ?>">
		<div class="nav_slider_page">
			<header id="header">
				<div class="row">
					<div class="top_nav desktop-12 tablet-6 mobile-full">
						<a href="<?=$www_root?>">
							<div class="logo">Neustadt Creative Marketing</div>
						</a>
						<div class="navigation_compact">
							<span class="nav_slider_handle mobile_handle">Navigation</span>
						</div>
						<nav class="main navigation_full">
							<? foreach($mainNav as $item) { ?>
							<div class="top_level<? if ($item["id"] == $topLevel) echo ' active_top'; ?>">
								<a class="nav_item<? if ($item["id"] == $topLevel) echo ' active'; ?>" href="<?=$item["link"]?>"><?=$item["title"]?></a>
								<? if ($item["children"] > 0){ ?>
								<div class="dropdown">
									<? foreach($item["children"] as $child){ ?>
									<a href="<?=$child["link"]?>"><?=$child["title"]?></a>
									<? } ?>
								</div>
								<? } ?>
							</div>
							<? } ?>
						</nav>
					</div>
				</div>
			</header>