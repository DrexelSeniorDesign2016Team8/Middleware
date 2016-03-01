<?php

require_once 'setup.php';

// create a user account

// escape email, but don't escape password--we need to hash it.
$name = db_string($_GET['name']);
$email = db_string($_GET['email']);
$pass = $_GET['pass'];

$json = array();

if ($email == "") {
	$json['status'] = 'error';
	$json['error'] = 'Email is null.';
} elseif ($pass === null) {
	$json['status'] = 'error';
	$json['error'] = 'Password is null.';
} elseif ($name == "") {
	$json['status'] = 'error';
	$json['error'] = 'Name is null.';
} elseif (strlen($email) > 255) {
	$json['status'] = 'error';
	$json['error'] = 'Email too long.';
} elseif (strlen($name) > 255) {
	$json['status'] = 'error';
	$json['error'] = 'Name too long.';
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

		$DB->query("
			INSERT INTO users
			Email = $email,
			Password = $passhash,
			Name = $name");

		$sess_id = createSID($DB->inserted_id());
		
		$json['status'] = 'success';
		$json['response'] = array('session_id' => $sess_id);
	}
}

echo json_encode($json);
?>
