<?
	$pgw_current = 0;
	
	$maxItems = ($field["options"]["max"]) ? $field["options"]["max"] : 3;
	
/*
	$videoMod = new CCMediaVideo;
	$localVideos = $videoMod->getLocal();
	$youtubeVideos = $videoMod->getYouTube();
	
	$audioMod = new CCMediaAudio;
	$audios = $audioMod->getAll("date DESC");
*/
	
	$usedVideo = array();
	$usedAudio = array();
?>
<div class="media_gallery">
	<div class="photo_gallery_widget" id="<?=$field["id"]?>">
<!--
		<footer class="position_field">
			<select name="<?=$field["key"]?>[position]">
				<option value="middle">Middle</option>
				<option value="bottom"<? if ($field["value"]["position"] == "bottom") echo ' selected="selected"'; ?>>Bottom</option>
			</select>
		</footer>
-->
		<ul>
			<?
				if (is_array($field["value"]["items"]) && count($field["value"]["items"])) {
					$field["value"]["items"] = array_slice($field["value"]["items"], 0, $maxItems);
					foreach ($field["value"]["items"] as $pd) {
						if ($field["options"]["preview_prefix"]) {
							$pinfo = BigTree::pathInfo($pd["image"]);
							$preview_image = $pinfo["dirname"]."/".$field["options"]["preview_prefix"].$pinfo["basename"];
						} else {
							$preview_image = $pd["image"];
						}
						if ($pd["video"]) {
							$preview_image = ($pd["image"] != "") ? $pd["image"] : $pd["youtube"]["image"];
						}
			?>
			<li>
				<figure>
					<img src="<?=$preview_image?>" alt="" />
				</figure>
				<? 
					if ($pd["video"]) { 
						$usedVideo[] = $pd["video"];
				?>
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][video]" class="video" value="<?=$pd["video"]?>" title="<?=$pd["title"]?>" />
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][type]" class="type" value="<?=$pd["type"]?>" title="<?=$pd["title"]?>" />
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][existing_video]" class="existing_video" value="<?=$pd["video"]?>" title="<?=$pd["title"]?>" />
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][caption]" class="caption" value="<?=$pd["caption"]?>" title="<?=$pd["title"]?>" />
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][image]" class="image" value="<?=$pd["image"]?>" title="<?=$pd["title"]?>" />
					<a href="#" class="icon_edit edit_video"></a>
					<a href="#" class="icon_delete delete_video"></a>
				<? 
					} else { 
				?>
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][image]" value="<?=$pd["image"]?>" />
					<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][caption]" value="<?=$pd["caption"]?>" class="caption" />
					<a href="#" class="icon_edit"></a>
					<a href="#" class="icon_delete delete_photo"></a>
				<? 
					} 
				?>
			</li>
			<?
						$pgw_current++;
					}
				} else {
			?>
			<li class="placeholder" style="background: none; border: none;">-- Add Media -- </li>
			<?
				}
			?>
		</ul>
		<footer class="image_field">
			<input type="file" name="<?=$field["key"]?>[<?=$pgw_current?>][image]" id="field_<?=$field["key"]?>" />
			<a href="#" class="button blue add_photo"<? if ($pgw_current >= $maxItems) echo ' style="display: none;"'; ?>>Add Photo</a>
		</footer>
		<footer class="video_field"<? if ($pgw_current >= $maxItems) echo ' style="display: none;"'; ?>>
			<select class="type">
				<option value="youtube">YouTube</option>
				<option value="vimeo">Vimeo</option>
			</select>
			<input type="text" class="video_id" placeholder="YouTube or Vimeo ID" />
			<a href="#" class="button blue add_video">Add Video</a>
		</footer>
	</div>
</div>
<script>
	new BigTreeMediaGallery("<?=$field["id"]?>","<?=$field["key"]?>",<?=$pgw_current?>,<?=$maxItems?>);
</script>


<? /* >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */ ?>


<?
	/*
	
	$pgw_current = 0;
	$maxItems = ($field["options"]["max"]) ? $field["options"]["max"] : 3;
?>
<div class="media_gallery">
	<div class="photo_gallery_widget" id="<?=$field["id"]?>">
<!--
		<footer class="position_field">
			<select name="<?=$field["key"]?>[position]">
				<option value="middle">Middle</option>
				<option value="bottom"<? if ($field["value"]["position"] == "bottom") echo ' selected="selected"'; ?>>Bottom</option>
			</select>
		</footer>
-->
		<ul>
			<?
				if (is_array($field["value"]) && count($field["value"])) {
					$field["value"] = array_slice($field["value"], 0, $maxItems);
					foreach ($field["value"] as $pd) {
						if ($field["options"]["preview_prefix"]) {
							$pinfo = BigTree::pathInfo($pd["image"]);
							$preview_image = $pinfo["dirname"]."/".$field["options"]["preview_prefix"].$pinfo["basename"];
						} else {
							$preview_image = $pd["image"];
						}
						
						if ($pd["video_id"]) {
							$pd["video"] = $pd["video_id"];
						}
			?>
			<li>
				<figure>
					<img src="<?=$preview_image?>" alt="" />
				</figure>
				<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][video]" class="video" value="<?=$pd["video"]?>" title="<?=$pd["title"]?>" />
				<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][type]" class="type" value="<?=$pd["type"]?>" title="<?=$pd["title"]?>" />
				<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][existing_video]" class="existing_video" value="<?=$pd["video"]?>" title="<?=$pd["title"]?>" />
				<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][caption]" class="caption" value="<?=$pd["caption"]?>" title="<?=$pd["title"]?>" />
				<input type="hidden" name="<?=$field["key"]?>[<?=$pgw_current?>][image]" class="image" value="<?=$pd["image"]?>" title="<?=$pd["title"]?>" />
				<a href="#" class="icon_edit edit_video"></a>
				<a href="#" class="icon_delete delete_video"></a>
			</li>
			<?
						$pgw_current++;
					}
				} else {
			?>
			<li class="placeholder" style="background: none; border: none;">-- Add Media -- </li>
			<?
				}
			?>
		</ul>
		<footer class="image_field">
			<input type="file" name="<?=$field["key"]?>[<?=$pgw_current?>][image]" id="field_<?=$field["key"]?>" />
			<a href="#" class="button blue add_photo"<? if ($pgw_current >= $maxItems) echo ' style="display: none;"'; ?>>Add Photo</a>
		</footer>
		<footer class="video_field"<? if ($pgw_current >= $maxItems) echo ' style="display: none;"'; ?>>
			<select class="type">
				<option value="youtube">YouTube</option>
				<option value="vimeo">Vimeo</option>
			</select>
			<input type="text" class="video_id" placeholder="YouTube or Vimeo ID" />
			<a href="#" class="button blue add_video">Add Video</a>
		</footer>
	</div>
</div>
<script>
	new BigTreeMediaGallery("<?=$field["id"]?>","<?=$field["key"]?>",<?=$pgw_current?>,<?=$maxItems?>);
</script>
<?
*/
?>