<?php
require_once 'setup.php';
require_once 'session.class.php';
	$SID = '318080976';//$_GET['sid'];

	$user = Session::fetch($SID);
	$GPA = '3.0';//$_GET['GPAvalue'];
	if(empty($GPA)) {
		$GPA = "null";
	}
    $ACT = '20';//$_GET['ACTScore'];
    if(empty($ACT)) {
		$ACT = "null";
	}
    $math = '600';//$_GET['MathScore'];
    if(empty($math)) {
		$math = "null";
	}
    $reading = '600';//$_GET['ReadingScore'];
    if(empty($reading)) {
		$reading = "null";
	}
    $state = 'PA';//$_GET['stateName'];
    if(empty($state)) {
		$state = "null";
	}
    $zip = '19104';//$_GET['zipCode'];
    if(empty($zip)) {
		$zip = "null";
	}
    $DB->query("delete from users_info where UserID = $user");
    if($DB->query("insert into users_info (UserID,GPA,SATMath,SATReading,ACT,ZIP,State) VALUES($user,$GPA,$math,$reading,$ACT,'$zip','$state')")) {
    	print "true";
    } else {
    	print "Error: Could not save preferences";
    }
?>