<?php
	require('../dbconfig.php'); 
	//require('../dbconfig_pdo.php');
	require('../formwrapper.php');
	require('../dbwrapper_mysqli.php');

	define('RAISE_EXCEPTION_STATUS', 'exception');
	define('EXCEPTION_CLOSE_STATUS','exceptioncomplete');
	define('CLOSE_EXCEPTION_STATUS','complete');
	define('JOB_ORDER_REJECT_STATUS', 'rejected');
	define('JOB_ORDER_COMPLETE_STATUS', 'completed');
	define('IGP_JOB_ORDER_COMPLETE', 'joborder_completed');
	define('EXCEPTION_FILE_COPY_PATH', 'exception_images/');

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
	    case 'get_containers_list':
	    	$finaloutput = getContainersList();
	    break;
	    case 'get_selected_data_details':
	    	$finaloutput = getSelectedDataDetails();
	    break;
	    case 'create_job_order':
	    	$finaloutput = createJobOrder();
	    break;
	    case 'joborder_raise_exception':
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
	    case 'check_joborder_exists':
	    	$finaloutput = checkIfJobOrderExists();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function createJobOrder(){
		global $db,$form;
		$jobOrderUnloadingFormArray = array("par_id"=>"par_id", "weight"=>"weight", "no_of_packages"=>"no_of_packages", "description"=>"description", "supervisor_name"=>"supervisor_name", "unloading_type"=>"unloading_type", "equipment_ref_number"=>"equipment_ref_number", "no_of_labors"=>"no_of_labors", "unloading_time"=>"unloading_time", "dimension"=>"dimension", "igp_id"=>"igp_id");
		$jobOrderUnloadingFormArray = $form->getFormValues($jobOrderUnloadingFormArray,$_POST);
	   	$jobOrderUnloadingFormArray['start_time'] = date("Y-m-d H:i:s");
	   	$jobOrderUnloadingFormArray['igp_id'] = explode("_",$jobOrderUnloadingFormArray['igp_id'])[0];
		$jobOrderUnloadingFormArray['created_date'] = date("Y-m-d");
		//file_put_contents("formlog.log", print_r( $_POST, true ));
    	$result = $db->insertOperation('general_joborder_unloading',$jobOrderUnloadingFormArray);
    	// $parlogarray = array("par_id" => $parId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('par_log',$parlogarray);
    	if($result['status'] == 'success'){
    		return array("status"=>"Success","message"=>"Job order created successfully.", "last_id"=>$result['last_insert_id']);    	
    	} else {
    		return array("status"=>"failure","message"=>"Job order not created successfully.");
    	}
	}

	function raiseException(){
		global $db,$form, $dbc;
    	
    	$raiseExceptionFormArray = array("exception_subtype"=>"exception_subtype", "exception_remarks"=>"exception_remarks");
	   	$raiseExceptionFormArray = $form->getFormValues($raiseExceptionFormArray,$_POST);
	   	$raiseExceptionFormArray['exception_type'] = 'joborder_unloading';
	   	$raiseExceptionFormArray['start_time'] = date("Y-m-d H:i:s");

	   	if(isset($_FILES['exception_file']['name'])){
    		$exceptionFname = $_POST['ju_id'].'_'.date("Y-m-d H:i:s").'_'.$_FILES['exception_file']['name'];
    		$exceptionFileCopyPath = EXCEPTION_FILE_COPY_PATH.$exceptionFname;
    		$raiseExceptionFormArray['image'] = $exceptionFileCopyPath;
    		if(!move_uploaded_file($_FILES['exception_file']['tmp_name'],$exceptionFileCopyPath)){
    			$output = array("infocode" => "FILEUPLOADERR", "message" => "Unable to upload image, please try again!");
    		}
    	}

	   	
	    $result = $db->insertOperation('general_exception',$raiseExceptionFormArray);

	    if($result['status'] == 'success'){
	    	$lastInsertExceptionId = $result['last_insert_id'];
	    	
	    	$query = "UPDATE general_joborder_unloading SET status='".RAISE_EXCEPTION_STATUS."', exception_id='$lastInsertExceptionId' WHERE ju_id='".$_POST['ju_id']."'";
	    	if(mysqli_query($dbc, $query)){
	    		return array("infocode"=>"RAISEEXCEPTIONSUCCESS","message"=>"Exception raised successfully");	
	    	}
	    }

	    // $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$_POST['ju_id']);
	    // //change to last inser id for exception id
	    // $db->updateOperation('general_joborder_unloading',array('status'=>RAISE_EXCEPTION_STATUS, 'exception_id'=>'1'),$wherearray);

	    //return array("infocode"=>"RAISEEXCEPTIONSUCCESS","message"=>"Exception raised successfully");
	}

	function closeException(){
		global $dbc;
		$exceptionId = $_POST['exception_id'];
		$exceptionClosingRemarks = $_POST['exception_closingremarks'];
		// $wherearray = array('condition'=>'exception_id = :exception_id', 'param'=>':exception_id', 'value'=>$exceptionId);
	    // $db->updateOperation('general_exception',array('exception_closingremarks'=>$exceptionClosingRemarks, 'exception_status'=>CLOSE_EXCEPTION_STATUS, 'end_time'=>date("Y-m-d H:i:s")),$wherearray);

	    // $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$_POST['ju_id']);
	    // $db->updateOperation('general_joborder_unloading',array('status'=>EXCEPTION_CLOSE_STATUS),$wherearray);

	    // return array("infocode"=>"CLOSEEXCEPTIONSUCCESS","message"=>"Exception closed successfully");
	    $query = "UPDATE general_exception SET exception_closingremarks='$exceptionClosingRemarks', exception_status='".CLOSE_EXCEPTION_STATUS."', end_time='".date("Y-m-d H:i:s")."' WHERE exception_id='$exceptionId'";
		if(mysqli_query($dbc, $query)){
			$query = "UPDATE general_joborder_unloading SET status='".EXCEPTION_CLOSE_STATUS."' WHERE ju_id='".$_POST['ju_id']."'";
	    	if(mysqli_query($dbc, $query)){
	    		return array("infocode"=>"CLOSEEXCEPTIONSUCCESS","message"=>"Exception closed successfully");	
	    	} else {
	    		return array("infocode"=>"CLOSEEXCEPTIONFAILURE","message"=>"Exception closing FAILURE");
	    	}
		}
	}

	function rejectJobOrder() {
	    global $dbc;
	    
	    $juId = $_POST['ju_id'];
	    //TODO add exception type in where
	    // $wherearray = array('condition'=>'par_uuid = :par_uuid', 'param'=>':par_uuid', 'value'=>$par_uuid);
	    // $db->updateOperation('pre_arrival_request',array('par_status'=>'joborder_unloading_rejected'),$wherearray);

	    // $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$juId);
	    // $db->updateOperation('general_joborder_unloading',array('status'=>JOB_ORDER_REJECT_STATUS),$wherearray);


	    $query = "UPDATE general_joborder_unloading SET status='".JOB_ORDER_REJECT_STATUS."' WHERE ju_id='$juId'";
	    if(mysqli_query($dbc, $query)){
	    	return array("infocode"=>"JOBORDERREJECTED","message"=>"Job Order has been rejected");
	    } else {
	    	return array("infocode"=>"JOBORDERNOTREJECTED","message"=>"Job Order has not been rejected");
	    }
	}

	function completeJobOrder(){
		global $dbc;
		$juId = $_POST['ju_id'];

		// $wherearray = array('condition'=>'par_uuid = :par_uuid', 'param'=>':par_uuid', 'value'=>$par_uuid);
  		//$db->updateOperation('pre_arrival_request',array('par_status'=>'joborder_completed'),$wherearray);

  		// $wherearray = array('condition'=>'ju_id = :ju_id', 'param'=>':ju_id', 'value'=>$juId);
	   //  $db->updateOperation('general_joborder_unloading',array('status'=>JOB_ORDER_COMPLETE_STATUS),$wherearray);


	    $query = "UPDATE general_joborder_unloading SET status='".JOB_ORDER_COMPLETE_STATUS."', end_time='".date("Y-m-d H:i:s")."' WHERE ju_id='$juId'";
	    if(mysqli_query($dbc, $query)){
	    	//add OGP table entry
		    addOGPEntry($juId);
		    //change the status of IGP - unloading to joborder_complete
		    changeIGPStatus($juId);

		    return array("infocode"=>"JOBORDERCOMPLETED","message"=>"Job Order completed successfully");
	    } else {
	    	return array("infocode"=>"JOBORDERNOTCOMPLETED","message"=>"Job Order not completed successfully");
	    }
	}

	function addOGPEntry($juId){
		global $dbc;
		$query = "INSERT INTO general_ogp_unloading (ju_id, created_date) VALUES ($juId, '".date("Y-m-d")."')";
		mysqli_query($dbc, $query);
	}

	function changeIGPStatus($juId){
		global $dbc;
		$parDetails = getparDetails($juId);
		$parId = $parDetails['par_id'];
		$query = "UPDATE general_igp_unloading SET status='".IGP_JOB_ORDER_COMPLETE."' WHERE par_id='$parId'";
		mysqli_query($dbc, $query);
	}

	function getparDetails($juId){
		global $dbc;
		$query = "SELECT par_id FROM general_joborder_unloading WHERE ju_id='$juId'";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$out = $row;
		}
		return $out;
	}

	function getDataList(){
		global $dbc;
		$dataType = $_POST['data_type'];
		$query = "";
		switch ($dataType) {
			case 'customer_name':
				$query = "SELECT importing_firm_name as 'data_item', par_id FROM pre_arrival_request WHERE status='approved' AND document_verified='yes' AND igp_created='yes'";
			break;
			case 'boe_number':
				$query = "SELECT boe_number as 'data_item', par_id FROM pre_arrival_request WHERE status='approved' AND document_verified='yes' AND igp_created='yes'";
			break;
			case 'par':
				$query = "SELECT par_id as 'data_item', par_id FROM pre_arrival_request WHERE status='approved' AND document_verified='yes' AND igp_created='yes'";
			break;
			case 'igp':
				$query = "SELECT igpun.igp_un_id as 'data_item', par.par_id FROM general_igp_unloading igpun, pre_arrival_request par WHERE igpun.par_id=par.par_id";
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

	function getContainersList(){
		global $dbc;
		$parId = $_POST['par_id'];
		$query = "SELECT * FROM par_container_info WHERE id='" . $parId . "' AND has_containers='yes'";
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

	function checkIfJobOrderExists(){
		global $dbc;
		$igpId = $_POST['igp_id'];
		$query = 'SELECT * FROM general_joborder_unloading WHERE igp_id="'.$igpId.'"';
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0){
			return array("infocode" => "EXISTS");
		} else {
			return array("infocode" => "NOTEXISTS");
		}
	}
?>