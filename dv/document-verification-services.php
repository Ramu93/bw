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
		case 'submit_verification':
			$finaloutput = submitVerification();
		break;
	    case 'get_container_data':
	    	$finaloutput = getContainerData();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function submitVerification(){
		global $db,$form;
		$docVerificationArray = array("sac_par_table"=>"sac_par_table", "sac_par_id"=>"sac_par_id", "invoice_copy"=>"invoice_copy", "packing_list"=>"packing_list", "boe_copy"=>"boe_copy", "bond_order"=>"bond_order", "do_verification"=>"do_verification", "weight"=>"weight", "no_of_packages"=>"no_of_packages", "description"=>"description", "cfs_name"=>"cfs_name", "customs_officer_name"=>"customs_officer_name", "do_number"=>"do_number", "do_date"=>"do_date", "do_issued_by"=>"do_issued_by", "bond_number"=>"bond_number", "bond_date"=>"bond_date");
		$docVerificationArray = $form->getFormValues($docVerificationArray,$_POST);	
		if($docVerificationArray['do_verification'] == 'yes'){
			$db->insertOperation('document_verification',$docVerificationArray);
			addItemsToDVItems();
			updateDocumentVerificationStatusInParSac();
			return array("infocode"=>"DOCUMENTVERIFICATIONSUCCESS","message"=>"Document verification data saved successfully.");
		} else {
			return array("infocode"=>"DOCUMENTNOTVERIFIED","message"=>"Documents not verified.");
		}
		
	}

	function addItemsToDVItems(){
		global $dbc;
		$sacParTable = $_POST['sac_par_table'];
		$sacParId = $_POST['sac_par_id'];
		$itemNames = $_POST['item_name'];
		$assessableValues = $_POST['assessabe_value'];
		$dutyValues = $_POST['duty_value'];
		$insuranceValues = $_POST['insurance_value'];
		$containerNumbers = $_POST['container_number'];

		for($i = 0; $i < count($itemNames); $i++){
			$tempItemName = mysqli_real_escape_string($dbc, trim($itemNames[$i]));
			$tempAssessableValue = mysqli_real_escape_string($dbc, trim($assessableValues[$i]));
			$tempDutyValue = mysqli_real_escape_string($dbc, trim($dutyValues[$i]));
			$tempInsuranceValue = mysqli_real_escape_string($dbc, trim($insuranceValues[$i]));
			$containerNumber = mysqli_real_escape_string($dbc, trim($containerNumbers[$i]));
			$query = "INSERT INTO dv_items (sac_par_table, sac_par_id, item_name, assessable_value, duty_value, insurance_value, container_number) VALUES ('$sacParTable', '$sacParId', '$tempItemName', '$tempAssessableValue', '$tempDutyValue', '$tempInsuranceValue', '$containerNumber')";
			//file_put_contents("formlog.log", print_r(json_encode($query), true ));
			mysqli_query($dbc,$query);
		}
		
	}

	function updateDocumentVerificationStatusInParSac(){
		global $dbc;
		$sacParTable = $_POST['sac_par_table'];
		$sacParId = $_POST['sac_par_id'];
		if($sacParTable == 'sac'){
			$tableName = 'sac_request';
			$idCol = 'sac_id';
		} else if($sacParTable == 'par'){
			$tableName = 'pre_arrival_request';
			$idCol = 'par_id';
		}
		$query = "UPDATE $tableName SET document_verified='yes' WHERE $idCol='$sacParId'";
		mysqli_query($dbc,$query);
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

?>