<?
	// SPAM honey pot
	if ($_POST["website"]) {
		die();
	}
	
	BigTree::globalizePOSTVars();
	$errors = array();
	
	unset($_SESSION["comment_values"]);
	unset($_SESSION["comment_errors"]);
	
	if ($name == "") {
		$errors["name"] = true;
	}
	if ($email == "") {
		$errors["email"] = true;
	}
	if ($comment == "") {
		$errors["comment"] = true;
	}
	
	if (count($errors) < 1) {
		$dogwood->addComment($post, $parent, $name, $email, $comment, $_SERVER["REMOTE_ADDR"]);
		
		$_SESSION["comment_submitted"] = true;
		
		BigTree::redirect($return . "#comments");
	} else {
		$_SESSION["comment_values"] = $_POST;
		$_SESSION["comment_errors"] = $errors;
		
		BigTree::redirect($return . "#comment_form");
	}
?>