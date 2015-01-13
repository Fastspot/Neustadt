<?
	$i = $_POST["selected"];
	$d = json_decode($_POST["data"],true);
	
	foreach ($d["list"] as $key => &$item) {
		if ($key == $i) {
			$item["selected"] = true;
		} else {
			$item["selected"] = false;
		}
	}
	
	echo json_encode($d);
?>