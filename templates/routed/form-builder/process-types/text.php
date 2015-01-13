<?
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= $_POST[$field_name];
	$email .= "\n\n";
	
	$value = $_POST[$field_name];
?>