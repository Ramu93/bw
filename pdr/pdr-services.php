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
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function getBondOrderList(){
		global $dbc;
		$query = "SELECT bond_number, do_ver_id FROM document_verification";
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
		$dvId = $_POST['dv_id'];

		$query = "SELECT sac_par_table, sac_par_id FROM document_verification WHERE do_ver_id='$dvId'";
		$output = array();
		$result = mysqli_query($dbc,$query);
		if(mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			if($row['sac_par_table'] == 'sac'){
				$table = 'sac';
				$tableName = 'sac_request';
				$colName = 'sac_id';
			} else {
				$table = 'par';
				$tableName = 'pre_arrival_request';
				$colName = 'par_id';
			}
			$sacParId = $row['sac_par_id'];
			$innerQuery = "SELECT $colName as 'id', '$table' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number, material_name, material_nature, packing_nature FROM $tableName WHERE $colName='$sacParId'";
			$innerResult = mysqli_query($dbc,$innerQuery);
			if(mysqli_num_rows($innerResult) > 0){
				$innerRow = mysqli_fetch_assoc($innerResult);
				$output = array("infocode" => "DATADETAILFETCHSUCCESS", "data" => json_encode($innerRow));
			}
			
		}
		//file_put_contents("datalog.log", print_r($innerQuery, true ));
		return $output;
	}

	function getItemsList(){
		global $dbc;
		$sacParTable = mysqli_real_escape_string($dbc, trim($_POST['sac_par_table']));
		$sacParId = mysqli_real_escape_string($dbc, trim($_POST['sac_par_id']));
		$query = "SELECT item_name, item_qty FROM dv_items WHERE sac_par_table='$sacParTable' AND sac_par_id='$sacParId'";
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

	function createPDR(){
		global $dbc;
		$bondNumber = mysqli_real_escape_string($dbc, $_POST['bond_number']);
		$sacParTable = mysqli_real_escape_string($dbc, $_POST['sac_par_table']);
		$sacParId = mysqli_real_escape_string($dbc, $_POST['sac_par_id']);
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
	}
?>
