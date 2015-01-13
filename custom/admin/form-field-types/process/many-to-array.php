<? 
	
	if (is_array($field["input"])) {
		$entries = array();
		foreach ($field["input"] as $id) {
			$entries[] = $id;
		}
		$field["output"] = json_encode($entries);
	} else {
		$field["output"] = $field["input"];
	}
	
?>