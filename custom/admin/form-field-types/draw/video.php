<?
	
	if (!is_array($field["value"])) {
		$field["value"] = array(
			"id" => $field["value"]
		);
	}
	
?>
<select name="<?=$field["key"]?>[type]">
	<option value="youtube"<?=($field["value"]["type"] == "youtube" ? " selected" : "")?>>YouTube</option>
	<option value="vimeo"<?=($field["value"]["type"] == "vimeo" ? " selected" : "")?>>Vimeo</option>
</select>
<div style="clear: both; display: block; margin-bottom: 20px;"></div>
<input<? if ($field["required"]) { ?> class="required"<? } ?> type="text" tabindex="<?=$field["tabindex"]?>" name="<?=$field["key"]?>[id]" value="<?=$field["value"]["id"]?>" id="<?=$field["id"]?>" placeholder="YouTube or Vimeo ID" />
<input type="hidden" name="<?=$field["key"]?>[image]" value="<?=$field["value"]["image"]?>" />
<input type="hidden" name="<?=$field["key"]?>[existing_id]" value="<?=$field["value"]["existing_id"]?>" />
<? if ($field["value"]["image"]) { ?>
<div class="currently">
	<div class="currently_wrapper">
		<img src="<?=htmlspecialchars($field["value"]["image"])?>" alt="" />
	</div>
	<label>CURRENT</label>
</div>
<? } ?>