<?php 

function logActivity($userId, $activityType, $activityDescription) {

// Database Configuration
$host = 'localhost';
$db = 'project-WAD';
$user = 'postgres';
$pass = '317!!Musha4lyf';
$port = '5437';


// Create connection to Postgres
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass port=$port");

// Check Connection
if ($conn === false) { // Ensure $conn is actually a boolean before negating
    die("Connection failed: " . pg_last_error());
}

//Capture IP Address
$ipAddress = $_SERVER['REMOTE_ADDR'];

// Capture User Agent
$userAgent = $_SERVER['HTTP_USER_AGENT'];


//Add tracking information to the databse
$sql = "insert into user_activity_logging(user_id, activity_type, activity_description, ip_address, user_agent) VALUES ($1, $2, $3, $4, $5)";

//Execute the SQL for the INSERT statement
$result = pg_query_params($conn, $sql, array($userId, $activityType, $activityDescription, $ipAddress, $userAgent));

if(!$result){
    echo "Error in the query execution " . pg_last_error($conn);
} else {
    echo "Activity logged successfully";
}

//Close the connection to the database
pg_close($conn);

}




?>