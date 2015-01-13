<?
	header("Content-type: text/javascript");
	sqlquery("DELETE FROM btx_form_builder_entries WHERE id = '".sqlescape($_GET["id"])."'");
	sqlquery("UPDATE btx_form_builder_forms SET entries = (entries - 1) WHERE id = '".sqlescape($_GET["form"])."'");
	BigTreeAutoModule::recacheItem($_GET["form"],"btx_form_builder_forms");
?>
BigTree.Growl("Form Builder","Deleted Entry");
$("#row_<?=$_GET["id"]?>").remove();