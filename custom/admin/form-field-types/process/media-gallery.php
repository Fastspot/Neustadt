<?

	$photo_gallery = array();

	$storage = new BigTreeStorage;

	if (is_array($field["input"])) {
		foreach ($field["input"] as $photo_count => $data) {
			// Video
			if ($data["video"]) {
				if ($data["existing_video"] != $data["video"]) {
					$id = $data["video"];
					$videoType = $data["type"];
					stream_context_set_default(array('http' => array('method' => 'HEAD')));
					$found = true;
					if ($videoType == "youtube") {
						// Figure out if we have a 404. YouTube only.
						$headers = get_headers("http://i.ytimg.com/vi/$id/maxresdefault.jpg");
						foreach ($headers as $header) {
							if (substr($header,0,4) == "HTTP") {
								if (strpos($header,"404") !== false) {
									$found = false;
								}
							}
						}
					}
					if ($found) {
						if ($videoType == "youtube") {
							$image = "http://i.ytimg.com/vi/$id/maxresdefault.jpg";
						} else if ($videoType == "vimeo") {
							$imageHash = BigTree::cURL("http://vimeo.com/api/v2/video/$id.json");
							$json = json_decode($imageHash,true);
							$image = $json[0]["thumbnail_large"];
						}
					} else {
						$r = BigTree::cURL("http://gdata.youtube.com/feeds/api/videos/$id?v=2&prettyprint=true&alt=json");
						$json = json_decode($r,true);
						$thumbwidth = 0;
						$image = false;
						foreach ($json["entry"]['media$group']['media$thumbnail'] as $thumb) {
							if ($thumb["width"] > $thumbwidth) {
								$thumbwidth = $thumb["width"];
								$image = $thumb["url"];
							}
						}
					}

					$pinfo = BigTree::pathInfo($image);

					// Make a copy of the YouTube image for us to pass off to the cropper.
					$local_copy = SITE_ROOT."files/".uniqid("temp-").$pinfo["extension"];
					file_put_contents($local_copy, BigTree::cURL($image));
					list($width, $height, $type, $attr) = getimagesize($local_copy);

					if ($width < $options["min_width"] || $height < $options["min_height"]) {
						$uc_copy = $local_copy."2";
						upscaleImage($local_copy,$uc_copy,$options["min_width"],$options["min_height"]);
						$local_copy = $uc_copy;
					}

					$name = $pinfo["basename"];
					$temp_name = $local_copy;

					include BigTree::path("admin/form-field-types/process/_photo-process.php");

					if (!$failed) {
						$photo_gallery[] = array(
							"video" => $id,
							"type" => $videoType,
							"image" => $field["output"],
							"caption" => $data["caption"]
						);
					}
				} else {
					unset($data["existing_id"]);
					$photo_gallery[] = $data;
				}
			// If we have image data, it's a previously uploaded image we haven't changed, so just add it back to the photo gallery array.
			} else if ($data["image"]) {
				$data["caption"] = htmlspecialchars(htmlspecialchars_decode($data["caption"]));
				$photo_gallery[] = $data;
			// Otherwise, let's see if we have file information in the files array.
			} elseif ($field["file_input"][$photo_count]["image"]["name"]) {
				$name = $field["file_input"][$photo_count]["image"]["name"];
				$temp_name = $field["file_input"][$photo_count]["image"]["tmp_name"];
				$error = $field["file_input"][$photo_count]["image"]["error"];

				if ($error == 1 || $error == 2) {
					$bigtree["errors"][] = array("field" => $field["options"]["title"], "error" => "The file you uploaded ($name) was too large &mdash; <strong>Max file size: ".ini_get("upload_max_filesize")."</strong>");
				} elseif ($error == 3) {
					$bigtree["errors"][] = array("field" => $field["options"]["title"], "error" => "The file upload failed ($name).");
				} else {
					include BigTree::path("admin/form-field-types/process/_photo-process.php");
					if (!$failed) {
						$photo_gallery[] = array("caption" => htmlspecialchars(htmlspecialchars_decode($data["caption"])),"image" => $field["output"]);
					}
				}
			} elseif ($data["existing"]) {
				$data["existing"] = str_replace(WWW_ROOT,SITE_ROOT,$data["existing"]);
				$pinfo = BigTree::pathInfo($data["existing"]);

				$name = $pinfo["basename"];
				$temp_name = SITE_ROOT."files/".uniqid("temp-").".img";
				$error = false;

				BigTree::copyFile($data["existing"],$temp_name);
				include BigTree::path("admin/form-field-types/process/_photo-process.php");

				if (!$failed) {
					$photo_gallery[] = array("caption" => htmlspecialchars(htmlspecialchars_decode($data["caption"])), "image" => $field["output"]);
				}
			}
		}
	}

	$field["output"] = $photo_gallery;

?>