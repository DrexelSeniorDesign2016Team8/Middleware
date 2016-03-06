<?php
require_once 'setup.php';
require_once 'session.class.php';
	$SID = $_GET['sid'];

	$user = Session::fetch($SID);

	$GPA = $_GET['GPAvalue'];
	if(empty($GPA)) {
		$GPA = "null";
	}
    $ACT = $_GET['ACTScore'];
    if(empty($ACT)) {
		$ACT = "null";
	}
    $math = $_GET['MathScore'];
    if(empty($math)) {
		$math = "null";
	}
    $reading = $_GET['ReadingScore'];
    if(empty($reading)) {
		$reading = "null";
	}
    $state = $_GET['stateName'];
    if(empty($state)) {
		$state = "null";
	}
    $zip = $_GET['zipCode'];
    if(empty($zip)) {
		$zip = "null";
	}
    $DB->query("delete from users_info where UserID = $user"))
    if($DB->query("insert into users_info (UserID,GPA,SATMath,SATReading,ACT,ZIP,State) VALUES($user,$GPA,$math,$reading,$ACT,'$zip','$state'")) {
    	print "true";
    } else {
    	print "Error: Could not save preferences";
    }
?>