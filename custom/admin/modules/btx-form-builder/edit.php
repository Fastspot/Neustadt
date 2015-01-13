<?
	$action_title = "Edit Form";

	$form = $fb->get(end($path));
?>
<div class="container">
	<form method="post" action="<?=MODULE_ROOT?>update/<?=$form["id"]?>/" class="module">
		<? include "_form.php" ?>
		<footer>
			<input type="submit" class="button blue" value="Update" />	
		</footer>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		FormBuilder.init();
		FormBuilder.objectCount = "<?=$count?>";
	});
</script>