<?
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	if ($_FILES[$field_name]["tmp_name"]) {
		$us = new BigTreeUploadService;
		
		if ($d["directory"]) {
			$directory = rtrim($d["directory"],"/")."/";
		} else {
			$directory = "files/form-builder/";
		}
		
		$directory = "files/form-builder/";
		
		$value = $us->upload($_FILES[$field_name]["tmp_name"],$_FILES[$field_name]["name"],$directory,true);
	} else {
		$email .= "No File Uploaded";
		if ($d["required"]) {
			$errors[] = $field_name;
		}
		$value = "";
	}
	$email .= "\n\n";
?>