<?php
require_once 'setup.php';

	$SID = $_GET['sid'];
	$UID = $_GET['college_id'];
	$result = $DB->query("select UserID from user_sessions where SessionID = $SID");
	$userID = mysql_result($result,0,"UserID");
	echo $userID . "\n";//$query = "INSERT INTO users_favorites (UserID,InstID) VALUES($userID,$SID)";
?>