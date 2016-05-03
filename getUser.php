<?php

require_once 'setup.php';
require_once 'session.class.php';

$json = array();
$sid = $_GET['sid'];

$user_name = Session::fetchName($sid);
if($user_name == false) {
	$json['status'] = 'error';
	$json['error'] = 'No user found for this session';
} else {
	$json['status'] = 'success';
	$json['response'] = array('userName' => $user_name);
}

echo json_encode($json);
?>
