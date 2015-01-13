<?
	$fb = new PluginFormBuilder;
	if ($_POST["form"]) {
		$form = $fb->get($_POST["form"]);
		$entries = $fb->searchEntries($form["id"],$_POST["search"]);
	}
	
	function fbuilder_get_table_record($fields) {
		global $record,$entry;
		foreach ($fields as $field) {
			$value = $entry["data"][$field["id"]];
			$t = $field["type"];
			
			if ($t == "column") {
				fbuilder_get_table_record($field["fields"]);
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
				$record[] = implode(", ",$value);
			} elseif ($t != "section") {
				$record[] = $value;
			}
		}
	}
	
	function fbuilder_get_table_header($fields) {
		global $columns;
		foreach ($fields as $field) {
			$t = $field["type"];
			$fdata = json_decode($field["data"],true);
			$label = $fdata["label"];
			if (!$label)
				$label = ucwords($t);
			
			$label = $label;
			
			if ($t == "column") {
				fbuilder_get_table_header($field["fields"]);
			} elseif ($t == "address") {
				$columns[] = $label." - Street";
				$columns[] = $label." - Street 2";
				$columns[] = $label." - City";
				$columns[] = $label." - State";
				$columns[] = $label." - Zip";
				$columns[] = $label." - Country";
			} elseif ($t == "name") {
				$columns[] = $label." - First";
				$columns[] = $label." - Last";
			} elseif ($t != "section") {
				$columns[] = $label;
			}
		}
	}

	$page = $_POST["page"] ? $_POST["page"] : 0;
	$pages = ceil(count($entries) / 15);
	if ($pages < 1)
		$pages = 1;

	if ($page == 0) {
		if ($pages > 1)
			$np = true;
		$pp = false;
	} elseif ($page == ($pages - 1)) {
		$np = false;
		$pp = true;
	} else {
		$np = true;
		$pp = true;
	}
	$npn = $page + 1;
	$ppn = $page - 1;
	
	$entries = array_slice($entries,(15*$page),15);
?>

<div class="search_results">
	<ul class="page_numbers">
		<li class="previous_page"><? if ($pp) { ?><a href="#<?=$ppn?>"><? } else { ?><a href="#" class="disabled"><? } ?>&lsaquo;</a></li>
		<?
			$parray = get_page_array($page,$pages);
			$x = 0;
			while ($x < count($parray)) {
				$p = $parray[$x];
				if (($page + 1) == $p && is_numeric($p))
					echo '<li><a href="#" class="active">'.$p.'</a></li>';
				elseif (is_numeric($p))
					echo '<li><a href="#'.($p - 1).'">'.$p.'</a></li>';
				else
					echo '<li>...</li>';
				$x++;
			}
		?>
		<li class="next_page"><? if ($np) { ?><a href="#<?=$npn?>"><? } else { ?><a href="#" class="disabled"><? } ?>&rsaquo;</a></li>
	</ul>
</div>
<br class="clear" /><br />
<dl class="table">
	<dt>
		<span class="auto" style="width: 105px;">Date Submitted</span>
		<?
			$columns = array();
			fbuilder_get_table_header($form["fields"]);
			$columns = array_slice($columns,0,4);
			foreach ($columns as $column) {
		?>
		<span class="auto" style="width: 165px;"><?=$column?></span>
		<?
			}
		?>
		<span class="action">View</span>
		<span class="action">Delete</span>
	</dt>
	<? foreach ($entries as $entry) { ?>
	<dd>
		<ul>
			<li class="auto" style="width: 105px;"><?=date("m/d/Y",strtotime($entry["created_at"]))?></li>
			<?
				$record = array();
				fbuilder_get_table_record($form["fields"]);
				$record = array_slice($record,0,4);
				foreach ($record as $item) {
			?>
			<li class="auto" style="width: 165px;"><?=$item?></li>
			<?
				}
			?>
			<li class="action"><a href="../../view-entry/<?=$entry["id"]?>/" class="button_view"></a></li>
			<li class="action"><a href="#<?=$entry["id"]?>" class="button_delete"></a></li>
		</ul>
	</dd>
	<? } ?>
</dl>