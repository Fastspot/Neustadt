<!--
<h4>Positioning</h4>
<fieldset>
	<input type="radio" name="positioning" <? if ($data["positioning"] == "top") { ?> checked="checked"<? } ?> value="top" id="type_1" /> <label for="type_1" style="margin: 2px 0 0;">Top</label>
	<br class="clear" />
	<input type="radio" name="positioning" <? if ($data["positioning"] == "middle") { ?> checked="checked"<? } ?> value="middle" id="type_2" /> <label for="type_2" style="margin: 2px 0 0;">Middle</label>
</fieldset>
<h4>Options</h4>
-->
<fieldset>
	<label>Max Items <small>Defaults to 3</small></label>
	<input type="text" name="max" value="<?=htmlspecialchars($data["max"])?>" />
</fieldset>
<? include BigTree::path("admin/ajax/developer/field-options/photo-gallery.php") ?>