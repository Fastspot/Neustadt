<?
	if (!$d["label"]) {
		$d["label"] = "Phone";
	}
	
	$phone = $_POST[$field_name];

	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= $phone["first"]."-".$phone["second"]."-".$phone["third"];
	$email .= "\n\n";

	$count += 2;
	
	if ($d["required"] && (strlen($phone["first"]) != 3 || strlen($phone["second"]) != 3 || strlen($phone["third"]) != 4 || !is_numeric($phone["first"]) || !is_numeric($phone["second"]) || !is_numeric($phone["third"]))) {
		$errors[] = $field_name;
	}
	
	$value = $phone["first"]."-".$phone["second"]."-".$phone["third"];
?>