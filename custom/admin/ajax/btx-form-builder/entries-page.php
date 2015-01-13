<?
	$fb = new BTXFormBuilder;
	$page = $_GET["page"] ? $_GET["page"] : 0;
	$search = $_GET["search"] ? $_GET["search"] : "";
	$form = $_GET["form"] ? $fb->get($_GET["form"]) : $form;
	
	list($pages,$entries) = $fb->searchEntries($form["id"],$search,$page);
	
	function _form_builder_get_table_record($fields) {
		global $record,$entry;
		foreach ($fields as $field) {
			$value = $entry["data"][$field["id"]];
			$t = $field["type"];
			
			if ($t == "column") {
				_form_builder_get_table_record($field["fields"]);
			} elseif ($t == "address") {
				$record[] = $value["street"];
				$record[] = $value["street2"];
				$record[] = $value["city"];
				$record[] = $value["state"];
				$record[] = $value["zip"];
				$record[] = $value["country"];
			} elseif ($t == "name") {
				$record[] = $value["first"];
				$record[] = $value["last"];
			} elseif ($t == "checkbox") {
				if (is_array($value)) {
					$record[] = implode(", ",$value);				
				} else {
					$record[] = $value;
				}
			} elseif ($t != "section") {
				$record[] = $value;
			}
		}
	}

	foreach ($entries as $entry) {
		$record = array();
		_form_builder_get_table_record($form["fields"]);
		$record = array_slice($record,0,4);
?>
<li id="row_<?=$entry["id"]?>">
	<section class="view_column" style="width: 114px;"><?=date("m/d/Y",strtotime($entry["created_at"]))?></section>
	<? foreach ($record as $item) { ?>
	<section class="view_column" style="width: 155px;"><?=$item?></section>
	<? } ?>
	<section class="view_action"><a href="../../view-entry/<?=$entry["id"]?>/" class="icon_view_details"></a></section>
	<section class="view_action"><a href="#<?=$entry["id"]?>" class="icon_delete"></a></section>
</li>
<?
	}
?>
<script type="text/javascript">
	BigTree.SetPageCount("#view_paging",<?=$pages?>,<?=$page?>);
</script>