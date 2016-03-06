<?php
require_once 'setup.php';

class Session {
	// Creates a session, returns a session id
	static function create($userID)
	{	
		global $DB;
		if ($userID == "") {
			return false;
		}

		$characters  = '0123456789';
		$session = '';
		for ($i = 0; $i < 9; $i++) {
			$session .= $characters[rand(0, strlen($characters) - 1)];
		}
		$expiry = time() + (4*60*60);
		$query = "INSERT INTO user_sessions (UserID,SessionID,Expiration) VALUES($userID,$session,$expiry)";

		if($DB->query($query)){
			return $session;
		} else {
			return false;
		}
	}

	// Verify that the session is valid
	static function verify($sess_id) {
		global $DB;

		$DB->query("
			SELECT Expiration
			FROM user_sessions
			WHERE
				SessionID = " . db_string($sess_id));

		if ($DB->has_results()) {
			list($expiry) = $DB->next_record();
			$expiry = int($expiry);

			if (time() > $expiry) {
				$this->kill($sess_id);
				return false;		
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	// get user ID corresponding to session ID
	static function fetch($sess_id) {
		global $DB;
		//if ($this->verify($sess_id)) {
			$DB->query("
				SELECT UserID
				FROM user_sessions
				WHERE SessionID = " . db_string($sess_id));
			if ($DB->has_results()) {
				list($user_id) = $DB->next_record();
				return $user_id;
			} else {
				return false;
			}
		//} else {
		//	return false;
		//}
	}

	// Update the sessions expiry time
	static function update($sess_id) {
		global $DB;
		
		if ($this->verify($sess_id)) {
			$DB->query("
				UPDATE user_session
				SET Expiration = ". (time() + 4*60*60) . "
				WHERE SessionID = " . db_string($sess_id));
			return true;
		} else {
			return false;
		}
	}

	// Kill a session
	static function kill($sess_id) {
		global $DB;

		$DB->query("
			DELETE FROM user_sessions
			WHERE SessionID = " . db_string($sess_id));
	}
}
?>
