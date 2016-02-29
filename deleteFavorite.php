<?php
require_once 'setup.php';

	$SID = $_GET['sid'];
	$UID = $_GET['college_id'];
	$userID = mysql_result($DB->query("select UserID from user_sessions where SessionID = $SID"),0,"UserID");
	echo $userID . "\n";//$query = "INSERT INTO users_favorites (UserID,InstID) VALUES($userID,$SID)";
?>