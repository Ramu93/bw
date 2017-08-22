<?php
///if(!defined('TIMEZONE'))
	//define('TIMEZONE', 'America/Toronto');
if(!defined('HOMEURL'))
	define('HOMEURL', 'http://ideashack.in/bonded_warehouse/bonded');

if(!defined('HOMEURLGENERAL'))
	define('HOMEURLGENERAL', 'http://ideashack.in/bonded_warehouse/general/');

if(!defined('LIBRARYURL'))
	define('LIBRARYURL', 'http://ideashack.in/bonded_warehouse/assets');

//date_default_timezone_set(TIMEZONE);
// This file establishes a connection to MySQL 
// and selects the database.

//Set the configuration of your MySQL server
$db_servername = 'localhost';
$db_username = 'shreefas_bondusr';
$db_password = 'TMTbond123$';
$db_name = 'shreefas_bonded';

// Connect to MySQL:
$dbc = mysqli_connect ($db_servername,$db_username,$db_password,$db_name);

// Confirm the connection and select the database:

if (mysqli_connect_errno()) {
    echo "Could not establish database connection!<br>";
    exit();
}

?>
