<?
	require_once(BigTree::path("inc/lib/recaptcha.php"));
	$resp = recaptcha_check_answer($bigtree["config"]["recaptcha"]["private"],$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
		$errors[] = $field_name;
	}
?>