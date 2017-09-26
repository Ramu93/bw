<?php 

require('../dbconfig.php'); 
$finaloutput = array();
if(!$_POST) {
	$action = $_GET['action'];
}
else {
	$action = $_POST['action'];
}
switch($action){
    case 'fetch_party_info':
        $finaloutput = fetchPartyInfo();
    break;
    case 'fetch_unit_info':
        $finaloutput = fetchUnitInfo();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);


function fetchPartyInfo() {
    global $dbc;
    $output=array();
    $searchterm = mysqli_real_escape_string($dbc, trim($_GET['term']));
    $query = "SELECT * FROM bonded_party_master WHERE pm_customerName LIKE '%$searchterm%'";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0) {
		$out = array();
		while($row = mysqli_fetch_assoc($result)) {
			$output[] = array( "pm_id" => $row['pm_id'],
							"value" => $row['pm_customerName'],
							"label" => $row['pm_customerName']);
		}
		//$output = array("infocode" => "PARFETCHSUCCESS", "data" => $out);
	}
	else {
		$output = array( "value" => "No customers found");
	}
	return $output;
}

function fetchUnitInfo() {
	global $dbc;
    $output=array();
    $searchterm = mysqli_real_escape_string($dbc, trim($_GET['term']));
    $query = "SELECT * FROM bonded_unit_master WHERE unit_name LIKE '%$searchterm%'";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0) {
		$out = array();
		while($row = mysqli_fetch_assoc($result)) {
			$output[] = array( "pm_id" => $row['unit_id'],
							"value" => $row['unit_name'],
							"label" => $row['unit_name']);
		}
		//$output = array("infocode" => "PARFETCHSUCCESS", "data" => $out);
	}
	else {
		$output = array( "value" => "No units found");
	}
	return $output;
}


?>