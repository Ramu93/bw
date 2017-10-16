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
    case 'fetch_item_details':
        $finaloutput = fetchItemDetails();
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}

echo json_encode($finaloutput);

function fetchItemDetails() {
    global $dbc;
    $output=array();
    $queryadd = "";
    $searchterm = mysqli_real_escape_string($dbc, trim($_GET['term']));
    $type = mysqli_real_escape_string($dbc, trim($_GET['type']));
    if($type == 'itemname'){
    	$queryadd = "item_name LIKE '%$searchterm%'";
    } else if($type == 'itemcode') {
    	$queryadd = "item_master_id LIKE '%$searchterm%'";
    }
    $query = "SELECT * FROM general_item_master WHERE $queryadd";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0) {
		$out = array();
		while($row = mysqli_fetch_assoc($result)) {
			if($type == 'itemname'){
				$output[] = array( "item_master_id" => $row['item_master_id'],
								"value" => $row['item_name']);
			}elseif($type == 'itemcode'){
				$output[] = array("value" => $row['item_master_id'],
								"label" => $row['item_name']);
			}
		}
		//$output = array("infocode" => "PARFETCHSUCCESS", "data" => $out);
		//file_put_contents("autolog.log", print_r( $output, true ), FILE_APPEND | LOCK_EX);
	}
	else {
		$output = array( "value" => "No items found");
	}
	return $output;
}

?>