<h1 class="phrase block">
	<div class="line">
		<div class="row">
			<span class="desktop-10 desktop-push-1 tablet-6 mobile-full"><?=$page_header?></span>
		</div>
	</div>
</h1>
<div class="row">
	<div class="desktop-9 desktop-push-1 tablet-6 mobile-full page_content">
		<?=$page_content?>
		<? /* <link rel="stylesheet" href="<?=$www_root?>css/btx-form-builder.css" /> */ ?>
		<article>
			<div class="form_builder_required_message">
				<p><span class="form_builder_required_star">*</span> = required field</p>
			</div>
			<?
				if ($form["limit_entries"] && $form["entries"] >= $form["max_entries"]) {
			?>
			<h2>Maximum Entries Reached</h2>
			<p>This form has reached the maximum number of entries.</p>
			<?	
				} else {
			?>
			<form method="post" action="<?=$page_link?>process/" enctype="multipart/form-data" class="form_builder">
				<?
					$error_count = count($_SESSION["form_builder"]["errors"]);
					if ($error_count) {
				?>
				<div class="form_builder_errors">
					<? if ($error_count == 1) { ?>
					<p>A required field was missing. Please fill out all required fields and submit again.</p>
					<? } else { ?>
					<p>Required fields were missing. Please fill out all required fields out and submit again.</p>
					<? } ?>
				</div>
				<?	
					}
					
					if ($_SESSION["form_builder"]["payment_error"]) {
				?>
				<div class="form_builder_errors">
					<p>Checkout Failed, your credit card has not been charged.</p>
					<p class="form_builder_alert">Error returned was: <?=$_SESSION["form_builder"]["payment_error"]?></p>
				</div>
				<?
					}
					
					// Setup price watchers.
					$check_watch = array();
					$radio_watch = array();
					$select_watch = array();
			
					$last_field = false;
					$count = 0;
					foreach ($form["fields"] as $field) {
						$count++;
						$t = $field["type"];
						$d = json_decode($field["data"],true);
			
						if ($t != "column") {
							if ($d["name"]) {
								$field_name = $d["name"];
							} else {
								$field_name = "data_".$field["id"];
							}
							$error = false;
							if (isset($_SESSION["form_builder"]["fields"])) {
								$default = $_SESSION["form_builder"]["fields"][$field_name];
							} else {
								if (isset($d["default"])) {
									$default = $d["default"];
								} else {
									$default = false;			
								}
							}
							if (is_array($_SESSION["form_builder"]["errors"]) && in_array($field_name,$_SESSION["form_builder"]["errors"])) {
								$error = true;
							}
							include "draw-types/$t.php";
						} else {
							if ($last_field == "column") {
								echo '<div class="form_builder_column form_builder_last">';
							} else {
								echo '<div class="form_builder_column">';
							}
							foreach ($field["fields"] as $subfield) {
								$count++;
								$d = json_decode($subfield["data"],true);
								if ($d["name"]) {
									$field_name = $d["name"];
								} else {
									$field_name = "data_".$subfield["id"];
								}
								$error = false;
								if (isset($_SESSION["form_builder"]["fields"])) {
									$default = $_SESSION["form_builder"]["fields"][$field_name];
								} else {
									if (isset($d["default"])) {
										$default = $d["default"];
									} else {
										$default = false;			
									}
								}
								if (is_array($_SESSION["form_builder"]["errors"]) && in_array($field_name,$_SESSION["form_builder"]["errors"])) {
									$error = true;
								}
								include "draw-types/".$subfield["type"].".php";
							}
							echo '</div>';
						}
						$last_field = $t;
					}
				?>
				<input type="submit" class="form_builder_submit" value="Submit" />
			</form>
			<?
					// Make the price watchers
					if ($form["paid"]) {
						if ($form["early_bird_date"] && strtotime($form["early_bird_date"]) > time()) {
							$bp = $form["early_bird_base_price"] ? $form["early_bird_base_price"] : $form["base_price"];			
						} else {
							$bp = $form["base_price"] ? $form["base_price"] : "0.00";
						}
			?>
			<script type="text/javascript">
				var form_builder_total = <?=$bp?>;
				var form_builder_previous_values = {};
				
				<? foreach ($check_watch as $id) { ?>
				i =  document.getElementById("<?=$id?>");
				i.onclick = function() {
					var price = this.getAttribute("data-price");
					if (this.checked) {
						form_builder_total += parseFloat(price);
					} else {
						form_builder_total -= parseFloat(price);
					}
					document.getElementById("form_builder_total").innerHTML = "$" + form_builder_total.toFixed(2);
				};
				<? } ?>
				
				<? foreach ($radio_watch as $id) { ?>
				i =  document.getElementById("<?=$id?>");
				i.onclick = function() {
					var old_price = form_builder_previous_values[this.getAttribute("name")];
					if (old_price) {
						form_builder_total -= old_price;
					}
					var price = this.getAttribute("data-price");
					form_builder_total += parseFloat(price);
					form_builder_previous_values[this.getAttribute("name")] = parseFloat(price);
					document.getElementById("form_builder_total").innerHTML = "$" + form_builder_total.toFixed(2);
				};
				<? } ?>
				
				<? foreach ($select_watch as $id) { ?>
				i =  document.getElementById("<?=$id?>");
				i.onchange = function() {
					var old_price = form_builder_previous_values[this.getAttribute("name")];
					if (old_price) {
						form_builder_total -= old_price;
					}
					var price = parseFloat(this.options[this.selectedIndex].getAttribute("data-price"));
					form_builder_total += price;
					form_builder_previous_values[this.getAttribute("name")] = price;
					document.getElementById("form_builder_total").innerHTML = "$" + form_builder_total.toFixed(2);
				};
				<? } ?>
				
				if (window.addEventListener) {
					window.addEventListener("load",_formBuilderOnLoad);
				} else {
					window.attachEvent("load",_formBuilderOnLoad);
				}
				
				function _formBuilderOnLoad() {
					<?
						foreach ($check_watch as $id) {
					?>
					i =  document.getElementById("<?=$id?>");
					if (i.checked) {
						form_builder_total += parseFloat(i.getAttribute("data-price"));
					}
					<?
						}
						
						foreach ($radio_watch as $id) {
					?>
					i =  document.getElementById("<?=$id?>");
					if (i.checked) {
						form_builder_total += parseFloat(i.getAttribute("data-price"));
						form_builder_previous_values[i.getAttribute("name")] = parseFloat(i.getAttribute("data-price"));
					}
					<?
						}
						
						foreach ($select_watch as $id) {
					?>
					i =  document.getElementById("<?=$id?>");
					v = parseFloat(i.options[i.selectedIndex].getAttribute("data-price"));
					if (v) {
						form_builder_total += v;
						form_builder_previous_values[i.getAttribute("name")] = parseFloat(i.options[i.selectedIndex].getAttribute("data-price"));
					}
					<?
						}
					?>
					document.getElementById("form_builder_total").innerHTML = "$" + form_builder_total.toFixed(2);
				};
			</script>
			<?
					}
			
					unset($_SESSION["form_builder"]["payment_error"]);
					unset($_SESSION["form_builder"]["errors"]);
					unset($_SESSION["form_builder"]["fields"]);
				}
			?>
		</article>
		<?=$after_form_content?>
	</div>
</div>


