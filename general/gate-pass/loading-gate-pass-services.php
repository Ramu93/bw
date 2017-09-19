<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('IGP_LOADING_DEFAULT_STATUS','created');
	define('IGP_CREATED_STATUS','igp_created');
	define('OGP_COMPLETE_STATUS','completed');


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
	    case 'set_vehivle_left_timestamp':
	    	$finaloutput = setVehicleLeftTimeStamp();
	    break;
	    case 'get_pdr_items_count':
	    	$finaloutput = getPDRItemsCount();
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
				$query = "SELECT pdr_id as 'data_item' FROM general_despatch_request WHERE status='approved'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item' FROM general_despatch_request WHERE status='approved'";
			break;
			case 'bond_number':
				$query = "SELECT bond_number as 'data_item' FROM general_despatch_request WHERE status='approved'";
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
				$query = "SELECT * FROM general_despatch_request WHERE pdr_id='$dataValue'";
			break;
			case 'boe_number':
				$query = "SELECT * FROM general_despatch_request WHERE boe_number='$dataValue'";
			break;
			case 'bond_number':
				$query = "SELECT * FROM general_despatch_request WHERE bond_number='$dataValue'";
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

		$query = "INSERT INTO general_igp_loading (pdr_id, data_type, data_value, vehicle_number, driver_name, driving_license,time_in, entry_date) VALUES ('$pdrId', '$dataType', '$dataValue', '$vehicleNumber', '$driverName', '$drivingLicense', '$timeIn', '".date("Y-m-d")."')";
		//file_put_contents("testlog.log",$query, FILE_APPEND | LOCK_EX);
		if(mysqli_query($dbc, $query)){
			$updatePdrStatusQuery = "UPDATE general_despatch_request SET igp_created='yes' WHERE pdr_id='$pdrId'";
			
			if(mysqli_query($dbc, $updatePdrStatusQuery)){
				return array("status"=>"Success","message"=>"Inward gate pass generated successfully.");
			} else {
				return array("status"=>"Failure","message"=>"Inward gate pass not generated successfully.");
			}
		}

	}

	function getPDRItemsCount(){
		global $dbc;
		$pdrId = mysqli_real_escape_string($dbc, trim($_POST['pdr_id']));
		$query = "SELECT sum(despatch_qty) as 'qty' FROM general_pdr_items WHERE pdr_id='$pdrId'";
		$result = mysqli_query($dbc, $query);
		$qty = 0;
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$qty = $row['qty'];
		}
		file_put_contents("datalog.log", print_r($qty, true ));
		$output = array("infocode" => "ITEMDATAFETCHSUCCESS", "data" => $qty);
		return $output;
	}

	function setVehicleLeftTimeStamp(){
		global $dbc;
		$ogpId = $_POST['ogp_lo_id'];
		$query = "UPDATE general_ogp_loading SET exit_time=now(), status='".OGP_COMPLETE_STATUS."' WHERE ogp_lo_id='$ogpId'";
		if(mysqli_query($dbc, $query)){
			$output = array("infocode"=>"success","message"=>"Out gate-pass completed.");
		} else {
			$output = array("infocode"=>"failure","message"=>"Out gate-pass not completed.");
		}
		return $output;
	}
?>