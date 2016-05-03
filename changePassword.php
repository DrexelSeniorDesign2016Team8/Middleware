<?php

require_once 'setup.php';
require_once 'session.class.php';

// Change the user password

// escape email, but don't escape password--we need to hash it.
$email = db_string($_GET['email']);
$pass = $_GET['pass'];
$oldpass = $_GET['oldpass'];
$json = array();

if ($email == "") {
	$json['status'] = 'error';
	$json['error'] = 'Email is null.';
} elseif ($pass === null) {
	$json['status'] = 'error';
	$json['error'] = 'Password is null.';
} elseif ($oldpass == null) {
	$json['status'] = 'error';
	$json['error'] = 'Old password is null.';
} else {
	$DB->query("
		SELECT ID, Password
		FROM users
		WHERE Email = '$email'");

	if ($DB->has_results()) {
		list($user_id, $old_pass_hash) = $DB->next_record();
		$valid = password_verify(hash('sha256', $oldpass), $old_pass_hash);
	if(!$valid) {	
		$json['status'] = 'error';
		$json['error'] = 'Old password is incorrect';
	}
	$prehash = hash('sha256', $pass);
	$passhash = password_hash($prehash, PASSWORD_DEFAULT);
	$DB->query("
		UPDATE users
		SET Password='$passhash'
		WHERE Email = '$email'");

	if ($DB->has_results()) {
		$json['status'] = 'success';
	} else {
		$json['status'] = 'error';
		$json['response'] = 'Error changing password please try again';
	}
}

echo json_encode($json);
?>
