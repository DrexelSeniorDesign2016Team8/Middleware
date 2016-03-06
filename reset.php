<?php
require_once 'setup.php';

$email = db_string($_GET['email']);


$DB->query("
	SELECT ID
	FROM users
	WHERE email = '$email'");

if ($DB->has_results()) {
	$pass = substr(hash('sha256', rand()), 0, 12);
	$passhash = password_hash(hash('sha256', $pass));

	$DB->query("
		UPDATE users
		SET Password = '$passhash'
		WHERE email = '$email'");

	$msg = "Your password on searchcollege.me has been reset.\r\n\r\nYour new password is $pass\r\n.";

	mail($email, 'College Search Password Reset', $msg);
}

echo json_encode(array('status' => 'success', 'response' => 'Password reset.'));

?>
