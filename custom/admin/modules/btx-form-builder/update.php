<?
	BigTree::globalizePOSTVars(array("htmlspecialchars","sqlescape"));
	
	// Get cleaned up prices, dates, and entries
	if ($early_bird) {
		$early_bird_date = "'".date("Y-m-d H:i:s",strtotime(str_replace("@","",$_POST["early_bird_date"])))."'";
		$early_bird_base_price = floatval(str_replace(array('$',',',' '),'',$_POST["early_bird_base_price"]));
	} else {
		$early_bird_date = "NULL";
	}
	$base_price = floatval(str_replace(array('$',',',' '),'',$_POST["base_price"]));
	$max_entries = intval($max_entries);
	
	// Setup the default column, sort position, alignment inside columns.
	$form = sqlescape(end($path));
	$position = count($_POST["type"]);
	$column = 0;
	$alignment = "";
	
	// Get all the previous fields so we know which to delete.
	$previous_fields = array();
	$q = sqlquery("SELECT * FROM btx_form_builder_fields WHERE form = '$form'");
	while ($f = sqlfetch($q)) {
		$previous_fields[$f["id"]] = $f["id"];
	}
	
	foreach ($_POST["type"] as $key => $type) {
		$id = $_POST["id"][$key];
		if ($id) {
			unset($previous_fields[$id]);
		}
		if ($type == "column_start") {
			// If we're starting a set of columns and don't have an alignment it's a new set.
			if (!$alignment) {
				if (!$id) {
					sqlquery("INSERT INTO btx_form_builder_fields (`form`,`type`,`position`) VALUES ('$form','column','$position')");
					$id = sqlid();
					$column = $id;
				} else {
					sqlquery("UPDATE btx_form_builder_fields SET position = '$position' WHERE id = '$id'");
					$column = $id;
				}
				$alignment = "left";
			// Otherwise we're starting the second column of the set, just change the alignment.
			} elseif ($alignment == "left") {
				$alignment = "right";
			}
		} elseif ($type == "column_end") {
			if ($alignment == "right") {
				$column = 0;
				$alignment = "";
			}
		} elseif ($type) {
			if ($id) {
				sqlquery("UPDATE btx_form_builder_fields SET type = '$type', data = '".sqlescape($_POST["data"][$key])."', position = '$position', `column` = '$column', `alignment` = '$alignment' WHERE id = '$id'");
			} else {
				sqlquery("INSERT INTO btx_form_builder_fields (`form`,`column`,`alignment`,`type`,`data`,`position`) VALUES ('$form','$column','$alignment','$type','".sqlescape($_POST["data"][$key])."','$position')");
			}
		}
		$position--;
	}
	
	$id = sqlescape(end($commands));
	sqlquery("UPDATE btx_form_builder_forms SET title = '$title', paid = '$paid', base_price = '$base_price', early_bird_base_price = '$early_bird_base_price', early_bird_date = $early_bird_date, limit_entries = '$limit_entries', max_entries = '$max_entries' WHERE id = '$id'");
	
	foreach ($previous_fields as $field_id) {
		sqlquery("DELETE FROM btx_form_builder_fields WHERE id = '$field_id'");
	}
	
	BigTreeAutoModule::clearCache("btx_form_builder_forms");
	
	$admin->growl("Form Builder","Updated Form");
	header("Location: ".MODULE_ROOT);
	die();
?>