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
    $query = "select institutions.ID as instID, institutions.ID as instIDs, institutions.Name as name,  (CASE when exists(select users_favorites.InstID from users_favorites,user_sessions where user_sessions.SessionID = " . $SID . " and user_sessions.UserID = users_favorites.UserID and users_favorites.InstID = instIDs) then 1 else 0 end) as favorited from institutions, institutions_scores, users_favorites, user_sessions where institutions.ID = institutions_scores.InstID";
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
    if (!empty($GPA)) {
        $query = $query . " and institutions_scores.GPA <= " . $GPA;
    }
    if (!empty($ACT)) {
        $query = $query . " and institutions_scores.ACT <= " . $ACT;
    }
    if (!empty($math)) {
        $query = $query . " and institutions_scores.SATMath <= " . $math;
    }
    if (!empty($reading)) {
        $query = $query . " and institutions_scores.SATReading <= " . $reading;
    }
    if (!empty($name)) {
        $query = $query . " and institutions.Name like \"%" . $name . "%\"";
    }
    if (!empty($state)) {
        $query = $query . " and institutions.State = \"" . $state . "\"";
    }
    if (!empty($address)) {
        $query = $query . " and institutions.Address like \"%" . $address . "%\"";
    }
    if (!empty($accept)) {
        $query = $query . " and institutions.Acceptance >= " . $accept;
    }
    if (!empty($zip)) {
        $query = $query . " and institutions.ZIP = \"" . $zip . "\"";
    }
    if (!empty($retention)) {
        $query = $query . " and institutions.Retention >= " . $retention;
    }
    if (!empty($type)) {
        $query = $query . " and institutions.Type = \"" . $type . "\"";
    }
    if (!empty($minPop) && !empty($maxPop)) {
        $query = $query . " and institutions.Population BETWEEN " . $minPop . " and " . $maxPop;
    }
    if (!empty($minClass) && !empty($maxClass)) {
        $query = $query . " and institutions.ClassSize BETWEEN " . $minClass . " and " . $maxClass;
    }
    if (!empty($writing)) {
        $query = $query . " and institutions_scores.SATWriting <= " . $writing;
    }
    if (!empty($commonApp)) {
        $query = $query . " and institutions.CommonApp = 1";
    }
    if (!empty($favorites)) {
        $query = $query . " and user_sessions.SessionID = $SID and users_favorites.UserID = user_sessions.UserID and users_favorites.InstID = institutions.ID";
    }
    $query = $query . " group by instID order by institutions.Name";
    if (!empty($page) && !empty($pageSize)) {
        $pagesizeval = intval(pageSize);
        $pageval = intval(page);
        $pageval = 1 + (($pageval - 1) * $pagesizeval);
        $page = strval($pageval);
        $query = $query . " limit $page,$pageSize";
    } else {
        $query = $query . " limit 100";
    }

    $result = mysql_query($query);
    $rows = array();
    while($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    //Return as JSON page
    print json_encode($rows);
    mysql_close($dbhandle);
}
doSearch();
?>
