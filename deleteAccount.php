<?php

require_once 'setup.php';
require_once 'session.class.php';

$sess_id = db_string($_GET['sid']);

$json = array();

if (Session::verify($sess_id)) {
	$user_id = Session::fetch($sess_id);
	
	$DB->query("
		DELETE FROM users
		WHERE ID = $user_id");
	
	$DB->query("
		DELETE FROM users_info
		WHERE UserID = $user_id");

	Session::kill($sess_id);

	$json['status'] = "Success";
	$json['response'] = "Account deleted";
} else {
	$json['status'] = "Error";
	$json['error'] = "Session expired";
}

echo json_encode($json);
?>
