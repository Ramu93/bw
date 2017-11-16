<?php
	require('../dbconfig.php'); 
	//require('../dbconfig_pdo.php'); 
	require('../dbwrapper_mysqli.php');
	require('../formwrapper.php');

	define('GRN_CREATED_STATUS','grn_created');

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
	    case 'get_joborder_list':
	        $finaloutput = getJobOrderList();
	    break;
	    case 'get_selected_data_details':
	    	$finaloutput = getSelectedDataDetails();
	    break;
	    case 'create_grn':
	    	$finaloutput = createGRN();
	    break;
	    case 'check_grn_exists':
	    	$finaloutput = checkIfGRNExists();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function createGRN(){
		global $db, $form, $dbc;
		$parId = $_POST['par_id'];

		$grnFormArray = array("par_id"=>"par_id", "ju_id"=>"ju_id", "no_of_units"=>"no_of_units", "unit"=>"unit", "location"=>"location", "validity"=>"validity");
		$grnFormArray = $form->getFormValues($grnFormArray,$_POST);
		$grnFormArray['created_date'] = date("Y-m-d");
		//file_put_contents("formlog.log", print_r( $_POST, true ));
    	$result = $db->insertOperation('general_good_receipt_note',$grnFormArray);
    	$juId = $grnFormArray['ju_id'];
    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('par_log',$parlogarray);

    	//$updateSacParStatusQuery = "UPDATE pre_arrival_request SET status='" . GRN_CREATED_STATUS . "' WHERE par_id = '$parId'";
		// file_put_contents("formlog.log", print_r( $updateSacParStatusQuery, true ));
    	if($result['status'] == 'success'){
    		$lastInsertGRNId = $result['last_insert_id'];
    		addIGPIdToJobOrder($lastInsertGRNId, $juId);
    		return array("status"=>"success","message"=>"GRN created successfully.", "last_id" => $lastInsertGRNId);
    	} else {
    		return array("status"=>"failure","message"=>"GRN not created successfully.");
    	}
    	//mysqli_query($dbc, $updateSacParStatusQuery);
	}

	function addIGPIdToJobOrder($lastInsertGRNId, $juId){
		global $dbc;
		$query = 'UPDATE general_joborder_unloading SET grn_id="'.$lastInsertGRNId.'", grn_created="yes" WHERE ju_id="'.$juId.'"';
		mysqli_query($dbc, $query);
	}

	function getJobOrderList(){
		global $dbc;
		$query = "SELECT ju_id FROM general_joborder_unloading";
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
		$dataValue = $_POST['data_value'];

		$query = "SELECT par_id, end_time FROM general_joborder_unloading WHERE ju_id='$dataValue'";
		$output = array();
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$parId = $row['par_id'];
			$innerQuery = "SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name, bol_awb_number, boe_number, material_name, material_nature, packing_nature FROM pre_arrival_request WHERE par_id='$parId'";
			$innerResult = mysqli_query($dbc,$innerQuery);
			if(mysqli_num_rows($innerResult) > 0){
				$innerRow = mysqli_fetch_assoc($innerResult);
				$innerRow['end_time'] = date("d-m-Y g:i A", strtotime($row['end_time']));;
				$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
			}
			
		}
		 // file_put_contents("datalog.log", print_r($query, true ));
		return $output;
	}

	function checkIfGRNExists(){
		global $dbc;
		$juId = $_POST['ju_id'];
		$query = 'SELECT * FROM general_joborder_unloading WHERE ju_id="'.$juId.'"';
		$result = mysqli_query($dbc, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			if($row['grn_created'] == 'yes'){
				return array('infocode' => 'EXISTS');
			} else {
				return array('infocode' => 'NOTEXISTS');
			}
		}
	}
?>