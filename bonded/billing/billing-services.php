<?php 
	require('../dbconfig.php');
	require('../dbwrapper_mysqli.php');

	define('SAC_DEFAULT_STATUS','submitted');
	define('ADDED_FROM', 'sac');
	define('DEFAULT_IGP_STATUS', 'notgenerated');

	$db = new DBWrapper($dbc);
	$finaloutput = array();
	if(!$_POST) {
		$action = $_GET['action'];
	}
	else {
		$action = $_POST['action'];
	}
	switch($action){
	    case 'get_party_details':
	    	$finaloutput = getPartyDetails();
	    break;
	    case 'get_grn_list':
	    	$finaloutput = getGRNList();
	    break;
	    case 'get_previous_bill':
	    	$finaloutput = getPreviousBill();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function  getPartyDetails(){
		global $dbc;
		$partyName = mysqli_real_escape_string($dbc, trim($_POST['party_name']));
		$query = "SELECT * FROM party_master WHERE pm_customerName='$partyName'";
		$result = mysqli_query($dbc, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$output = array("infocode" => "SUCCESS", "data" => $row['pm_id']);
		} else {
			$output = array("infocode" => "NOTSUCCESS");
		}

		return $output;
	} 

	function getGRNList(){
		global $dbc;
		$partyName = mysqli_real_escape_string($dbc, trim($_POST['party_name']));
		$query = "SELECT sac.importing_firm_name, sac.cha_name, grn.grn_id FROM sac_request sac, bonded_good_receipt_note grn WHERE (sac.importing_firm_name='$partyName' OR sac.cha_name='$partyName') AND grn.sac_id=sac.sac_id";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}

			$output = array("infocode" => "SUCCESS", "data" => $out);
		} else {
			$output = array("infocode" => "failure", "message" => "No GRN available for selected details.");
		}
        //file_put_contents("testlog.log",print_r($output, true), FILE_APPEND | LOCK_EX);

		return $output;
	}

	function getPreviousBill(){
		global $dbc;
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$query = "SELECT * FROM bonded_billing WHERE grn_id='$grnId' ORDER BY billing_date DESC LIMIT 1";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$out = $row;
			}

			$output = array("infocode" => "SUCCESS", "data" => $out);
		} else {
			$output = array("infocode" => "failure", "message" => "No GRN available for selected details.");
		}
        file_put_contents("testlog.log",print_r($output, true), FILE_APPEND | LOCK_EX);

	}

?>