<?php
	require('../dbconfig.php'); 
	//require('../dbconfig_pdo.php'); 
	//require('../dbwrapper.php');
	require('../formwrapper.php');
	require('../dbwrapper_mysqli.php');

	//define('IGP_LOADING_DEFAULT_STATUS','created');
	define('JOBORDER_CREATED_STATUS','created');
	define('JOBORDER_COMPLETE_STATUS','completed');
	define('IGP_JOBORDER_CREATE_STATUS','joborder_created');
	define('IGP_JOBORDER_COMPLETE_STATUS','joborder_completed');


	$db = new DBWrapper($dbc);
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
	    case 'create_job_order':
	    	$finaloutput = createJobOrder();
	    break;
	    case 'complete_job_order':
	    	$finaloutput = completeJobOrder();
	    break;
	    case 'get_pdr_items':
	    	$finaloutput = getPDRItemsList();
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
				$query = "SELECT pdr_id as 'data_item' FROM bonded_despatch_request WHERE igp_created='yes' AND document_verified='yes'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item' FROM bonded_despatch_request WHERE igp_created='yes' AND document_verified='yes'";
			break;
			case 'bond_number':
				$query = "SELECT bond_number as 'data_item' FROM bonded_despatch_request WHERE igp_created='yes' AND document_verified='yes'";
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
				$query = "SELECT * FROM bonded_despatch_request WHERE pdr_id='$dataValue'";
			break;
			case 'boe_number':
				$query = "SELECT * FROM bonded_despatch_request WHERE boe_number='$dataValue'";
			break;
			case 'bond_number':
				$query = "SELECT * FROM bonded_despatch_request WHERE bond_number='$dataValue'";
			break;
		}

		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$out = mysqli_fetch_assoc($result);

			//fetched the space_occupied value from GRN table. This is the initial space occupied
			$getSpaceQuery = 'SELECT no_of_units FROM bonded_good_receipt_note WHERE sac_id=\'' .$out['sac_id']. '\'';

			$spaceResult = mysqli_query($dbc, $getSpaceQuery);
			if(mysqli_num_rows($spaceResult) > 0){
				$spaceRow = mysqli_fetch_assoc($spaceResult);
				$out['space_occupied_before'] = $spaceRow['no_of_units']; 
			} else {
				return array("infocode" => "DATADETAILFETCHSUCCESS", "message" => "No GRN data available.");
			}

			//file_put_contents("querylog.log", print_r($out, true ));
			$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($out));
		}
		//file_put_contents("datalog.log", print_r(json_encode($output), true ));
		return $output;
	}

	function getPDRItemsList(){
		global $dbc;
		$pdrId = mysqli_real_escape_string($dbc, trim($_POST['pdr_id']));
		$query = "SELECT * FROM bonded_pdr_items WHERE pdr_id='$pdrId'";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			while ($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
		}
		//file_put_contents("datalog.log", print_r($out, true ));
		$output = array("infocode" => "ITEMDATAFETCHSUCCESS", "data" => json_encode($out));
		return $output;
	}

	function createJobOrder(){
		global $dbc;
		$pdrId = $_POST['pdr_id_hidden'];
		$spaceOccupiedAfter = mysqli_real_escape_string($dbc, trim($_POST['space_occupied_after']));
		$supervisorName = mysqli_real_escape_string($dbc, trim($_POST['supervisor_name']));
		$loadingType = mysqli_real_escape_string($dbc, trim($_POST['loading_type']));
		$equipmentRefNumber = mysqli_real_escape_string($dbc, trim($_POST['equipment_ref_number']));
		$noOfLabors = mysqli_real_escape_string($dbc, trim($_POST['no_of_labors']));
		$loadingTime = mysqli_real_escape_string($dbc, trim($_POST['loading_time']));

		$query = "INSERT INTO bonded_joborder_loading(pdr_id, space_occupied_after, supervisor_name, loading_type, equipment_ref_number, no_of_labors, loading_time, created_date) VALUES ('$pdrId', '$spaceOccupiedAfter', '$supervisorName', '$loadingType', '$equipmentRefNumber', '$noOfLabors', '$loadingTime', '".date("Y-m-d")."')";
		if(mysqli_query($dbc, $query)){
			$lastInsertJobOrderId = mysqli_insert_id($dbc);
			changeIGPStatus($lastInsertJobOrderId, IGP_JOBORDER_CREATE_STATUS);
			$output = array("infocode" => "JOBORDERCREATESUCCESS", "data" => $lastInsertJobOrderId, "message" => "Job order created successfully");
		} else {
			$output = array("infocode" => "JOBORDERCREATEFAILURE", "message" => "Job order not created.","data"=>"");
		}

		return $output;
	}

	function completeJobOrder(){
		global $dbc;
		$jlId = $_POST['jl_id'];
		$query = "UPDATE bonded_joborder_loading SET status='completed' WHERE jl_id='$jlId'";
		// file_put_contents("querylog.log",$query, FILE_APPEND | LOCK_EX);
		if(mysqli_query($dbc, $query)){
			//add OGP-loading entry
			addOGPEntry($jlId);
			//add GDN entry
			addGDNEntry(getPdrId($jlId));
			//change the status of IGP - loading to joborder_complete
			changeIGPStatus($jlId, IGP_JOBORDER_COMPLETE_STATUS);
			$output = array("infocode"=>"JOBORDERCOMPLETED","message"=>"Job order completed successfully.");
		} else {
			array("infocode"=>"JOBORDERNOTCOMPLETED","message"=>"Job order not completed.");
		}
		return $output;
	}

	function addOGPEntry($jlId){
		global $dbc;
		$query = "INSERT INTO bonded_ogp_loading (jl_id, created_date) VALUES ('$jlId', '".date("Y-m-d")."')";
		mysqli_query($dbc, $query);
	}

	function addGDNEntry($pdrId){
		global $dbc;
		$query = "INSERT INTO bonded_good_delivery_note (pdr_id, created_date) VALUES ($pdrId, '".date("Y-m-d")."')";
		mysqli_query($dbc, $query);
	}

	function changeIGPStatus($jlId, $status){
		global $dbc;
		$pdrId = getPdrId($jlId);
		$query = "UPDATE bonded_igp_loading SET status='$status' WHERE pdr_id='$pdrId'";
		// file_put_contents("querylog.log",$query, FILE_APPEND | LOCK_EX);
		mysqli_query($dbc, $query);
		//updatePDRStatus($pdrId, $status);
	}

	function getPdrId($jlId){
		global $dbc;
		$query = "SELECT pdr_id FROM bonded_joborder_loading WHERE jl_id='$jlId'";
		// file_put_contents("querylog.log",$query, FILE_APPEND | LOCK_EX);
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		return $row['pdr_id'];
	}

	function updatePDRStatus($pdrId, $status){
		global $dbc;
		$query = "UPDATE bonded_despatch_request SET status='$status' WHERE pdr_id='$pdrId'";
		mysqli_query($dbc, $query);
	}
?>