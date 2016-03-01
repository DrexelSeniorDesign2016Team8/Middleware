<?php
require_once 'setup.php';

	$SID = $_GET['sid'];
	$result = $DB->query("select institutions.ID as instID, institutions.Name as name, concat(institutions.Address, ', ',institutions.City, ' ', institutions.State, ' ', institutions.Zip) as address, institutions.Phone as phoneNumber, institutions.Population as population from users_favorites,user_sessions,institutions where user_sessions.SessionID = $SID and users_favorites.UserID = user_sessions.UserID and users_favorites.InstID = institutions.ID");
	$rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = $row;
    }
    //Return as JSON page
    print json_encode($rows);

?>