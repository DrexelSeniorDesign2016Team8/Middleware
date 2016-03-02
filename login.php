<?php

require_once 'setup.php';
require_once 'createSid.php';

// login user

// escape email, but don't escape password--we need to hash it.
$email = db_string($_GET['email']);
$pass = $_GET['pass'];

$json = array();

if ($email == "") {
	$json['status'] = 'error';
	$json['error'] = 'Email is null.';
} elseif ($pass === null) {
	$json['status'] = 'error';
	$json['error'] = 'Password is null.';
} else {
	$DB->query("
		SELECT ID, Password
		FROM users
		WHERE Email = $email");

	if ($DB->has_results()) {
		list($user_id, $pass_hash) = $DB->next_record();
		$valid = password_verify(hash('sha256', $pass), $pass_hash);

		var_dump($pass_hash);
		var_dump($pass);
		var_dump(hash('sha256', $pass));
		var_dump($valid);

		if ($valid) {
			$json['status'] = 'success';
			$json['response'] = array('session_id' => createSID($user_id));
		} else {
			$json['status']  = 'error';
			$json['error'] = 'Email or passwor incorrect';
		}
	} else {
			$json['status'] = 'error';
			$json['error'] = 'Email or password incorrect.';
	}
}

echo json_encode($json);
?>
