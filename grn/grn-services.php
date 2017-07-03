<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

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
		global $db,$form;
		$grnFormArray = array("sac_par_table"=>"sac_par_table", "sac_par_id"=>"sac_par_id", "ju_id"=>"ju_id", "space_occupied"=>"space_occupied", "location"=>"location", "validity"=>"validity");
		$grnFormArray = $form->getFormValues($grnFormArray,$_POST);
		//file_put_contents("formlog.log", print_r( $_POST, true ));
    	$db->insertOperation('good_receipt_note',$grnFormArray);
    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('par_log',$parlogarray);
    	return array("status"=>"success","message"=>"GRN created successfully.");
	}

	function getJobOrderList(){
		global $dbc;
		$query = "SELECT ju_id FROM joborder_unloading";
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

		$query = "SELECT sac_par_table, sac_par_id FROM joborder_unloading WHERE ju_id='$dataValue'";
		$output = array();
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			if($row['sac_par_table'] == 'sac'){
				$table = 'sac';
				$tableName = 'sac_request';
				$colName = 'sac_id';
			} else {
				$table = 'par';
				$tableName = 'pre_arival_request';
				$colName = 'par_id';
			}
			$sacParId = $row['sac_par_id'];
			$innerQuery = "SELECT $colName as 'id', '$table' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number, material_name, material_nature, packing_nature FROM $tableName WHERE $colName='$sacParId'";
			$innerResult = mysqli_query($dbc,$innerQuery);
			if(mysqli_num_rows($innerResult) > 0){
				$innerRow = mysqli_fetch_assoc($innerResult);
				$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
			}
			
		}
		file_put_contents("datalog.log", print_r(json_encode($output), true ));
		return $output;
	}
?>