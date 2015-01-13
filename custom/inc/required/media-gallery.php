<?

	function upscaleImage($file,$new_file,$minwidth,$minheight) {
		global $bigtree;

		$jpeg_quality = isset($bigtree["config"]["image_quality"]) ? $bigtree["config"]["image_quality"] : 90;

		list($type,$w,$h,$result_width,$result_height) = getUpscaleSizes($file,$minwidth,$minheight,$retina);

		// If we don't have the memory available, fail gracefully.
		if (!BigTree::imageManipulationMemoryAvailable($file,$result_width,$result_height)) {
			return false;
		}

		$thumbnailed_image = imagecreatetruecolor($result_width, $result_height);
		if ($type == IMAGETYPE_JPEG) {
			$original_image = imagecreatefromjpeg($file);
		} elseif ($type == IMAGETYPE_GIF) {
			$original_image = imagecreatefromgif($file);
		} elseif ($type == IMAGETYPE_PNG) {
			$original_image = imagecreatefrompng($file);
		}

		imagealphablending($original_image, true);
		imagealphablending($thumbnailed_image, false);
		imagesavealpha($thumbnailed_image, true);
		imagecopyresampled($thumbnailed_image, $original_image, 0, 0, 0, 0, $result_width, $result_height, $w, $h);

		if ($grayscale) {
			imagefilter($thumbnailed_image, IMG_FILTER_GRAYSCALE);
		}

		if ($type == IMAGETYPE_JPEG) {
			imagejpeg($thumbnailed_image,$new_file,$jpeg_quality);
		} elseif ($type == IMAGETYPE_GIF) {
			imagegif($thumbnailed_image,$new_file);
		} elseif ($type == IMAGETYPE_PNG) {
			imagepng($thumbnailed_image,$new_file);
		}
		chmod($new_file,0777);

		imagedestroy($original_image);
		imagedestroy($thumbnailed_image);
		unlink($file);

		return $new_file;
	}
	function getUpscaleSizes($file,$minwidth,$minheight) {
		echo $minwidth, $minheight;
		list($w, $h, $type) = getimagesize($file);
		if ($w < $minwidth && $minwidth) {
			$perc = $minwidth / $w;
			$result_width = $minwidth;
			$result_height = round($h * $perc,0);
			if ($result_height < $minheight && $minheight) {
				$perc = $minheight / $result_height;
				$result_height = $minheight;
				$result_width = round($result_width * $perc,0);
			}
		} elseif ($h < $minheight && $minheight) {
			$perc = $minheight / $h;
			$result_height = $minheight;
			$result_width = round($w * $perc,0);
			if ($result_width < $minwidth && $minwidth) {
				$perc = $minwidth / $result_width;
				$result_width = $minwidth;
				$result_height = round($result_height * $perc,0);
			}
		} else {
			$result_width = $w;
			$result_height = $h;
		}

		return array($type,$w,$h,$result_width,$result_height);
	}

?>