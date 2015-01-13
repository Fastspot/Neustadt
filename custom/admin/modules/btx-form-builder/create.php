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
	
	// Create the form.
	sqlquery("INSERT INTO btx_form_builder_forms (`title`,`paid`,`base_price`,`early_bird_base_price`,`early_bird_date`,`limit_entries`,`max_entries`) VALUES ('$title','$paid','$base_price','$early_bird_base_price',$early_bird_date,'$limit_entries','$max_entries')");
	$form = sqlid();
	
	// Setup the default column, sort position, alignment inside columns.
	$position = count($_POST["type"]);
	$column = 0;
	$alignment = "";

	foreach ($_POST["type"] as $key => $type) {
		if ($type == "column_start") {
			// If we're starting a set of columns and don't have an alignment it's a new set.
			if (!$alignment) {
				sqlquery("INSERT INTO btx_form_builder_fields (`form`,`type`,`position`) VALUES ('$form','column','$position')");
				$id = sqlid();
				$column = $id;
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
			sqlquery("INSERT INTO btx_form_builder_fields (`form`,`column`,`alignment`,`type`,`data`,`position`) VALUES ('$form','$column','$alignment','$type','".sqlescape($_POST["data"][$key])."','$position')");
		}
		$position--;
	}

	BigTreeAutoModule::clearCache("btx_form_builder_forms");
	
	$admin->growl("Form Builder","Created Form");
	header("Location: ".MODULE_ROOT);
	die();
?>