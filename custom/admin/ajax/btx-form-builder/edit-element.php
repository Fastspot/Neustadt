<?
	$paid = $_POST["paid"];
	$data = json_decode($_POST["data"],true);
	$id = str_replace("form_builder_element_","",$_POST["name"]);
	$type = trim($_POST["type"]);

	include "edit-types/$type.php";
		
	if ($type != "section" && $type != "captcha") {
?>
<fieldset>
	<input type="checkbox" class="checkbox" name="required"<? if ($data["required"]) { ?> checked="checked"<? } ?> />
	<label class="for_checkbox">Required</label>
</fieldset>
<?
	}
?>
<script type="text/javascript">
	BigTreeCustomControls();
</script>