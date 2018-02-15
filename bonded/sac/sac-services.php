<?php 
	require('../dbconfig.php'); 
	//require('../dbwrapper.php');
	require('../formwrapper.php');
	//require('../dbconfig_delete_entries.php');
	require('licence-code-map.php');
	require('../dbwrapper_mysqli.php');

	define('SAC_DEFAULT_STATUS','submitted');
	define('ADDED_FROM', 'sac');
	define('DEFAULT_IGP_STATUS', 'notgenerated');

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
	    case 'create_sac_req':
	        $finaloutput = createSACRequest();
	    break;
	    case 'sac_status_change':
	    	$finaloutput = SACRequestStatusChange();
	    break;
	    case 'update_sac_req':
	    	$finaloutput = updateSACRequest();
	    break;
	    case 'get_licence_data':
	    	$finaloutput = getLicenceCodeData();
	    break;
	    case 'check_if_boe_exists':
	    	$finaloutput = checkBoeNumExists();
	    	break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function createSACRequest(){
		global $db,$form;
		$containerData = $_POST['containerdata'];
		$sacFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","licence_code"=>"licence_code","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date", "bol_awb_date"=>"bol_awb_date", "boe_date"=>"boe_date", "cha_name"=>"cha_name");
		$sacFormElementsArray = $form->getFormValues($sacFormElementsArray,$_POST);	
		$sacFormElementsArray['status'] = SAC_DEFAULT_STATUS;
		$sacFormElementsArray['created_date'] = date("Y-m-d");
		// file_put_contents("formlog.log", print_r( $sacFormElementsArray, true ));
    	$result = $db->insertOperation('sac_request',$sacFormElementsArray);
 		if($result['status'] == 'success'){
 			$lastInsertSACId = $result['last_insert_id']; 
    		addContainers($containerData, $lastInsertSACId);
    		$saclogarray = array("sac_id" => $lastInsertSACId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    		$db->insertOperation('sac_log',$saclogarray);
    		return array("status"=>"Success","message"=>"Space Availability Certificate request created successfully.");
 		} else {
 			return array("status"=>"failure","message"=>"Space Availability Certificate request not created.");
 		}

    	
	}

	function addContainers($containerData, $lastInsertSacId){
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

			switch($dimension){
				case 'Break Bulk':
				case 'LCL': 
					$tonnage = $containerData[$i]['tonnage'];
					$addContainerQuery = "INSERT INTO sac_container_info (id, igp_status, tonnage, dimension, has_containers) VALUES ('$lastInsertSacId', '".DEFAULT_IGP_STATUS."', '$tonnage', '$dimension', 'no')";

				break;
				case '20 ft. Container':
				case '40 ft. Container':
				case 'ODC':
					$containerCount = $containerData[$i]['container_count'];
					$containerDetails = json_encode($containerData[$i]['container_detail'], JSON_FORCE_OBJECT);
					$addContainerQuery = "INSERT INTO sac_container_info (id, igp_status, container_details, dimension, container_count, has_containers) VALUES ('$lastInsertSacId', '".DEFAULT_IGP_STATUS."','$containerDetails', '$dimension', '$containerCount', 'yes')";
				break;
			}

			mysqli_query($dbc, $addContainerQuery);

			//file_put_contents("formlog.log", print_r( $addContainerQuery, true ), FILE_APPEND | LOCK_EX);	
			//file_put_contents("formlog.log", print_r( $containerDetails, true ));
		}
	}

	function deleteContainerItems($sacID){
		global $dbc;
		$query = "DELETE FROM sac_par_container_info WHERE id='$sacID' AND added_from='" . ADDED_FROM . "'";
		mysqli_query($dbc,$query);
	}

	function updateSACRequest(){
		global $dbc;
		$sacId = $_POST['sac_id'];
		$importingFirmName = mysqli_real_escape_string($dbc, trim($_POST['importing_firm_name']));
		$bolAwbNumber = mysqli_real_escape_string($dbc, trim($_POST['bol_awb_number']));
		$materialName = mysqli_real_escape_string($dbc, trim($_POST['material_name']));
		$packingNature = mysqli_real_escape_string($dbc, trim($_POST['packing_nature']));
		$materialNature = mysqli_real_escape_string($dbc, trim($_POST['material_nature']));
		$requiredPeriod = mysqli_real_escape_string($dbc, trim($_POST['required_period']));
		$assessableValue = mysqli_real_escape_string($dbc, trim($_POST['assessable_value']));
		$licenceCode = mysqli_real_escape_string($dbc, trim($_POST['licence_code']));
		$boeNumber = mysqli_real_escape_string($dbc, trim($_POST['boe_number']));
		$qtyUnits = mysqli_real_escape_string($dbc, trim($_POST['qty_units']));
		$spaceRequirement = mysqli_real_escape_string($dbc, trim($_POST['space_requirement']));
		$dutyAmount = mysqli_real_escape_string($dbc, trim($_POST['duty_amount']));
		$expectedDate = mysqli_real_escape_string($dbc, trim($_POST['expected_date']));
		$bolAwbDate = mysqli_real_escape_string($dbc, trim($_POST['bol_awb_date']));
		$boeDate = mysqli_real_escape_string($dbc, trim($_POST['boe_date']));
		$chaName = mysqli_real_escape_string($dbc, trim($_POST['cha_name']));
		$query = "UPDATE sac_request SET importing_firm_name='$importingFirmName', bol_awb_number='$bolAwbNumber', material_name='$materialName', packing_nature='$packingNature', material_nature='$materialNature', required_period='$requiredPeriod', assessable_value='$assessableValue', licence_code='$licenceCode', boe_number='$boeNumber', qty_units='$qtyUnits', space_requirement='$spaceRequirement', duty_amount='$dutyAmount', expected_date='$expectedDate', bol_awb_date='$bolAwbDate', boe_date='$boeDate', cha_name='$chaName' WHERE sac_id='$sacId'";

		// $sacFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","licence_code"=>"licence_code","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date", "bol_awb_date"=>"bol_awb_date", "boe_date"=>"boe_date", "cha_name"=>"cha_name");
		// $sacFormElementsArray = $form->getFormValues($sacFormElementsArray,$_POST);
		// $wherearray = array('condition'=>'sac_id = :sac_id', 'param'=>':sac_id', 'value'=>$sac_id);
	 //    $db->updateOperation('sac_request',$sacFormElementsArray,$wherearray);
	    
	    if(mysqli_query($dbc, $query)){
	    	return array("status"=>"Success","message"=>"Space Availability Certificate request updated successfully.");
	    } else {
	    	return array("status"=>"failure","message"=>"Space Availability Certificate request not updated successfully.");
	    }
	}

	function SACRequestStatusChange(){
		global $db,$form;
		$sac_id = $_POST['sac_id'];
	    $sac_status = $_POST['status'];
	    //$wherearray = array('condition'=>'sac_id = :sac_id', 'param'=>':sac_id', 'value'=>$sac_id);
	    $wherearray = array('sac_id'=>$sac_id);
	    $db->updateOperation('sac_request',array('status'=>$sac_status),$wherearray);
	    
	    $saclogarray = array("sac_id" => $sac_id, "status_from" => "Submitted", "status_to" => ucfirst($sac_status), "remarks" => "SAC ".ucfirst($sac_status));
	    $db->insertOperation('sac_log',$saclogarray);
	    
	    return array("status"=>"Success","message"=>"Space Availability Certificate request " . $sac_status . ".");
	}

	function getLicenceCodeData(){
		global $licenceCodeMap;
		$licenceCode = $_POST['licence_code'];
		$licenceKey = '';
		$licenceAddress = '';
		switch ($licenceCode) {
			case 'C-068':
				$licenceKey = $licenceCodeMap['C-068']['licence_key'];
				$licenceAddress = $licenceCodeMap['C-068']['licence_address'];
			break;
			case 'C-069':
				$licenceKey = $licenceCodeMap['C-069']['licence_key'];
				$licenceAddress = $licenceCodeMap['C-069']['licence_address'];
			break;
			case 'C-085':
				$licenceKey = $licenceCodeMap['C-085']['licence_key'];
				$licenceAddress = $licenceCodeMap['C-085']['licence_address'];
			break;
		}
		// file_put_contents("licence.log", print_r( $licenceCode . ' ' . $licenceAddress, true ));

		return array("licence_key" => $licenceKey, "licence_address" => $licenceAddress);
	}

	function checkBoeNumExists(){
		global $dbc;
		$boeNum = mysqli_real_escape_string($dbc, trim($_POST['boe_num']));
		$query = "SELECT * FROM sac_request WHERE boe_number='$boeNum'";
		$result = mysqli_query($dbc, $query);
		if(mysqli_num_rows($result) > 0){
			return array('infocode' => 'BOEEXISTS');
		}
		return array('infocode' => 'BOENOTEXISTS');
	}

?>