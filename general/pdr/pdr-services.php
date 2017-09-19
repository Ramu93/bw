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
			case 'boe':
				$query = "SELECT dv.par_id, par.boe_number as 'data_item' FROM general_dv_inward dv, pre_arrival_request par WHERE dv.par_id=par.par_id";
			break;
			case 'grn':
				$query = "SELECT dv.par_id, grn.grn_id as 'data_item' FROM general_dv_inward dv, general_good_receipt_note grn WHERE dv.par_id=grn.par_id";
			break;
			case 'invoice':
				$query = "SELECT dv.par_id, par.bol_awb_number as 'data_item' FROM general_dv_inward dv, pre_arrival_request par WHERE dv.par_id=par.par_id";
			break;
		}

		// $query = "SELECT dv.bond_number, dv.do_ver_id, dv.par_id FROM general_dv_inward dv, pre_arrival_request par, ";
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
		$parId = $_POST['par_id'];
		$innerQuery = "SELECT par_id as 'id', 'par' as 'table_name', importing_firm_name, bol_awb_number, boe_number, material_name, material_nature, packing_nature FROM pre_arrival_request WHERE par_id='$parId'";
		$innerResult = mysqli_query($dbc,$innerQuery);
		if(mysqli_num_rows($innerResult) > 0){
			$innerRow = mysqli_fetch_assoc($innerResult);
			$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
		}
		//file_put_contents("datalog.log", print_r($innerQuery, true ));
		return $output;
	}

	function getItemsList(){
		global $dbc;
		$parId = mysqli_real_escape_string($dbc, trim($_POST['par_id']));
		$query = "SELECT dv_item_id, item_name, item_qty, par_id, container_number FROM general_dv_items WHERE par_id='$parId'";
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
		$query = "SELECT * FROM general_pdr_items WHERE pdr_id='$pdrId'";
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
		$parId = mysqli_real_escape_string($dbc, $_POST['par_id']);
		//$clientWeb = mysqli_real_escape_string($dbc, $_POST['client_web']);
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
		//file_put_contents("datalog.log", print_r($itemData, true ));

  		$query = "INSERT INTO general_despatch_request (par_id, cha_name, order_number, boe_number, exbond_be_number, exbond_be_date, customs_officer_name, number_of_packages, assessment_value, duty_value, transporter_name) VALUES ('$parId', '$chaName', '$orderNumber', '$boeNumber', '$exBondBeNumber', '$exBondBeDate', '$customsOfficerName', '$numberOfPackages', '$assessmentValue', '$dutyValue', '$transporterName')";
		// file_put_contents("querylog.log", print_r($query, true ));
  		if(mysqli_query($dbc, $query)){
  			$lastPdrId = mysqli_insert_id($dbc);
  			foreach ($itemData as $item) {
  				if($item['is_item_selected'] == 'true'){
  					$dvItemId = $item['dv_item_id'];
  					$containerNumber = $item['container_number'];
  					$despatchQty = $item['despatch_qty'];
  					$itemName = $item['item_name'];

  					$itemQuery = "INSERT INTO general_pdr_items (dv_item_id, pdr_id, container_number, despatch_qty, item_name, par_id) VALUES ('$dvItemId', $lastPdrId, '$containerNumber', '$despatchQty', '$itemName', '$parId')";
  					//file_put_contents("querylog.log", $itemQuery, FILE_APPEND | LOCK_EX);
  					mysqli_query($dbc, $itemQuery);
  				}
  			}
  			//ad entry in general_good_delivery_note
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

		$query = "UPDATE general_despatch_request SET client_web='$clientWeb', cha_name='$chaName', order_number='$orderNumber', boe_number='$boeNumber', exbond_be_number='$exBondBeNumber', exbond_be_date='$exBondBeDate', customs_officer_name='$customsOfficerName', number_of_packages='$numberOfPackages', assessment_value='$assessmentValue', duty_value='$dutyValue', transporter_name='$transporterName' WHERE pdr_id='$pdrId'";
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

		$query = "UPDATE general_despatch_request SET status='$status' WHERE pdr_id='$pdrId'";
		if(mysqli_query($dbc, $query)){
			$output = array("infocode" => "UPDATEPDRSUCCESS", "message" => "PDR updation successful.");
		} else {
			$output = array("infocode" => "UPDATEPDRFAILURE", "message" => "PDR updation unsuccessful.");
		}
		return $output;
	}
?>
