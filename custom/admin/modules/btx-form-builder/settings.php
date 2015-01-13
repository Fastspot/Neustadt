<?
	$admin->requireLevel(2);
	$action_title = "Settings";
	
	$pg = new BigTreePaymentGateway;
	if (!is_array($settings)) {
		$settings = array();
	}
?>
<div class="container">
	<form method="post" action="../update-settings/">
		<section>
			<? if (!isset($pg->Service) || !$pg->Service) { ?>
			<div class="alert">
				<span></span>
				<p>To enable payment processing you must first <a href="<?=$admin_root?>developer/payment-gateway/">setup your Payment Gateway</a>.</p>
			</div>
			<? } ?>
			<fieldset>
				<input type="checkbox"<? if (!isset($pg->Service) || !$pg->Service) { ?> disabled="disabled"<? } ?> name="accept_payments"<? if ($settings["accept_payments"]) { ?> checked="checked"<? } ?> />
				<label class="for_checkbox">Enable Payment Processing</label>
			</fieldset>
		</section>
		<footer>
			<input type="submit" class="button blue" value="Update" />
		</footer>
	</form>
</div>