<label><?=$label?><? if ($required) { ?><span class="required">*</span><? } ?></label>
<? foreach ($list as $item) { ?>
<div class="form_builder_option">
	<input type="checkbox"<? if ($item["selected"]) { ?> checked="checked"<? } ?> class="form_builder_checkbox custom_control" /> <?=htmlspecialchars($item["description"])?>
</div>
<? } ?>