<fieldset>
	<?
		if ($d["label"]) {
	?>
	<label>
		<?=htmlspecialchars($d["label"])?>
		<span class="form_builder_required_star">*</span>
	</label>
	<?
		}
		if ($d["instructions"]) {
	?>
	<p><?=htmlspecialchars($d["instructions"])?></p>
	<?
		}
		if ($error) {
	?>
	<div class="form_builder_captcha_error">
		<p>The code you entered was not correct.  Please try again.</p>
	</div>
	<?
		}
		require_once(BigTree::path("inc/lib/recaptcha.php"));
		echo recaptcha_get_html($bigtree["config"]["recaptcha"]["public"]);
	?>
</fieldset>