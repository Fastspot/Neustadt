<?
	$form = $fb->get(end($path));

	header("Content-type: text/csv");
	header('Content-Disposition: attachment; filename="'.$cms->urlify($form["title"])."-".date("Y-m-d").'.csv"');	
		
	function _form_builder_draw_csv_header($fields) {
		global $columns;
		foreach ($fields as $field) {
			$t = $field["type"];
			$fdata = json_decode($field["data"],true);
			$label = $fdata["label"];
			if (!$label) {
				$label = ucwords($t);
			}
			
			$label = str_replace('"','""',$label);
			
			if ($t == "column") {
				_form_builder_draw_csv_header($field["fields"]);
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
	
	function _form_builder_draw_csv_record($fields) {
		global $record,$entry;
		foreach ($fields as $field) {
			$value = $entry["data"][$field["id"]];
			$t = $field["type"];
			
			if ($t == "column") {
				_form_builder_draw_csv_record($field["fields"]);
			} elseif ($t == "address") {
				$record[] = str_replace('"','""',$value["street"]);
				$record[] = str_replace('"','""',$value["street2"]);
				$record[] = str_replace('"','""',$value["city"]);
				$record[] = str_replace('"','""',$value["state"]);
				$record[] = str_replace('"','""',$value["zip"]);
				$record[] = str_replace('"','""',$value["country"]);
			} elseif ($t == "name") {
				$record[] = str_replace('"','""',$value["first"]);
				$record[] = str_replace('"','""',$value["last"]);
			} elseif ($t == "checkbox") {
				if (is_array($value)) {
					$record[] = str_replace('"','""',implode(", ",$value));			
				} else {
					$record[] = str_replace('"','""',$value);
				}
			} elseif ($t != "section") {
				$record[] = str_replace('"','""',$value);
			}
		}
	}
	
	$columns = array();
	_form_builder_draw_csv_header($form["fields"]);	
	echo '"'.implode('","',$columns).'","Date Submitted"'."\n";
	
	$entries = $fb->getEntries($form["id"]);
	foreach ($entries as $entry) {
		$record = array();
		_form_builder_draw_csv_record($form["fields"]);
		echo '"'.implode('","',$record).'","'.$entry["created_at"].'"'."\n";
	}
	
	die();
?>