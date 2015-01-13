<?
	$action_title = "View Entry";
	include "_head.php";
	$entry = $fb->getEntry(end($path));
	$form = $fb->get($entry["form"]);
	
	function _draw_form_builder_form_fields($fields) {
		global $entry;
		foreach ($fields as $field) {
			$t = $field["type"];
			$v = $entry["data"][$field["id"]];
			$field["data"] = json_decode($field["data"],true);
			$label = $field["data"]["label"];
			if (!$label) {
				$label = ucwords($t);
			}

			if ($t == "column") {
				_draw_form_builder_form_fields($field["fields"]);
			} elseif ($t != "section") {
				echo "<fieldset>";
				echo "<label><strong>$label</strong></label>";
				echo "<p>";
				if ($t == "name") {
					echo $v["first"]." ".$v["last"]."";
				} elseif ($t == "address") {
					echo $v["street"]."<br />";
					if ($v["street2"]) {
						echo $v["street2"]."<br />";
					}
					echo $v["city"].", ".$v["state"]." ".$v["zip"]."<br />".$v["country"]."";
				} elseif ($t == "checkbox") {
					if (is_array($v)) {
						echo implode(", ",$v)."";
					} else {
						echo $v;
					}
				} elseif ($t == "upload") {
					echo '<a href="'.$v.'">'.$v.'</a>';
				} else {
					echo $v;
				}
				echo "</p>";
				echo "</fieldset>";
			}
		}
	}
?>
<div class="container">
	<header>
		<h2>Entry Details <small>from <?=$form["title"]?></small></h2>
		<a href="javascript:history.go(-1);" class="back">Back</a>
	</header>
	<section>
		<fieldset>
			<label><strong>Date Created</strong></label>
			<p><?=date("F j, Y @ g:ia",strtotime($entry["created_at"]))?></p>
		</fieldset>
		<? _draw_form_builder_form_fields($form["fields"]) ?>
	</section>
</div>