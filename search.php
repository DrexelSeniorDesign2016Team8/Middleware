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
    //Create beginning part of query
    $query = "select institutions.Name as name, concat(institutions.Address, ', ',institutions.City, ' ', institutions.State, ' ', institutions.Zip) as address, institutions.Phone as phoneNumber, institutions.Population as population from institutions, institutions_scores where institutions.ID = institutions_scores.InstID";
    //Get variables of call
    $ACT = $_GET['ACTScore'];
    $math = $_GET['mathScore'];
    $reading = $_GET['readingScore'];
    $name = $_GET['name'];
    $state = $_GET['stateName'];
    $zip = $_GET['zipCode'];
    $address = $_GET['fullAddress'];
    $accept = $_GET['acceptanceRate'];
    $retention = $_GET['retentionRate'];
    $type = $_GET['institutionType'];
    $pop = $_GET['studentPopulation'];
    //Just prepend sql messages for now
    //Need to check that inputs are correct eventually
    //Check if a value exists for a parameter, if it does change the query
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
    if (!empty($pop)) {
        $query = $query . " and institutions.Population <= " . $pop;
    }
    $query = $query . " order by institutions.Name limit 10";
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
