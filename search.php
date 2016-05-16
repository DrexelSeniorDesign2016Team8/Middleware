<?php
//Do Search on inputted parameters
function doSearch()
{
    //Set up database connections
    $username = "root";
    $password = "team8sqlpass";
    $hostname = "localhost";
    $dbhandle = mysql_connect($hostname, $username, $password) 
        or die("Unable to connect to MySQL");
    $selected = mysql_select_db("college_search",$dbhandle)
        or die("Could not select Table");
    $SID = $_GET['sid'];
    if(empty($SID)) {
        $SID = "0";
    }
    //Create beginning part of query
    //$query = "select SQL_CALC_FOUND_ROWS institutions.ID as instID, institutions.ID as instIDs, institutions.Name as name,  (CASE when exists(select users_favorites.InstID from users_favorites,user_sessions where user_sessions.SessionID = " . $SID . " and user_sessions.UserID = users_favorites.UserID and users_favorites.InstID = instIDs) then 1 else 0 end) as favorited from institutions, institutions_scores, users_favorites, user_sessions where institutions.ID = institutions_scores.InstID";

		//$query = "SELECT SQL_CALC_FOUND_ROWS institutions.ID, institutions.name, (SELECT COUNT(users_favorites.UserID) FROM users_favorites JOIN user_sessions ON user_sessions.UserID = users_favorites.UserID WHERE user_sessions.SessionID = '$SID' AND users_favorites.InstID = institutions.ID) as favorited
		//	FROM institutions
		//	JOIN institutions_scores ON institutions.ID = institutions_scores.InstID";

		$query = "SELECT SQL_CALC_FOUND_ROWS institutions.ID, institutions.Name, favorite.count AS favorited
			FROM institutions
			JOIN institutions_scores ON institutions.ID = institutions_scores.InstID
			LEFT JOIN (SELECT users_favorites.InstID as InstID, COUNT(*) AS count FROM users_favorites JOIN user_sessions ON user_sessions.UserID = users_favorites.UserID WHERE users_sessions.SessionID = '$SID' GROUP BY InstID) AS favorite ON favorite.InstID = institutions.ID";

    //Get variables of call
    //$writing = $_GET['WritingScore'];

    $GPA = $_GET['GPAvalue'];
    $ACT = $_GET['ACTScore'];
    $math = $_GET['MathScore'];
    $reading = $_GET['ReadingScore'];
    $writing = $_GET['WritingScore'];
    $name = $_GET['name'];
    $state = $_GET['stateName'];
    $address = $_GET['fullAddress'];
    $accept = $_GET['AcceptanceRate'];
    $zip = $_GET['zipCode'];
    $retention = $_GET['retentionRate'];
    $type = $_GET['institutionType'];
    $minPop = $_GET['minPop'];
    $maxPop = $_GET['maxPop'];
    $minClass = $_GET['minClass'];
    $maxClass = $_GET['maxClass'];
    $commonApp = $_GET['commonApplication'];
    $favorites = $_GET['favoritedInstitutions'];

    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //Just prepend sql messages for now
    //Need to check that inputs are correct eventually
    //Check if a value exists for a parameter, if it does change the query
		$query_parts = array();
    if (!empty($GPA)) {
			array_push($query_parts, "institution_scores.GPA <= $GPA");
    }
    if (!empty($ACT)) {
			array_push($query_parts, "institution_scores.ACT <= $ACT");
    }
    if (!empty($math)) {
			array_push($query_parts, "institution_scores.SATMath <= $math");
    }
    if (!empty($reading)) {
			array_push($query_parts, "institution_scores.SATReading <= $reading");
    }
    if (!empty($writing)) {
			array_push($query_parts, "institution_scores.SATWriting <= $writing");
    }
    if (!empty($name)) {
			array_push($query_parts, "institutions.Name like \"%" . $name . "%\"");
    }
    if (!empty($state)) {
			array_push($query_parts, "institutions.state = '$state'");
    }
    if (!empty($address)) {
			array_push($query_parts, "institutions.Address like \"%" . $address . "%\"");
    }
    if (!empty($accept)) {
			array_push($query_parts, "institutions.Acceptance >= $accept");
    }
    if (!empty($zip)) {
			array_push($query_parts, "institutions.ZIP = '$zip'");
    }
    if (!empty($retention)) {
			array_push($query_parts, "institutions.Retention >= $retention");
    }
    if (!empty($type)) {
			array_push($query_parts, "institutions.Type = '$type'");
    }
    if (!empty($minPop) && !empty($maxPop)) {
			array_push($query_parts, "institutions.Population BETWEEN $minpop AND $maxpop");
    }
    if (!empty($minClass) && !empty($maxClass)) {
			array_push($query_parts, "institutions.ClassSize BETWEEN $minClass AND $maxClass");
    }
    if (!empty($commonApp)) {
			array_push($query_parts, "institutions.CommonApp = 1");
    }
		if (!empty($query_parts)) {
			$query = $query . " WHERE ";
			$query = $query . implode(" AND ", $query_parts);
		}

		$query .= " GROUP BY institutions.ID";

		if (!empty($favorites)) {
			$query .= " HAVING favorited = 1";
		}

		$query .= " ORDER BY institutions.Name";

    if (!empty($page) && !empty($pageSize)) {
        $pageval = 1 + (((int)$page - 1) * (int)$pageSize);
        $query = $query . " limit $pageval,$pageSize";
    } else {
        $query = $query . " limit 100";
    }
    $result = mysql_query($query);
    $rows = array();
    while($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    //Get the total number of results from the last query regardless of the limit and add it to the end of the JSON
    $result = mysql_query("select FOUND_ROWS() as totalRows");
    while($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    if(count($rows) > 0) {
        echo json_encode(array('status' => 'success', 'response' => $rows));
    } else {
        echo json_encode(array('status' => 'Error', 'response' => 'No response from query'));
    }
    mysql_close($dbhandle);
}
doSearch();
?>

