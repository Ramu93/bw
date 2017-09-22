<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('GRN_CREATED_STATUS','grn_created');

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
	    case 'get_joborder_list':
	        $finaloutput = getJobOrderList();
	    break;
	    case 'get_selected_data_details':
	    	$finaloutput = getSelectedDataDetails();
	    break;
	    case 'create_grn':
	    	$finaloutput = createGRN();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function createGRN(){
		global $db, $form, $dbc;
		$sacId = $_POST['sac_id'];

		$grnFormArray = array("sac_id"=>"sac_id", "ju_id"=>"ju_id", "no_of_units"=>"no_of_units", "unit"=>"unit", "location"=>"location", "validity"=>"validity");
		$grnFormArray = $form->getFormValues($grnFormArray,$_POST);
		//file_put_contents("formlog.log", print_r( $_POST, true ));
    	$db->insertOperation('bonded_good_receipt_note',$grnFormArray);
    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('par_log',$parlogarray);

    	//$updateSacParStatusQuery = "UPDATE sac_request SET status='" . GRN_CREATED_STATUS . "' WHERE sac_id = '$sacId'";
		// file_put_contents("formlog.log", print_r( $updateSacParStatusQuery, true ));

    	//mysqli_query($dbc, $updateSacParStatusQuery);
    	return array("status"=>"success","message"=>"GRN created successfully.");
	}

	function getJobOrderList(){
		global $dbc;
		$query = "SELECT ju_id FROM bonded_joborder_unloading";
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

		$query = "SELECT sac_id, end_time FROM bonded_joborder_unloading WHERE ju_id='$dataValue'";
		$output = array();
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$sacId = $row['sac_id'];
			$innerQuery = "SELECT sac.sac_id as 'id', 'sac' as 'table_name', sac.importing_firm_name, sac.licence_code, sac.bol_awb_number, sac.boe_number, sac.material_name, sac.material_nature, sac.packing_nature, dvin.bond_number FROM sac_request sac, bonded_dv_inward dvin WHERE sac.sac_id='$sacId'";
			$innerResult = mysqli_query($dbc,$innerQuery);
			if(mysqli_num_rows($innerResult) > 0){
				$innerRow = mysqli_fetch_assoc($innerResult);
				$innerRow['end_time'] = date("d-m-Y g:i A", strtotime($row['end_time']));
				$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
			}
			
		}
		// file_put_contents("datalog.log", print_r($innerQuery, true ));
		return $output;
	}
?>