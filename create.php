<?php

require_once 'setup.php';

// create a user account

// escape email, but don't escape password--we need to hash it.
$email = db_string($_GET['email']);
$pass = $_GET['pass'];

$DB->query("
	SELECT UserID
	FROM users
	WHERE Email = $email");

$json = array();
if ($DB->has_results()) {
	$json['status'] = 'failure';
	$json['error'] = 'Email already in use.';
	echo json_encode($json);
} else {
	$prehash = hash('sha256', $pass);
	$passhash = password_hash($prehash, PASSWORD_DEFAULT);
	
	$json['status'] = 'success';
	$json['response'] = array('email' => $email, 'pass' => $passhash);
	echo json_encode($json);
}
?>
