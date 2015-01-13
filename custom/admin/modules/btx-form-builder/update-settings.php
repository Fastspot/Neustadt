<?
	$admin->requireLevel(2);
	if (!$admin->settingExists("btx-form-builder-settings")) {
		$admin->createSetting(array(
			"id" => "btx-form-builder-settings",
			"name" => "Form Builder Settings",
			"system" => "on"
		));
	}
	
	$settings["accept_payments"] = $_POST["accept_payments"];
	$admin->updateSettingValue("btx-form-builder-settings",$settings);
	
	$admin->growl("Form Builder","Updated Settings");
	header("Location: ".MODULE_ROOT);
	die();
?>