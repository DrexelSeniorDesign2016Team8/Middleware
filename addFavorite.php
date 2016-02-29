<?php
require_once 'setup.php';

	$SID = $_GET['sid'];
	$InstID = $_GET['college_id'];
	$result = $DB->query("select UserID from user_sessions where SessionID = $SID");
	$userID = $result->fetch_row()[0];

	$query = "INSERT INTO users_favorites (UserID,InstID) VALUES($userID,$InstID)";

	if($DB->query($query)) {
		print "true";
	} else {
		print "error, UserID and InstID combination already exists";
	}

?>