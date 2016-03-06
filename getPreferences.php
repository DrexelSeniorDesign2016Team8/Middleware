<?php
require_once 'setup.php';

	$SID = $_GET['sid'];
	$result = $DB->query("select users_info.GPA as GPAvalue, users_info.SATMath as MathScore, users_info.SATReading as ReadingScore, users_info.ACT as ACTScore, users_info.ZIP as zipCode, users_info.State as stateName from user_sessions,users_info where user_sessions.SessionID = $SID and users_info.UserID = user_sessions.UserID");
	$rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = $row;
    }
    //Return as JSON page
    print json_encode($rows);

?>