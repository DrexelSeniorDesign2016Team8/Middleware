<?php
require_once 'setup.php';

	$instID = $_GET['instID'];
	$sid = $_GET['sid']
	if(empty($sid)) {
        $sid = "0";
    }
	$result = $DB->query("select institutions.ID as instID, institutions.Name as name, concat(institutions.Address, ', ',institutions.City, ' ', institutions.State, ' ', institutions.Zip) as address, institutions.Phone as phoneNumber, institutions.Population as population, institutions.URL as URL,(CASE when exists(select users_favorites.InstID from users_favorites,user_sessions where user_sessions.SessionID = " . $sid . " and user_sessions.UserID = users_favorites.UserID and users_favorites.InstID = $instID) then 1 else 0 end) as favorited from users_favorites,user_sessions,institutions where user_sessions.SessionID = $sid and users_favorites.UserID = user_sessions.UserID and users_favorites.InstID = institutions.ID");
	$rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = $row;
    }
    //Return as JSON page
    print json_encode($rows);

?>
