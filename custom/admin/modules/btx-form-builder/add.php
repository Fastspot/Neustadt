<?
	$action_title = "Add Form";
	$form["fields"] = array();
	
	if ($_GET["template"]) {
		$form = $fb->get($_GET["template"]);
	}
?>
<div class="container">
	<form method="post" action="<?=MODULE_ROOT?>create/" class="module">
		<? include "_form.php" ?>
		<footer>
			<input type="submit" class="button blue" value="Create" />	
		</footer>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		FormBuilder.init();
		FormBuilder.objectCount = 0;
	});
</script>