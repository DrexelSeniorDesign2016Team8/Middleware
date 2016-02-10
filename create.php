<?php

require_once 'setup.php';

// create a user account

// escape email, but don't escape password--we need to hash it.
$email = db_string($_GET['email']);
$pass = $_GET['pass'];

$json = array();

if ($email === null) {
	$json['status'] = 'error';
	$json['error'] = 'Email is null.';
} elseif ($pass === null) {
	$json['status'] = 'error';
	$json['error'] = 'Password is null.';
} else {
	$DB->query("
		SELECT UserID
		FROM users
		WHERE Email = $email");

	if ($DB->has_results()) {
		$json['status'] = 'error';
		$json['error'] = 'Email already in use.';
	} else {
		$prehash = hash('sha256', $pass);
		$passhash = password_hash($prehash, PASSWORD_DEFAULT);
		
		$json['status'] = 'success';
		$json['response'] = array('email' => $email, 'pass' => $passhash);
	}
}

echo json_encode($json);
?>
