<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	define('RAISE_EXCEPTION_STATUS', 'exception');
	define('EXCEPTION_CLOSE_STATUS','exceptioncomplete');
	define('CLOSE_EXCEPTION_STATUS','complete');
	define('JOB_ORDER_REJECT_STATUS', 'rejected');
	define('JOB_ORDER_COMPLETE_STATUS', 'completed');

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
	    case 'create_job_order':
	    	$finaloutput = createJobOrder();
	    break;
	    case 'raise_exception':
	    	$finaloutput = raiseException();
	    break;
	    case 'close_exception':
	    	$finaloutput = closeException();
	    break;
	    case 'reject_joborder':
	    	$finaloutput = rejectJobOrder();
	    break;
	    case 'complete_joborder':
	    	$finaloutput = completeJobOrder();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function createJobOrder(){
		global $db,$form;
		$jobOrderUnloadingFormArray = array("sac_par_table"=>"sac_par_table", "sac_par_id"=>"sac_par_id", "weight"=>"weight", "no_of_packages"=>"no_of_packages", "description"=>"description", "supervisor_name"=>"supervisor_name", "unloading_type"=>"unloading_type", "equipment_ref_number"=>"equipment_ref_number", "no_of_labors"=>"no_of_labors", "unloading_time"=>"unloading_time", "dimension"=>"dimension");
		$jobOrderUnloadingFormArray = $form->getFormValues($jobOrderUnloadingFormArray,$_POST);
		//file_put_contents("formlog.log", print_r( $_POST, true ));
    	$db->insertOperation('joborder_unloading',$jobOrderUnloadingFormArray);
    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('par_log',$parlogarray);
    	return array("status"=>"Success","message"=>"Job order created successfully.");
	}

	function raiseException(){
		global $db,$form;
    	
    	$raiseExceptionFormArray = array("exception_subtype"=>"exception_subtype", "exception_remarks"=>"exception_remarks");
	   	$raiseExceptionFormArray = $form->getFormValues($raiseExceptionFormArray,$_POST);
	   	$raiseExceptionFormArray['exception_type'] = 'joborder_unloading';
	    $db->insertOperation('exception',$raiseExceptionFormArray);

	    $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$_POST['ju_id']);
	    //change to last inser id for exception id
	    $db->updateOperation('joborder_unloading',array('status'=>RAISE_EXCEPTION_STATUS, 'exception_id'=>'1'),$wherearray);

	    return array("infocode"=>"RAISEEXCEPTIONSUCCESS","message"=>"Exception raised successfully");
	}

	function closeException(){
		global $db;
		$exceptionId = $_POST['exception_id'];
		$exceptionClosingRemarks = $_POST['exception_closingremarks'];
		$wherearray = array('condition'=>'exception_id = :exception_id', 'param'=>':exception_id', 'value'=>$exceptionId);
	    $db->updateOperation('exception',array('exception_closingremarks'=>$exceptionClosingRemarks, 'exception_status'=>CLOSE_EXCEPTION_STATUS),$wherearray);

	    $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$_POST['ju_id']);
	    $db->updateOperation('joborder_unloading',array('status'=>EXCEPTION_CLOSE_STATUS),$wherearray);

	    return array("infocode"=>"CLOSEEXCEPTIONSUCCESS","message"=>"Exception closed successfully");
	}

	function rejectJobOrder() {
	    global $db,$form;
	    
	    $juId = $_POST['ju_id'];
	    //TODO add exception type in where
	    // $wherearray = array('condition'=>'par_uuid = :par_uuid', 'param'=>':par_uuid', 'value'=>$par_uuid);
	    // $db->updateOperation('pre_arrival_request',array('par_status'=>'joborder_unloading_rejected'),$wherearray);

	    $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$juId);
	    $db->updateOperation('joborder_unloading',array('status'=>JOB_ORDER_REJECT_STATUS),$wherearray);


	    return array("infocode"=>"JOBORDERREJECTED","message"=>"Job Order has been rejected");
	}

	function completeJobOrder(){
		global $db,$form;
		$juId = $_POST['ju_id'];

		// $wherearray = array('condition'=>'par_uuid = :par_uuid', 'param'=>':par_uuid', 'value'=>$par_uuid);
  		//$db->updateOperation('pre_arrival_request',array('par_status'=>'joborder_completed'),$wherearray);

  		$wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$juId);
	    $db->updateOperation('joborder_unloading',array('status'=>JOB_ORDER_COMPLETE_STATUS),$wherearray);

	    return array("infocode"=>"JOBORDERCOMPLETED","message"=>"Job Order completed successfully");
	}

	function getDataList(){
		global $dbc;
		$dataType = $_POST['data_type'];
		$query = "";
		switch ($dataType) {
			case 'customer_name':
				$query = "SELECT importing_firm_name as 'data_item' FROM sac_request WHERE status='approved'AND document_verified='yes' UNION SELECT importing_firm_name as 'data_item' FROM pre_arrival_request WHERE status='approved' AND document_verified='yes'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item' FROM sac_request WHERE status='approved' AND document_verified='yes' UNION SELECT boe_number as 'data_item' FROM pre_arrival_request WHERE status='approved' AND document_verified='yes'";
			break;
			case 'par':
				$query = "SELECT par_id as 'data_item' FROM pre_arrival_request WHERE status='approved' AND document_verified='yes'";
			break;
			case 'sac':
				$query = "SELECT sac_id as 'data_item' FROM sac_request WHERE status='approved' AND document_verified='yes'";
			break;
			case 'igp':
				$query = "SELECT igp_un_id as 'data_item' FROM igp_unloading";
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
			case 'igp':
				$query = "SELECT sac_par_id as 'id', sac_par_table as 'table_name' FROM igp_unloading WHERE igp_un_id='$dataValue'";
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
		file_put_contents("datalog.log", print_r(json_encode($output), true ));
		return $output;
	}
?>