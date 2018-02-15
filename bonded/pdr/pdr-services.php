<?php
	require('../dbconfig.php'); 
	require('../dbconfig_pdo.php'); 
	require('../dbwrapper.php');
	require('../formwrapper.php');

	//define('GRN_CREATED_STATUS','grn_created');

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
	    case 'get_bond_order_list':
	        $finaloutput = getBondOrderList();
	    break;
	    case 'get_selected_data_details':
	    	$finaloutput = getSelectedDataDetails();
	    break;
	    case 'get_items_list':
	    	$finaloutput = getItemsList();
	    break;
	    case 'create_pdr':
	    	$finaloutput = createPDR();
	    break;
	    case 'update_pdr':
	    	$finaloutput = updatePDR();
	    break;
	    case 'update_status_pdr':
	    	$finaloutput = updateStatusPDR();
	    break;
	    case 'get_pdr_items':
	    	$finaloutput = getPDRItemsList();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function getBondOrderList(){
		global $dbc;

		$type = $_POST['type'];

		switch ($type) {
			case 'bond_number':
				$query = "SELECT dv.bond_number as 'data_item', dv.sac_id FROm bonded_dv_inward dv, sac_request sac WHERE dv.sac_id=sac.sac_id";
			break;
			case 'boe':
				$query = "SELECT dv.sac_id, sac.boe_number as 'data_item' FROM bonded_dv_inward dv, sac_request sac WHERE dv.sac_id=sac.sac_id";
			break;
			case 'grn':
				$query = "SELECT dv.sac_id, grn.grn_id as 'data_item' FROM bonded_dv_inward dv, bonded_good_receipt_note grn WHERE dv.sac_id=grn.sac_id";
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
			$output = array("infocode" => "NOBONDORDERFOUND", "message" => "The entered data is not available","data"=>"");
		}
		//file_put_contents("formlog.log", print_r( $output, true ));
		return $output;
	}

	function getSelectedDataDetails(){
		global $dbc;
		$sacId = $_POST['sac_id'];
		$innerQuery = "SELECT sac_id as 'id', 'sac' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number, material_name, material_nature, packing_nature, assessable_value, duty_amount FROM sac_request WHERE sac_id='$sacId'";
		$innerResult = mysqli_query($dbc,$innerQuery);
		if(mysqli_num_rows($innerResult) > 0){
			$innerRow = mysqli_fetch_assoc($innerResult);
			$query2 = "SELECT * FROM bonded_dv_inward WHERE sac_id='$sacId'";
			$result2 = mysqli_query($dbc, $query2);
			$row2 = mysqli_fetch_assoc($result2);
			$innerRow['bond_number'] = $row2['bond_number'];
			$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
		}
		//file_put_contents("datalog.log", print_r($innerQuery, true ));
		return $output;
	}

	function getItemsList(){
		global $dbc;
		$sacId = mysqli_real_escape_string($dbc, trim($_POST['sac_id']));
		$query = "SELECT dv_item_id, item_name, item_qty, sac_id, container_number FROM bonded_dv_items WHERE sac_id='$sacId'";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
		}

		$output = array("infocode" => "ITEMDATAFETCHSUCCESS", "data" => json_encode($out));
		// file_put_contents("datalog.log", print_r($output, true ));
		return $output;
	}

	function getPDRItemsList(){
		global $dbc;
		$pdrId = mysqli_real_escape_string($dbc, trim($_POST['pdr_id']));
		$query = "SELECT * FROM bonded_pdr_items WHERE pdr_id='$pdrId'";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			while ($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
		}
		//file_put_contents("datalog.log", print_r($out, true ));
		$output = array("infocode" => "ITEMDATAFETCHSUCCESS", "data" => json_encode($out));
		return $output;
	}

	function createPDR(){
		global $dbc;
		//$bondNumber = mysqli_real_escape_string($dbc, $_POST['bond_number']);
		$sacId = mysqli_real_escape_string($dbc, $_POST['sac_id']);
		$clientWeb = mysqli_real_escape_string($dbc, $_POST['client_web']);
		$chaName = mysqli_real_escape_string($dbc, $_POST['cha_name_exporter']);
		$orderNumber = mysqli_real_escape_string($dbc, $_POST['order_number']);
		$boeNumber = mysqli_real_escape_string($dbc, $_POST['boe_number']);
		$exBondBeNumber = mysqli_real_escape_string($dbc, $_POST['exbond_be_number']);
		$exBondBeDate = mysqli_real_escape_string($dbc, $_POST['exbond_be_date']);
		$customsOfficerName = mysqli_real_escape_string($dbc, $_POST['customs_officer_name']);
		$numberOfPackages = mysqli_real_escape_string($dbc, $_POST['packages_number']);
		$assessmentValue = mysqli_real_escape_string($dbc, $_POST['assessment_value']);
		$dutyValue = mysqli_real_escape_string($dbc, $_POST['duty_value']);
		$transporterName = mysqli_real_escape_string($dbc, $_POST['transporter_name']);
		$itemObject = json_decode($_POST['item_data']);
		$itemData = array();
  		$itemData = json_decode(json_encode($itemObject), True);
  		$bondNumber = mysqli_real_escape_string($dbc, $_POST['bond_number']);
		//file_put_contents("datalog.log", print_r($itemData, true ));

  		$query = "INSERT INTO bonded_despatch_request (sac_id, client_web, cha_name, order_number, boe_number, exbond_be_number, exbond_be_date, customs_officer_name, number_of_packages, assessment_value, duty_value, transporter_name, created_date, bond_number) VALUES ('$sacId', '$clientWeb', '$chaName', '$orderNumber', '$boeNumber', '$exBondBeNumber', '$exBondBeDate', '$customsOfficerName', '$numberOfPackages', '$assessmentValue', '$dutyValue', '$transporterName', '". date("Y-m-d") ."', '$bondNumber')";
		// file_put_contents("querylog.log", print_r($query, true ));
  		if(mysqli_query($dbc, $query)){
  			$lastPdrId = mysqli_insert_id($dbc);
  			foreach ($itemData as $item) {
  				if($item['is_item_selected'] == 'true'){
  					$dvItemId = $item['dv_item_id'];
  					$containerNumber = $item['container_number'];
  					$despatchQty = $item['despatch_qty'];
  					$itemName = $item['item_name'];

  					$itemQuery = "INSERT INTO bonded_pdr_items (dv_item_id, pdr_id, container_number, despatch_qty, item_name, sac_id) VALUES ('$dvItemId', $lastPdrId, '$containerNumber', '$despatchQty', '$itemName', '$sacId')";
  					//file_put_contents("querylog.log", $itemQuery, FILE_APPEND | LOCK_EX);
  					mysqli_query($dbc, $itemQuery);
  				}
  			}
  			//add entry in bonded_
  			//addGDNEntry($lastPdrId);
  			$output = array("infocode" => "CREATEPDRSUCCESS", "message" => "PDR successfully created.");
  		} else {
  			$output = array("infocode" => "CREATEPDRFAILURE", "message" => "PDR not created successfully.");
  		}
  		return $output;
	}

	function updatePDR(){
		global $dbc;
		$pdrId = $_POST['pdr_id'];
		
		$clientWeb = mysqli_real_escape_string($dbc, $_POST['client_web']);
		$chaName = mysqli_real_escape_string($dbc, $_POST['cha_name_exporter']);
		$orderNumber = mysqli_real_escape_string($dbc, $_POST['order_number']);
		$boeNumber = mysqli_real_escape_string($dbc, $_POST['boe_number']);
		$exBondBeNumber = mysqli_real_escape_string($dbc, $_POST['exbond_be_number']);
		$exBondBeDate = mysqli_real_escape_string($dbc, $_POST['exbond_be_date']);
		$customsOfficerName = mysqli_real_escape_string($dbc, $_POST['customs_officer_name']);
		$numberOfPackages = mysqli_real_escape_string($dbc, $_POST['packages_number']);
		$assessmentValue = mysqli_real_escape_string($dbc, $_POST['assessment_value']);
		$dutyValue = mysqli_real_escape_string($dbc, $_POST['duty_value']);
		$transporterName = mysqli_real_escape_string($dbc, $_POST['transporter_name']);

		$query = "UPDATE bonded_despatch_request SET client_web='$clientWeb', cha_name='$chaName', order_number='$orderNumber', boe_number='$boeNumber', exbond_be_number='$exBondBeNumber', exbond_be_date='$exBondBeDate', customs_officer_name='$customsOfficerName', number_of_packages='$numberOfPackages', assessment_value='$assessmentValue', duty_value='$dutyValue', transporter_name='$transporterName' WHERE pdr_id='$pdrId'";
		if(mysqli_query($dbc, $query)){
			$output = array("infocode" => "UPDATEPDRSUCCESS", "message" => "PDR updation successful.");
		} else {
			$output = array("infocode" => "UPDATEPDRFAILURE", "message" => "PDR updation unsuccessful.");
		}
		return $output;
	}

	function updateStatusPDR(){
		global $dbc;
		$pdrId = $_POST['pdr_id'];
		$status = $_POST['status'];

		$query = "UPDATE bonded_despatch_request SET status='$status' WHERE pdr_id='$pdrId'";
		if(mysqli_query($dbc, $query)){
			$output = array("infocode" => "UPDATEPDRSUCCESS", "message" => "PDR updation successful.");
		} else {
			$output = array("infocode" => "UPDATEPDRFAILURE", "message" => "PDR updation unsuccessful.");
		}
		return $output;
	}
?>
