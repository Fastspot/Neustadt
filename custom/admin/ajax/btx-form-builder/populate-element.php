<?
	$required = false;
	$label = false;
	BigTree::globalizePOSTVars();
	
	$type = trim($_POST["type"]);
	
	if ($_POST["list"]) {
		foreach ($_POST["list"] as $key => $item) {
			if ($item["price"]) {
				$item["price"] = floatval(str_replace(array('$',',',' '),'',$item["price"]));
			} else {
				$item["price"] = "0";
			}
			$_POST["list"][$key] = $item;
		}
	}

	$key = str_replace("form_builder_element_","",$_POST["name"]);
?>
<input type="hidden" name="id[<?=$key?>]" value="<?=$id?>" />
<input type="hidden" name="type[<?=$key?>]" value="<?=$type?>" />
<input type="hidden" name="data[<?=$key?>]" value="<?=htmlspecialchars(json_encode($_POST))?>" />
<div class="form_builder_wrapper">
	<span class="icon"></span>
	<?
		include "populate-types/$type.php";
	?>
</div>
<div class="form_builder_controls">
	<a href="#" class="icon_small icon_small_edit"></a>
	<a href="#" class="icon_small icon_small_delete"></a>
</div>