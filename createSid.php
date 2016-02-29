<?php
function createSID($userID)
{
	require_once 'setup.php';
	if ($userID == "") {
		return null;
	}

	$characters  = '0123456789';
	$session = '';
	for ($i = 0; $i < 11; $i++) {
		$session .= $characters[rand(0, strlen($characters) - 1)];
	}
	$currTime = time();
	$query = "INSERT INTO user_sessions (UserID,SessionID,Expiration) VALUES($userID,$session,$currTime)";

	if($DB->query($query)){
		return $session;
	} else {
		return null;
	}
}
echo createSID("10") . "\n";
?>