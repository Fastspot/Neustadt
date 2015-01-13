<?
	if (!$d["label"]) {
		$d["label"] = "Date";
	}
	
	$date = $_POST[$field_name];
	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= date("F j, Y",strtotime($date["year"]."-".$date["month"]."-".$date["day"]));
	$email .= "\n\n";
	
	$count += 2;
	
	if ($d["required"] && (!$date["year"] || !$date["month"] || !$date["day"])) {
		$errors[] = $field_name;
	}
	
	$value = $date["year"]."-".$date["month"]."-".$date["day"];
?>