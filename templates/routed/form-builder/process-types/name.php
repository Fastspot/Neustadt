<?
	if (!$d["label"]) {
		$d["label"] = "Name";
	}
	
	$name = $_POST[$field_name];
	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= "First: ".$name["first"]."\n";
	$email .= "Last: ".$name["last"];
	$email .= "\n\n";
	$count++;
	
	if ($d["required"] && (!$name["first"] || !$name["last"])) {
		$errors[] = $field_name;
	}
	
	$value = $name;
?>