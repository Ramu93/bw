<?php 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');
	require('../dbconfig_delete_entries.php');

	define('SAC_DEFAULT_STATUS','submitted');
	define('ADDED_FROM', 'sac');
	define('DEFAULT_IGP_STATUS', 'notgenerated');

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
	    case 'create_sac_req':
	        $finaloutput = createSACRequest();
	    break;
	    case 'sac_status_change':
	    	$finaloutput = SACRequestStatusChange();
	    break;
	    case 'update_sac_req':
	    $finaloutput = updateSACRequest();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	// function getLastSACRequestID(){
	// 	global $dbc;
	// 	$sacID = "";
	// 	$query = "SELECT sac_id FROM sac_request ORDER BY created_date DESC LIMIT 1";
	// 	$result = mysqli_query($dbc,$query);
	// 	if(mysqli_num_rows($result) > 0) {
	// 		$row = mysqli_fetch_assoc($result);
	// 		$sacID = $row['sac_id'];
	// 	}
	// 	return $sacID;
	// }

	function createSACRequest(){
		global $db,$form;
		$containerData = $_POST['containerdata'];
		$sacFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","licence_code"=>"licence_code","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date","insurance_by"=>"insurance_by",);
		$sacFormElementsArray = $form->getFormValues($sacFormElementsArray,$_POST);	
		$sacFormElementsArray['status'] = SAC_DEFAULT_STATUS;
		file_put_contents("formlog.log", print_r( $sacFormElementsArray, true ));
    	$db->insertOperation('sac_request',$sacFormElementsArray);

    	// $saclogarray = array("sac_id" => $sacId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    	// $db->insertOperation('sac_log',$saclogarray);

    	$lastInsertSACId = 1; //change the last insert id using the PDO's method
    	addContainers($containerData, $lastInsertSACId);
    	return array("status"=>"Success","message"=>"Space Availability Certificate request created successfully.");
	}

	function addContainers($containerData, $lastInsertPARId){
		global $dbc,$form;
		//cotainerData is of JSON type
		$containerDataObj = json_decode($containerData);
		//file_put_contents("formlog.log", print_r( $containerData, true ), FILE_APPEND | LOCK_EX);
		
		//convert stdClass object to array
		$containerData = array();
		$containerData = json_decode(json_encode($containerDataObj), True);
		//file_put_contents("formlog.log", print_r( json_encode($containerData), true ), FILE_APPEND | LOCK_EX);
		
		for($i = 0; $i < count($containerData); $i++){
			$containerJSON = array();
			$dimension = $containerData[$i]['dimension'];
			$containerCount = $containerData[$i]['container_count'];
			$containerDetails = json_encode($containerData[$i]['container_detail'], JSON_FORCE_OBJECT);
			$addContainerQuery = "INSERT INTO sac_par_container_info (id, added_from, igp_status, container_details, dimension, container_count) VALUES ('$lastInsertPARId', '".ADDED_FROM."', '".DEFAULT_IGP_STATUS."','$containerDetails', '$dimension', '$containerCount')";
			mysqli_query($dbc, $addContainerQuery);

			file_put_contents("formlog.log", print_r( $addContainerQuery, true ), FILE_APPEND | LOCK_EX);	
			//file_put_contents("formlog.log", print_r( $containerDetails, true ));
		}
	}

	function deleteContainerItems($sacID){
		global $dbc;
		$query = "DELETE FROM sac_par_container_info WHERE id='$sacID' AND added_from='" . ADDED_FROM . "'";
		mysqli_query($dbc,$query);
	}

	function updateSACRequest(){
		global $db,$form;
		$sac_id = $_POST['sac_id'];
		$sacFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","licence_code"=>"licence_code","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date","insurance_by"=>"insurance_by",);
		$sacFormElementsArray = $form->getFormValues($sacFormElementsArray,$_POST);
		$wherearray = array('condition'=>'sac_id = :sac_id', 'param'=>':sac_id', 'value'=>$sac_id);
	    $db->updateOperation('sac_request',$sacFormElementsArray,$wherearray);
	    
	    return array("status"=>"Success","message"=>"Space Availability Certificate request updated successfully.");
	}

	function SACRequestStatusChange(){
		global $db,$form;
		$sac_id = $_POST['sac_id'];
	    $sac_status = $_POST['status'];
	    $wherearray = array('condition'=>'sac_id = :sac_id', 'param'=>':sac_id', 'value'=>$sac_id);
	    $db->updateOperation('sac_request',array('status'=>$sac_status),$wherearray);
	    
	    $saclogarray = array("sac_id" => $sac_id, "status_from" => "Submitted", "status_to" => ucfirst($sac_status), "remarks" => "SAC ".ucfirst($sac_status));
	    $db->insertOperation('sac_log',$saclogarray);
	    
	    return array("status"=>"Success","message"=>"Space Availability Certificate request " . $sac_status . ".");
	}

?>