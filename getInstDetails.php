<?php
require_once 'setup.php';

	$instID = $_GET['instID'];
	$sid = $_GET['sid'];
	if(empty($sid)) {
        $sid = "0";
    }
    $query = "select institutions.ID as instID, institutions.Name as name, concat(institutions.Address, ', ',institutions.City, ' ', institutions.State, ' ', institutions.Zip) as address, institutions.Phone as phoneNumber, institutions.Population as population, institutions.URL as URL,(CASE when exists(select users_favorites.InstID from users_favorites,user_sessions where user_sessions.SessionID = " . $sid . " and user_sessions.UserID = users_favorites.UserID and users_favorites.InstID = $instID) then 1 else 0 end) as favorited, institutions_scores.GPA as GPA, institutions_scores.SATMath as SATMath, institutions_scores.SATReading as SATReading, institutions_scores.SATWriting as SATWriting, institutions_scores.ACT as ACT from users_favorites,user_sessions,institutions,institutions_scores where institutions.ID = $instID and institutions_scores.instID = institutions.ID limit 1";
	$result = $DB->query($query);
	$rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = $row;
    }
    if(count($rows) > 0) {
    	$temp = array();
    	echo json_encode(array('status' => 'success', 'response' => $rows))
    } else {
    	echo json_encode(array('status' => 'failure', 'response' => 'No response from query'))
    }
    //Return as JSON page
    print json_encode($rows);

?>
