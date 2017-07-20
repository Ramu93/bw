<?php
///if(!defined('TIMEZONE'))
	//define('TIMEZONE', 'America/Toronto');
if(!defined('HOMEURL'))
	define('HOMEURL', 'http://localhost:8888/bonded_warehouse/general');

if(!defined('LIBRARYURL'))
	define('LIBRARYURL', 'http://localhost:8888/bonded_warehouse/assets');

//date_default_timezone_set(TIMEZONE);
// This file establishes a connection to MySQL 
// and selects the database.

//Set the configuration of your MySQL server
$db_servername = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db_name = 'bonded_warehouse';

// Connect to MySQL:
$dbc = mysqli_connect ($db_servername,$db_username,$db_password,$db_name);

// Confirm the connection and select the database:

if (mysqli_connect_errno()) {
    echo "Could not establish database connection!<br>";
    exit();
}

?>
