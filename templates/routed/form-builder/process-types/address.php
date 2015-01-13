<?
	if (!$d["label"]) {
		$d["label"] = "Address";
	}
	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	
	$address = $_POST[$field_name];
	$email .= $address["street"]."\n";
	if ($address["street2"]) {
		$email .= $address["street2"]."\n";
	}
	$email .= $address["city"].", ".$address["state"]." ".$address["zip"]."\n";
	$email .= $address["country"];
	
	$email .= "\n\n";
	
	$count += 5;
	
	if ($d["required"] && (!$address["street"] || !$address["city"] || !$address["state"] || !$address["zip"] || !$address["country"])) {
		$errors[] = $field_name;
	}
		
	$value = $address;
?>