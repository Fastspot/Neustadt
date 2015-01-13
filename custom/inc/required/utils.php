<?	
	
	function creativeItemCallback($id, $data, $state) {
		global $cms;
		$creativeMod = new NCMCreativeItems;
		
		$clientsMod = new NCMClients;
		$client = $clientsMod->get($data["client"]);
		
		$catMod = new NCMCreativeSubcategories;
		$type = $catMod->get($data["type"]);
		
		$title = $client["name"]." ".$type["title"];
		$route = $cms->urlify($title);
		$creativeMod->update($id, array("descriptive_title","route"), array($title,$route));
	}
	
	function caseStudyCallback($id, $data, $state) {
		global $cms;
		$caseStudyMod = new NCMCaseStudies;
		
		$clientsMod = new NCMClients;
		$client = $clientsMod->get($data["client"]);
		
		$title = $client["name"];
		$route = $cms->urlify($title);
		$caseStudyMod->update($id,"route",$route);
	}
	
	function targetBlank($url) {
		if (BigTree::isExternalLink($url)) {
			return ' target="_blank"';
		}
		return '';
	}
	
	function recurseNav($nav) {
		global $currentURL;
		
		$i = 0;
		$count = count($nav) - 1;
		foreach ($nav as $item) { 
			$isActive = ($currentURL === $item["link"]);
			$isOpen = (strpos($currentURL, $item["link"]) > -1);
			$hasChildren = (is_array($item["children"]) && count($item["children"]) > 0);
		?>
		<div class="item<? if ($i == $count) echo ' last'; ?>">
			<a href="<?=$item["link"]?>" class="<? if ($isActive) echo ' active'; if ($isOpen) echo ' open'; if ($hasChildren) echo ' has_children'; ?>"<?=targetBlank($item["link"])?>><?=strip_tags(htmlspecialchars_decode($item["title"]))?></a>
			<? if ($hasChildren) { ?>
			<div class="children">
				<? recurseNav($item["children"]); ?>
			</div>
			<? } ?>
		</div>
		<?
			$i++;
		}
	}
	
	function youTubeEmbed($id, $autoplay = false) {
		return "http://www.youtube.com/embed/" . $id . "?rel=0&color=white&modestbranding=1&showinfo=0&autohide=1&theme=light&html5=1" . ($autoplay ? "&autoplay=1" : "");
	}
	
	function vimeoEmbed($id, $autoplay = false) {
		return "http://player.vimeo.com/video/" . $id . "?color=ffffff&byline=0&portrait=0&title=0" . ($autoplay ? "&autoplay=1" : "");
	}
	
	/* MIMEO
	   PASS ARRAY OF IMAGES AS KEY => VAL PAIRS
	   'Infinity' FOR LARGEST size

		<?=mimeoImage(array(
			"Infinity" => $img, 
			"1240" => $img, 
			"980" => $img, 
			"740" => $img,
			"500" => $img,
			"340" => $img
		))?>
	*/
	function mimeoImage($images, $class = "", $alt = "", $defer = false) {
		$html = '<picture class="mimeo ' . $class . '">';
		foreach ($images as $size => $image) {
			$html .= '<source media="(max-width: ' . $size . ($size == "Infinity" ? '' : 'px') . ')" src="' . $image . '" />';
		}
		$html .= '<source src="' . end($images) . '" />';
		$html .= '<img';
		if (!$defer) {
			$html .= ' src="' . end($images) . '"';
		}
		$html .= ' alt="' . $alt . '" />';
		$html .= '</picture>';
		return $html;
	}
	
	function generateYouTubeURL($id,$autoplay = 1) {
		return "https://www.youtube.com/embed/$id?controls=1&modestbranding=1&rel=0&showinfo=0&color=white&autoplay=$autoplay";
	} 
	
	$state_list = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia", 'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
?>