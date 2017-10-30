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
	    case 'compare_bond_date':
	    	$finaloutput = compareBondDateWithBoeDate();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function submitVerification(){
		global $db,$form;
		$docVerificationArray = array("sac_id"=>"sac_id", "invoice_copy"=>"invoice_copy", "packing_list"=>"packing_list", "boe_copy"=>"boe_copy", "bond_order"=>"bond_order", "cfs_name"=>"cfs_name", "customs_officer_name"=>"customs_officer_name", "do_number"=>"do_number", "do_date"=>"do_date", "do_issued_by"=>"do_issued_by", "bond_number"=>"bond_number", "bond_date"=>"bond_date");
		$docVerificationArray = $form->getFormValues($docVerificationArray,$_POST);	
		$db->insertOperation('bonded_dv_inward',$docVerificationArray);
		addItemsToDVItems();
		updateDocumentVerificationStatusInParSac();
		return array("infocode"=>"DOCUMENTVERIFICATIONSUCCESS","message"=>"Document verification data saved successfully.");	
	}

	function addItemsToDVItems(){
		global $dbc;
		$sacId = $_POST['sac_id'];
		$itemNames = $_POST['item_name'];
		$assessableValues = $_POST['assessabe_value'];
		$dutyValues = $_POST['duty_value'];
		$insuranceValues = $_POST['insurance_value'];
		$containerNumbers = $_POST['container_number'];
		$itemQuantities = $_POST['item_qty'];

		for($i = 0; $i < count($itemNames); $i++){
			$tempItemName = mysqli_real_escape_string($dbc, trim($itemNames[$i]));
			$tempAssessableValue = mysqli_real_escape_string($dbc, trim($assessableValues[$i]));
			$tempDutyValue = mysqli_real_escape_string($dbc, trim($dutyValues[$i]));
			$tempInsuranceValue = mysqli_real_escape_string($dbc, trim($insuranceValues[$i]));
			$containerNumber = mysqli_real_escape_string($dbc, trim($containerNumbers[$i]));
			$itemQuantity = mysqli_real_escape_string($dbc, trim($itemQuantities[$i]));

			$query = "INSERT INTO bonded_dv_items (sac_id, item_name, assessable_value, duty_value, insurance_value, container_number, item_qty) VALUES ('$sacId', '$tempItemName', '$tempAssessableValue', '$tempDutyValue', '$tempInsuranceValue', '$containerNumber', '$itemQuantity')";
			//file_put_contents("formlog.log", print_r(json_encode($query), true ));
			mysqli_query($dbc,$query);
		}
		
	}

	function updateDocumentVerificationStatusInParSac(){
		global $dbc;
		$sacId = $_POST['sac_id'];
		$query = "UPDATE sac_request SET document_verified='yes' WHERE sac_id='$sacId'";
		mysqli_query($dbc,$query);
	}

	function getContainerData(){
		global $dbc;
		$sacID = $_POST['sac_id'];
		$containerRows = array();
		$query = "SELECT * FROM sac_container_info WHERE id='" . $sacID . "'";
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

	function compareBondDateWithBoeDate(){
		global $dbc;
		$sacId = $_POST['sac_id'];
		$bondDate = $_POST['bond_date'];
		$query = "SELECT boe_date FROM sac_request WHERE sac_id='$sacId'";
		$result = mysqli_query($dbc, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$boeDate = strtotime($row['boe_date']);
			$bondDate = strtotime($bondDate);
			if($bondDate >= $boeDate){
				$output = array("infocode" => "GREATER");
			} else {
				$output = array("infocode" => "LESSER");
			}
		} else {
			$output = array("infocode" => "NODATA");
		}
		return $output;
	}

?>