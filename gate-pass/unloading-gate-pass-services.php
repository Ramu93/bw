<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('IGP_UNLOADING_DEFAULT_STATUS','created');
	define('IGP_CREATED_STATUS','yes');

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
				$query = "SELECT importing_firm_name as 'data_item' FROM sac_request WHERE status='approved' UNION SELECT importing_firm_name as 'data_item' FROM pre_arrival_request WHERE status='approved'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item' FROM sac_request WHERE status='approved' UNION SELECT boe_number as 'data_item' FROM pre_arrival_request WHERE status='approved'";
			break;
			case 'par':
				$query = "SELECT par_id as 'data_item' FROM pre_arrival_request WHERE status='approved'";
			break;
			case 'sac':
				$query = "SELECT sac_id as 'data_item' FROM sac_request WHERE status='approved'";
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
		$dataType = $_POST['data_type'];
		$dataValue = $_POST['data_value'];
		$query = "";
		switch ($dataType) {
			case 'customer_name':
				$query = "SELECT sac_id as 'id', 'sac' as 'table_name', importing_firm_name FROM sac_request WHERE importing_firm_name='$dataValue' AND status='approved' UNION SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name FROM pre_arrival_request WHERE importing_firm_name='$dataValue' AND status='approved'";
			break;
			case 'boe_number':
				$query = "SELECT sac_id as 'id', 'sac' as 'table_name', importing_firm_name FROM sac_request WHERE boe_number='$dataValue' AND status='approved' UNION SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name FROM pre_arrival_request WHERE boe_number='$dataValue' AND status='approved'";
			break;
			case 'par':
				$query = "SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name FROM pre_arrival_request WHERE par_id='$dataValue' AND status='approved'";
			break;
			case 'sac':
				$query = "SELECT sac_id as 'id', 'sac' as 'table_name', importing_firm_name FROM sac_request WHERE sac_id='$dataValue' AND status='approved'";
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
			$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($out));
		}
		//file_put_contents("datalog.log", print_r(json_encode($output), true ));
		return $output;
	}

	function getContainerData(){
		global $dbc;
		$sacPar = $_POST['sac_par_table'];
		$sacParID = $_POST['sac_par_id'];
		$containerRows = array();
		$query = "SELECT * FROM sac_par_container_info WHERE id='" . $sacParID . "' AND added_from= '" . $sacPar . "'";
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
		$table = $_POST['sac_par_table'];
		$id = $_POST['sac_par_id'];
		if($table == 'sac'){
			$tableName = 'sac_request';
			$idCol = 'sac_id';
		} else if($table == 'par'){
			$tableName = 'pre_arrival_request';
			$idCol = 'par_id';
		}
		$query = "UPDATE $tableName SET igp_created='" . IGP_CREATED_STATUS . "' WHERE $idCol='$id'";
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
		$sealNumber = mysqli_real_escape_string($dbc, trim($_POST['seal_number']));
		$timeIn = mysqli_real_escape_string($dbc, trim($_POST['in_time']));
		$containerCondition = mysqli_real_escape_string($dbc, trim($_POST['container_condition']));
		$vehicleType = mysqli_real_escape_string($dbc, trim($_POST['vehicle_type']));
		$transporterName = mysqli_real_escape_string($dbc, trim($_POST['transporter_name']));
		$entryDate = mysqli_real_escape_string($dbc, trim($_POST['entry_date']));
		$sacParTable = mysqli_real_escape_string($dbc, trim($_POST['sac_par_table']));
		$sacParId = mysqli_real_escape_string($dbc, trim($_POST['sac_par_id']));
		$containerNumberData = mysqli_real_escape_string($dbc, trim($_POST['container_number']));

		//split container number data
		$containerNumberData = explode('_', $containerNumberData);
		$containerDimension = $containerNumberData[0];
		$containerNumberKey = $containerNumberData[1];
		$containerNumber = $containerNumberData[2];

		$query = "INSERT INTO igp_unloading (data_type, data_value, vehicle_number, driver_name, driving_license, seal_number, time_in, container_condition, vehicle_type, transporter_name, entry_date, sac_par_table, sac_par_id, container_number) VALUES ('$dataType', '$dataValue', '$vehicleNumber', '$driverName', '$drivingLicense', '$sealNumber', '$timeIn', '$containerCondition', '$vehicleType', '$transporterName', '$entryDate', '$sacParTable', '$sacParId', '$containerNumber')";
		if(mysqli_query($dbc, $query)){
			$updatedContainerStatusJSON = getUpdatedContainerStatus($sacParTable, $sacParId, $containerNumberData);
			$containerUpdateQuery = "UPDATE sac_par_container_info SET container_details='$updatedContainerStatusJSON' WHERE dimension='$containerDimension' AND added_from='$sacParTable' AND id='$sacParId'";
			if(mysqli_query($dbc, $containerUpdateQuery)){
				return array("status"=>"Success","message"=>"Inward gate pass generated successfully.");
			} else {
				return array("status"=>"Failure","message"=>"Inward gate pass not generated successfully.");
			}
		}

	}

	function getUpdatedContainerStatus($sacParTable, $sacParId, $containerNumberData){
		global $dbc;
		$containerDimension = $containerNumberData[0];
		$containerNumberKey = $containerNumberData[1];
		$query = "SELECT * FROM sac_par_container_info WHERE added_from='$sacParTable' AND id='$sacParId' AND dimension='$containerDimension'";
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
				}
				$keyCount++;
			}
			$containerJSON = json_encode($containerDetails, JSON_FORCE_OBJECT);
			//file_put_contents("formlog.log", print_r($containerJSON, true ));
		}
		return $containerJSON;
	}

?>