<?
	if ($d["label"]) {
		$email .= $d["label"]."\n";
		$email .= str_repeat("-",strlen($d["label"]))."\n";
	}
	
	$something_was_checked = false;
	
	if (is_array($_POST[$field_name])) {
		foreach ($d["list"] as $item) {
			$value = $item["value"] ? $item["value"] : $item["description"];
			if (in_array($value,$_POST[$field_name])) {
				if ($value == $item["description"]) {
					$email .= $item["description"].": Yes\n";
				} else {
					$email .= $item["description"].": ".$item["value"]."\n";
				}
				$something_was_checked = true;
				
				$total += $item["price"];
			} else {
				$email .= $item["description"].": ---\n";
			}
		}
		$email .= "\n\n";
	} else {
		foreach ($d["list"] as $item) {
			$value = $item["value"] ? $item["value"] : $item["description"];
			if ($_POST[$field_name] == $value) {
				if ($value == $item["description"]) {
					$email .= $item["description"].": Yes\n";
				} else {
					$email .= $item["description"].": ".$item["value"]."\n";
				}
				$something_was_checked = true;
				
				$total += $item["price"];
			}
		}
	}
	
	if ($d["required"] && !$something_was_checked) {
		$errors[] = $field_name;
	}
	
	$value = $_POST[$field_name];
?>