<label><?=$label?><? if ($required) { ?><span class="required">*</span><? } ?></label>
<select class="custom_control">
	<? foreach ($list as $item) { ?>
	<option value="<?=htmlspecialchars($item["value"])?>"<? if ($item["selected"]) {?> selected="selected"<? } ?>><?=htmlspecialchars($item["description"])?></option>
	<? } ?>
</select>