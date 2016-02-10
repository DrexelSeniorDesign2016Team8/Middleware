<?php

require_once 'setup.php';

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
	$prehash = hash('sha256', $pass);
	$passhash = password_hash($prehash, PASSWORD_DEFAULT);

	$DB->query("
		SELECT UserID
		FROM users
		WHERE Email = $email
			AND Password = $passhash");

	if ($DB->has_results()) {
		$json['status'] = 'success';
		$json['response'] = "There would be a session ID here, but there's not.";
	} else {
		$json['status'] = 'error';
		$json['error'] = 'Email or password incorrect.';
	}
}

echo json_encode($json);
?>
