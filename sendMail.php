<?php
require_once 'setup.php';
require_once 'session.class.php';
	function create_csv_string() {
    	global $DB;
	    $SID = "318080976";//$_GET['sid'];
	    $data = $DB->query("select institutions.Name as name, concat(institutions.Address, ', ',institutions.City, ' ', institutions.State, ' ', institutions.Zip) as address, institutions.Phone as phoneNumber, institutions.Population as population, institutions.URL as URL from users_favorites,user_sessions,institutions where user_sessions.SessionID = $SID and users_favorites.UserID = user_sessions.UserID and users_favorites.InstID = institutions.ID");

	    // Open temp file pointer
	    if (!$fp = fopen('php://temp', 'w+')) return FALSE;
	    
	    fputcsv($fp, array('Name', 'Address', 'Phone Number', 'Population', 'URL'));
	    
	    // Loop data and write to file pointer
	    while ($line = $data_>fetch_array(MYSQLI_NUM)) fputcsv($fp, $line);
	    
	    // Place stream pointer at beginning
	    rewind($fp);

	    // Return the data
	    return stream_get_contents($fp);

	}

	function send_csv_mail($body, $to = 'rwiley1993@gmail.com', $subject = 'Website Report', $from = 'CollegeSearch@searchcollege.me') {

	    // This will provide plenty adequate entropy
	    $multipartSep = '-----'.md5(time()).'-----';

	    // Arrays are much more readable
	    $headers = array(
	        "From: CollegeSearch@searchcollege.me",
	        "Reply-To: CollegeSearch@searchcollege.me",
	        "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
	    );

	    // Make the attachment
	    $attachment = chunk_split(base64_encode(create_csv_string())); 

	    // Make the body of the message
	    $body = "--$multipartSep\r\n"
	        . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
	        . "Content-Transfer-Encoding: 7bit\r\n"
	        . "\r\n"
	        . "$body\r\n"
	        . "--$multipartSep\r\n"
	        . "Content-Type: text/csv\r\n"
	        . "Content-Transfer-Encoding: base64\r\n"
	        . "Content-Disposition: attachment; filename=\"Website-Report-" . date("F-j-Y") . ".csv\"\r\n"
	        . "\r\n"
	        . "$attachment\r\n"
	        . "--$multipartSep--";

	    // Send the email, return the result
	    return @mail($to, $subject, $body, implode("\r\n", $headers)); 

	}
	send_csv_mail("Here is a CSV of your favorited institutions");
?>
