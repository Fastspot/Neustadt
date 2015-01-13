<label><?=$label?><? if ($required) { ?><span class="required">*</span><? } ?></label>
<?
	$has_default = false;
	foreach ($list as $item) {
		if ($item["selected"]) {
			$has_default = true;
		}
	}
	
	$i = 0;
	foreach ($list as $item) {
		$i++;
?>
<div class="form_builder_option">
	<input type="radio"<? if ($item["selected"] || (!$has_default && $i == 1)) { ?> checked="checked"<? } ?> name="<?=$_POST["name"]?>" class="form_builder_radio custom_control" /> <?=htmlspecialchars($item["description"])?>
</div>
<?
	}
?>