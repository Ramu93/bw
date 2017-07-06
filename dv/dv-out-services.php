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
		global $dbc;
		$pdrId = $_POST['pdr_id'];
		$exbond = $_POST['exbond_original'];
		$exboe = $_POST['exboe_original'];
		$orderNumber = $_POST['order_number'];
		$vehicleNumber = $_POST['vehicle_number'];
		$licenseNumber = $_POST['license_number'];

		$query = "INSERT INTO dv_outward (pdr_id, exbond_original, exboe_original, order_number, vehicle_number, license_number) VALUES ('$pdrId', '$exbond', '$exboe', '$orderNumber', '$vehicleNumber', '$licenseNumber')";
		if(mysqli_query($dbc, $query)){
			if($exbond == 'yes' || $exboe == 'yes' || $orderNumber == 'yes' || $vehicleNumber == 'yes' || $licenseNumber == 'yes'){
				updateDocumentVerificationStatusInPDR();
			}
			return array("infocode"=>"DOCUMENTVERIFICATIONSUCCESS","message"=>"Document verification data saved successfully.");
		} else {
			return array("infocode"=>"DOCUMENTNOTVERIFIED","message"=>"Documents not verified.");
		}
		
	}

	function updateDocumentVerificationStatusInPDR(){
		global $dbc;
		$pdrId = $_POST['pdr_id'];
		$query = "UPDATE despatch_request SET document_verified='yes' WHERE pdr_id='$pdrId'";
		mysqli_query($dbc,$query);
	}

?>