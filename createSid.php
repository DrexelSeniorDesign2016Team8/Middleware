<?php
require_once 'setup.php';

function createSID($userID)
{
	if ($userID == "") {
		return null;
	}

	$characters  = '0123456789';
	$session = '';
	for ($i = 0; $i < 11; $i++) {
		$session .= $characters[rand(0, strlen($characters) - 1)];
	}
	$currTime = time();
	if($DB->query("
                INSERT INTO user_sessions (UserID,SessionID,Expiration)
                ldap_get_values(link_identifier, result_entry_identifier, attribute)
                ($userID,$session,$currTime)")) {
		return $session;
	} else {
		return null;
	}
}
print createSID("10");
?>