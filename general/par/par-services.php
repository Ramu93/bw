<?php 
	require('../dbconfig_pdo.php');
	require('../formwrapper.php');
	require('../dbconfig_delete_entries.php');
	require('../dbwrapper_mysqli.php');

	define('PAR_DEFAULT_STATUS','submitted');
	define('CLIENT_INSURANCE_COPY_PATH', 'client-insurance-copy/');
	define('INSURANCE_DECLARATION_COPY_PATH', 'insurance_declaration_copy/');
	define('ADDED_FROM', 'par');
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
	    case 'create_par':
	        $finaloutput = createPAR();
	    break;
	    case 'par_status_change':
	    	$finaloutput = PARStatusChange();
	    break;
	    case 'update_par':
	    	$finaloutput = updatePAR();
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

	function createPAR(){
		global $db,$form;
		$containerData = $_POST['container_stringified'];
		$parFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","cha_name"=>"cha_name","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date", "insurance_declaration"=>"insurance_declaration", "cargo_life"=>"cargo_life", "shelf_life"=>"shelf_life", "bol_awb_date"=>"bol_awb_date", "boe_date"=>"boe_date", "insurance_by"=>"insurance_by");
		$parFormElementsArray = $form->getFormValues($parFormElementsArray,$_POST);	
		$parFormElementsArray['status'] = PAR_DEFAULT_STATUS;	
		//file_put_contents("formlog.log", print_r( $parFormElementsArray, true ));
		//file_put_contents("formlog.log", print_r( $containerData, true ));
		if(isset($_FILES['client_insurance_file']['name'])){
    		$clientInsuranceFname = $_POST['importing_firm_name'].'_client_insurance_copy_'.$_FILES['client_insurance_file']['name'];
    		$clientInsuranceCopyPath = CLIENT_INSURANCE_COPY_PATH.$clientInsuranceFname;
    		$parFormElementsArray['client_insurance_copy'] = $clientInsuranceCopyPath;
    		if(!move_uploaded_file($_FILES['client_insurance_file']['tmp_name'],$clientInsuranceCopyPath)){
    			$output = array("infocode" => "FILEUPLOADERR", "message" => "Unable to upload Clinet insurance file copy, please try again!");
    		}
    	}

    	if(isset($_FILES['insurance_declaration_file']['name'])){
    		$insuranceDeclarationFname = $_POST['importing_firm_name'].'_insurance_declaration_copy_'.$_FILES['insurance_declaration_file']['name'];
    		$insuranceDeclarationCopyPath = INSURANCE_DECLARATION_COPY_PATH.$insuranceDeclarationFname;
    		$parFormElementsArray['insurance_declaration_copy'] = $insuranceDeclarationCopyPath;
    		if(!move_uploaded_file($_FILES['insurance_declaration_file']['tmp_name'],$insuranceDeclarationCopyPath)){
    			$output = array("infocode" => "FILEUPLOADERR", "message" => "Unable to upload insurance declaration file copy, please try again!");
    		}
    	}

    	$result = $db->insertOperation('pre_arrival_request',$parFormElementsArray);
    	if($result['status'] == 'success'){
    		$lastInsertPARId = $result['last_insert_id'];
    		addContainers($containerData, $lastInsertPARId);
    		$parlogarray = array("par_id" => $lastInsertPARId, "status_to" => 'Submitted', "remarks" => "Waiting for Approval");
    		$db->insertOperation('par_log',$parlogarray);
    		return array("status"=>"Success","message"=>"Pre Arrival Request created successfully.");
    	} else {
    		return array("status"=>"Success","message"=>"Pre Arrival Request not created successfully.");
    	}
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

			switch($dimension){
				case 'Break Bulk':
				case 'LCL': 
					$tonnage = $containerData[$i]['tonnage'];
					$addContainerQuery = "INSERT INTO par_container_info (id, igp_status, tonnage, dimension, has_containers) VALUES ('$lastInsertPARId', '".DEFAULT_IGP_STATUS."', '$tonnage', '$dimension', 'no')";

				break;
				case '20 ft. Container':
				case '40 ft. Container':
				case 'ODC':
					$containerCount = $containerData[$i]['container_count'];
					$containerDetails = json_encode($containerData[$i]['container_detail'], JSON_FORCE_OBJECT);
					$addContainerQuery = "INSERT INTO par_container_info (id, igp_status, container_details, dimension, container_count, has_containers) VALUES ('$lastInsertPARId', '".DEFAULT_IGP_STATUS."','$containerDetails', '$dimension', '$containerCount', 'yes')";
				break;
			}

			mysqli_query($dbc, $addContainerQuery);

			//file_put_contents("formlog.log", print_r( $addContainerQuery, true ), FILE_APPEND | LOCK_EX);	
			//file_put_contents("formlog.log", print_r( $containerDetails, true ));
		}
	}

	function deleteContainerItems($parID){
		global $dbc;
		$query = "DELETE FROM par_container_info WHERE id='$parID' AND added_from='" . ADDED_FROM . "'";
		mysqli_query($dbc,$query);
	}

	function updatePAR(){
		global $dbc;
		$parId = $_POST['par_id'];
		$importingFirmName = mysqli_real_escape_string($dbc, trim($_POST['importing_firm_name']));
		$bolAwbNumber = mysqli_real_escape_string($dbc, trim($_POST['bol_awb_number']));
		$materialName = mysqli_real_escape_string($dbc, trim($_POST['material_name']));
		$packingNature = mysqli_real_escape_string($dbc, trim($_POST['packing_nature']));
		$materialNature = mysqli_real_escape_string($dbc, trim($_POST['material_nature']));
		$requiredPeriod = mysqli_real_escape_string($dbc, trim($_POST['required_period']));
		$assessableValue = mysqli_real_escape_string($dbc, trim($_POST['assessable_value']));
		$boeNumber = mysqli_real_escape_string($dbc, trim($_POST['boe_number']));
		$qtyUnits = mysqli_real_escape_string($dbc, trim($_POST['qty_units']));
		$spaceRequirement = mysqli_real_escape_string($dbc, trim($_POST['space_requirement']));
		$dutyAmount = mysqli_real_escape_string($dbc, trim($_POST['duty_amount']));
		$expectedDate = mysqli_real_escape_string($dbc, trim($_POST['expected_date']));
		$bolAwbDate = mysqli_real_escape_string($dbc, trim($_POST['bol_awb_date']));
		$boeDate = mysqli_real_escape_string($dbc, trim($_POST['boe_date']));
		$chaName = mysqli_real_escape_string($dbc, trim($_POST['cha_name']));
		$cargoLife = mysqli_real_escape_string($dbc, trim($_POST['cargo_life']));
		$shelfLife = mysqli_real_escape_string($dbc, trim($_POST['shelf_life']));
		$insuranceBy = mysqli_real_escape_string($dbc, trim($_POST['insurance_by']));
		$query = "UPDATE pre_arrival_request SET importing_firm_name='$importingFirmName', bol_awb_number='$bolAwbNumber', material_name='$materialName', packing_nature='$packingNature', material_nature='$materialNature', required_period='$requiredPeriod', assessable_value='$assessableValue', boe_number='$boeNumber', qty_units='$qtyUnits', space_requirement='$spaceRequirement', duty_amount='$dutyAmount', expected_date='$expectedDate', bol_awb_date='$bolAwbDate', boe_date='$boeDate', cha_name='$chaName', cargo_life='$cargoLife', shelf_life='$shelfLife', insurance_by='$insuranceBy' WHERE par_id='$parId'";

		// $containerData = $_POST['container_stringified'];
		// $parFormElementsArray = array("importing_firm_name"=>"importing_firm_name","bol_awb_number"=>"bol_awb_number","material_name"=>"material_name","packing_nature"=>"packing_nature","assessable_value"=>"assessable_value","material_nature"=>"material_nature","required_period"=>"required_period","cha_name"=>"cha_name","boe_number"=>"boe_number","qty_units"=>"qty_units","space_requirement"=>"space_requirement","duty_amount"=>"duty_amount","expected_date"=>"expected_date", "insurance_declaration"=>"insurance_declaration", "cargo_life"=>"cargo_life", "shelf_life"=>"shelf_life", "bol_awb_date"=>"bol_awb_date", "boe_date"=>"boe_date", "insurance_by"=>"insurance_by");
		// $parFormElementsArray = $form->getFormValues($parFormElementsArray,$_POST);
		
		////file_put_contents("formlog.log", print_r( $containerData, true ), FILE_APPEND | LOCK_EX);

		if(isset($_FILES['client_insurance_file']['name'])){
    		$clientInsuranceFname = $_POST['importing_firm_name'].'_client_insurance_copy_'.$_FILES['client_insurance_file']['name'];
    		$clientInsuranceCopyPath = CLIENT_INSURANCE_COPY_PATH.$clientInsuranceFname;
    		$parFormElementsArray['client_insurance_copy'] = $clientInsuranceCopyPath;
    		if(!move_uploaded_file($_FILES['client_insurance_file']['tmp_name'],$clientInsuranceCopyPath)){
    			$output = array("infocode" => "FILEUPLOADERR", "message" => "Unable to upload Clinet insurance file copy, please try again!");
    		}
    	}

    	if(isset($_FILES['insurance_declaration_file']['name'])){
    		$insuranceDeclarationFname = $_POST['importing_firm_name'].'_insurance_declaration_copy_'.$_FILES['insurance_declaration_file']['name'];
    		$insuranceDeclarationCopyPath = INSURANCE_DECLARATION_COPY_PATH.$insuranceDeclarationFname;
    		$parFormElementsArray['insurance_declaration_copy'] = $insuranceDeclarationCopyPath;
    		if(!move_uploaded_file($_FILES['insurance_declaration_file']['tmp_name'],$insuranceDeclarationCopyPath)){
    			$output = array("infocode" => "FILEUPLOADERR", "message" => "Unable to upload insurance declaration file copy, please try again!");
    		}
    	}
		// $wherearray = array('condition'=>'par_id = :par_id', 'param'=>':par_id', 'value'=>$par_id);
	 //    $db->updateOperation('pre_arrival_request',$parFormElementsArray,$wherearray);
	    if(mysqli_query($dbc, $query)){
	    	return array("status"=>"Success","message"=>"Pre Arrival Request updated successfully.");
	    	
	    } else {
	    	return array("status"=>"failure","message"=>"Pre Arrival Request not updated successfully.");
	    }
	}

	function PARStatusChange(){
		global $db,$form;
		$par_id = $_POST['par_id'];
	    $par_status = $_POST['status'];
	    $wherearray = array('condition'=>'par_id = :par_id', 'param'=>':par_id', 'value'=>$par_id);
	    $db->updateOperation('pre_arrival_request',array('status'=>$par_status),$wherearray);
	    
	    $parlogarray = array("par_id" => $par_id, "status_from" => "Submitted", "status_to" => ucfirst($par_status), "remarks" => "PAR ".ucfirst($par_status));
	    $db->insertOperation('par_log',$parlogarray);
	    
	    return array("status"=>"Success","message"=>"Pre Arrival Request " . $par_status . ".");
	}

?>