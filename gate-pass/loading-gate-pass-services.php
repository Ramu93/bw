<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('IGP_LOADING_DEFAULT_STATUS','created');
	define('IGP_CREATED_STATUS','igp_created');

	$db = new DBWrapper($dbobj);
	$form = new FormWrapper();

	$finaloutput = array();

	if(!$_POST) {
		$action = $_GET['action'];
	}
	else {
		$action = $_POST['action'];
	}
	
	switch($action){
	    case 'get_list':
	        $finaloutput = getDataList();
	    break;
	    case 'get_selected_data_details':
	    	$finaloutput = getSelectedDataDetails();
	    break;
	    case 'generate_igp':
	    	$finaloutput = generateIGP();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function getDataList(){
		global $dbc;
		$dataType = $_POST['data_type'];
		$query = "";
		switch ($dataType) {
			case 'pdr_id':
				$query = "SELECT pdr_id as 'data_item' FROM despatch_request WHERE status='approved'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item' FROM despatch_request WHERE status='approved'";
			break;
			case 'bond_number':
				$query = "SELECT bond_number as 'data_item' FROM despatch_request WHERE status='approved'";
			break;
			default:
			break;
		}

		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$out = array();
			while($row = mysqli_fetch_assoc($result)) {
				$out[] = $row;
			}
			$output = array("infocode" => "DATAFETCHSUCCESS", "data" => $out);
		}
		else {
			$output = array("infocode" => "NOPDRFOUND", "message" => "The entered data is not available","data"=>"");
		}
		//file_put_contents("formlog.log", print_r( $output, true ));
		return $output;
	}

	function getSelectedDataDetails(){
		global $dbc;
		$dataType = $_POST['data_type'];
		$dataValue = $_POST['data_value'];
		$query = "";
		switch ($dataType) {
			case 'pdr_id':
				$query = "SELECT * FROM despatch_request WHERE pdr_id='$dataValue'";
			break;
			case 'boe_number':
				$query = "SELECT * FROM despatch_request WHERE boe_number='$dataValue'";
			break;
			case 'bond_number':
				$query = "SELECT * FROM despatch_request WHERE bond_number='$dataValue'";
			break;
		}

		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$out = array();
			while($row = mysqli_fetch_assoc($result)) {
				$out[] = $row;
			}
			$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($out));
		}
		//file_put_contents("datalog.log", print_r(json_encode($output), true ));
		return $output;
	}


	function generateIGP(){
		global $dbc; 
		$dataType = mysqli_real_escape_string($dbc, trim($_POST['select_by_type']));
		$dataValue = mysqli_real_escape_string($dbc, trim($_POST['data_item']));
		$vehicleNumber = mysqli_real_escape_string($dbc, trim($_POST['vehicle_number']));
		$driverName = mysqli_real_escape_string($dbc, trim($_POST['driver_name']));
		$drivingLicense = mysqli_real_escape_string($dbc, trim($_POST['driving_license']));
		$timeIn = mysqli_real_escape_string($dbc, trim($_POST['in_time']));
		$pdrId = mysqli_real_escape_string($dbc, trim($_POST['pdr_id_hidden']));

		$query = "INSERT INTO igp_loading (pdr_id, data_type, data_value, vehicle_number, driver_name, driving_license,time_in, entry_date) VALUES ('$pdrId', '$dataType', '$dataValue', '$vehicleNumber', '$driverName', '$drivingLicense', '$timeIn', '".date("Y-m-d")."')";
		//file_put_contents("testlog.log",$query, FILE_APPEND | LOCK_EX);
		if(mysqli_query($dbc, $query)){
			switch ($dataType) {
				case 'pdr_id':
					$updatePdrStatusQuery = "UPDATE despatch_request SET status='". IGP_CREATED_STATUS ."' WHERE pdr_id='$dataValue'";
				break;
				case 'boe_number':
					$updatePdrStatusQuery = "UPDATE despatch_request SET status='". IGP_CREATED_STATUS ."' WHERE boe_number='$dataValue'";
				break;
				case 'bond_number':
					$updatePdrStatusQuery = "UPDATE despatch_request SET status='". IGP_CREATED_STATUS ."' WHERE bond_number='$dataValue'";
				break;
			}
			// file_put_contents("testlog.log",$updatePdrStatusQuery, FILE_APPEND | LOCK_EX);
			
			if(mysqli_query($dbc, $updatePdrStatusQuery)){
				return array("status"=>"Success","message"=>"Inward gate pass generated successfully.");
			} else {
				return array("status"=>"Failure","message"=>"Inward gate pass not generated successfully.");
			}
		}

	}
?>