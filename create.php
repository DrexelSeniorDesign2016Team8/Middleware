<?php

require_once 'start.php';

// create a user account

// escape email, but don't escape password--we need to hash it.
$email = db_string($_GET['email']);
$pass = $_GET['pass'];

$prehash = hash('sha256', $pass);
var_dump($prehash);

$hash = password_hash($prehash, PASSWORD_DEFAULT);
var_dump($hash);

?>
