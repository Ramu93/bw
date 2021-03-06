<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('IGP_UNLOADING_DEFAULT_STATUS','created');
	define('IGP_CREATED_STATUS','yes');
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
	    case 'get_container_data':
	    	$finaloutput = getContainerData();
	    break;
	    case 'generate_igp':
	    	$finaloutput = generateIGP();
	    break;
	    case 'set_vehivle_left_timestamp':
	    	$finaloutput = setVehicleLeftTimeStamp();
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
			case 'customer_name':
				$query = "SELECT importing_firm_name as 'data_item', par_id FROM pre_arrival_request WHERE status='approved'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item', par_id FROM pre_arrival_request WHERE status='approved'";
			break;
			case 'par':
				$query = "SELECT par_id as 'data_item', par_id FROM pre_arrival_request WHERE status='approved'";
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
			$output = array("infocode" => "NOPARFOUND", "message" => "The entered data is not available","data"=>"");
		}
		//file_put_contents("formlog.log", print_r( $output, true ));
		return $output;
	}

	function getSelectedDataDetails(){
		global $dbc;
		$parId = $_POST['par_id'];
		$query = "SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name FROM pre_arrival_request WHERE par_id='$parId' AND status='approved'";
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

	function getContainerData(){
		global $dbc;
		$parID = $_POST['par_id'];
		$containerRows = array();
		$query = "SELECT * FROM par_container_info WHERE id='" . $parID . "' AND has_containers='yes'";
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			while($containerRow = mysqli_fetch_assoc($result)){
					$containerRows[] = $containerRow;
			}
			$output = array("infocode" => "CONTAINERDATAFETCHSUCCESS", "data" => json_encode($containerRows));
		} else {
			$output = array("infocode" => "NOCONTAINERDATAFOUND", "data" => "No container data available.");
		}
		//file_put_contents("formlog.log", print_r(json_encode($output), true ));
		return $output;
	}

	function updateIGPStatusSACPARTable(){
		global $dbc;
		$id = $_POST['par_id'];
		
		$query = "UPDATE pre_arrival_request SET igp_created='" . IGP_CREATED_STATUS . "' WHERE par_id='$id'";
    	mysqli_query($dbc,$query);
    	//file_put_contents("formlog.log", print_r( $query, true ));
	}

	// function generateIGP(){
	// 	global $db,$form;
	// 	$igpUnloadingFormArray = array("select_by_type"=>"data_type","data_item"=>"data_value","vehicle_number"=>"vehicle_number","driver_name"=>"driver_name","driving_license"=>"driving_license","container_number"=>"container_number","seal_number"=>"seal_number","in_time"=>"time_in","container_condition"=>"container_condition","vehicle_type"=>"vehicle_type","transporter_name"=>"transporter_name", "entry_date"=>"date", "sac_par_table"=>"sac_par_table", "sac_par_id"=>"sac_par_id");
	// 	$igpUnloadingFormArray = $form->getFormValues($igpUnloadingFormArray,$_POST);
	// 	$igpUnloadingFormArray['status'] = IGP_UNLOADING_DEFAULT_STATUS;
	// 	//file_put_contents("formlog.log", print_r( $_POST, true ));
 //    	$db->insertOperation('igp_unloading',$igpUnloadingFormArray);
 //    	updateIGPStatusSACPARTable();
 //    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
 //    	// $db->insertOperation('par_log',$parlogarray);
 //    	return array("status"=>"Success","message"=>"Inward gate pass generated successfully.");
	// }

	function generateIGP(){
		global $dbc; 
		$dataType = mysqli_real_escape_string($dbc, trim($_POST['select_by_type']));
		$dataValue = mysqli_real_escape_string($dbc, trim($_POST['data_item']));
		$vehicleNumber = mysqli_real_escape_string($dbc, trim($_POST['vehicle_number']));
		$driverName = mysqli_real_escape_string($dbc, trim($_POST['driver_name']));
		$drivingLicense = mysqli_real_escape_string($dbc, trim($_POST['driving_license']));
		// $sealNumber = mysqli_real_escape_string($dbc, trim($_POST['seal_number']));
		$timeIn = mysqli_real_escape_string($dbc, trim($_POST['in_time']));
		$containerCondition = mysqli_real_escape_string($dbc, trim($_POST['container_condition']));
		$vehicleType = mysqli_real_escape_string($dbc, trim($_POST['vehicle_type']));
		$transporterName = mysqli_real_escape_string($dbc, trim($_POST['transporter_name']));
		$entryDate = mysqli_real_escape_string($dbc, trim($_POST['entry_date']));
		$parId = mysqli_real_escape_string($dbc, trim($_POST['par_id']));

		switch($vehicleType){
			case 'Break Bulk':
			case 'LCL': 
				$numTonnage = mysqli_real_escape_string($dbc, trim($_POST['num_tonnage']));
				$query = "INSERT INTO general_igp_unloading (data_type, data_value, vehicle_number, driver_name, driving_license, time_in, container_condition, vehicle_type, transporter_name, entry_date, par_id, num_tonnage, created_date) VALUES ('$dataType', '$dataValue', '$vehicleNumber', '$driverName', '$drivingLicense', '$timeIn', '$containerCondition', '$vehicleType', '$transporterName', '$entryDate', '$parId', '$numTonnage', '". date("Y-m-d") ."')";

    		// file_put_contents("formlog.log", print_r( $query, true ));
			break;
			case '20':
			case '40':
			case 'ODC':
				$containerNumberData = mysqli_real_escape_string($dbc, trim($_POST['container_number']));

				//split container number data
				$containerNumberData = explode('_', $containerNumberData);
				$containerDimension = $containerNumberData[0];
				$containerNumberKey = $containerNumberData[1];
				$containerNumber = $containerNumberData[2];

				$query = "INSERT INTO general_igp_unloading (data_type, data_value, vehicle_number, driver_name, driving_license, time_in, container_condition, vehicle_type, transporter_name, entry_date, par_id, container_number) VALUES ('$dataType', '$dataValue', '$vehicleNumber', '$driverName', '$drivingLicense', '$timeIn', '$containerCondition', '$vehicleType', '$transporterName', '$entryDate', '$parId', '$containerNumber')";
    		//file_put_contents("formlog.log", print_r( $query, true ));
			break;
		}

		if(mysqli_query($dbc, $query)){
			$lastInsertIGPId = mysqli_insert_id($dbc);
			if($vehicleType != 'Break Bulk' && $vehicleType != 'LCL'){
				$updatedContainerStatusJSON = getUpdatedContainerStatus($parId, $containerNumberData, $lastInsertIGPId);
				$containerUpdateQuery = "UPDATE par_container_info SET container_details='$updatedContainerStatusJSON' WHERE dimension='$containerDimension' AND id='$parId'";
			} else {
				$containerUpdateQuery = 'SELECT 0';
			}
			
			if(mysqli_query($dbc, $containerUpdateQuery)){
				changeParStatusOnIgpCreate($parId);
				return array("status"=>"Success","message"=>"Inward gate pass generated successfully.");
			} else {
				return array("status"=>"Failure","message"=>"Inward gate pass not generated successfully.");
			}
		}

	}

	function changeParStatusOnIgpCreate($parId){
		global $dbc;
		$query = "UPDATE pre_arrival_request SET igp_created='yes' WHERE par_id='$parId'";
		mysqli_query($dbc, $query);
	}

	function getUpdatedContainerStatus($parId, $containerNumberData, $lastInsertIGPId){
		global $dbc;
		$containerDimension = $containerNumberData[0];
		$containerNumberKey = $containerNumberData[1];
		$query = "SELECT * FROM par_container_info WHERE id='$parId' AND dimension='$containerDimension'";
		$result = mysqli_query($dbc, $query);
		$containerJSON = '';
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			
			//update container status
			$containerDetails = (array)json_decode($row['container_details']);
			$keyCount = 0;
			foreach ($containerDetails as $value) {
				if($containerNumberKey == $keyCount){
					$value->status = 'picked';
					$value->igp_id = $lastInsertIGPId;
				}
				$keyCount++;
			}
			$containerJSON = json_encode($containerDetails, JSON_FORCE_OBJECT);
			//file_put_contents("formlog.log", print_r($containerJSON, true ));
		}
		return $containerJSON;
	}

	function setVehicleLeftTimeStamp(){
		global $dbc;
		$ogpId = $_POST['ogp_un_id'];
		$query = "UPDATE general_ogp_unloading SET exit_time=now(), status='".OGP_COMPLETE_STATUS."' WHERE ogp_un_id='$ogpId'";
		if(mysqli_query($dbc, $query)){
			$output = array("infocode"=>"success","message"=>"Out gate-pass completed.");
		} else {
			$output = array("infocode"=>"failure","message"=>"Out gate-pass not completed.");
		}
		return $output;
	}

?>