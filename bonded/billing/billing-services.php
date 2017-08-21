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
	    case 'get_grn_info':
	    	$finaloutput = getGRNInfo();
	    break;
	    case 'get_previous_bill':
	    	$finaloutput = getPreviousBill();
	    break;
	    case 'generate_bill':
	    	$finaloutput = generateBill();
	    break;
	    case 'save_bill':
	    	$finaloutput = saveBill();
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
        // file_put_contents("testlog.log",$query, FILE_APPEND | LOCK_EX);

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

	function getGRNInfo(){
		global $dbc;
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$query = "SELECT * FROM bonded_good_receipt_note WHERE grn_id='$grnId'";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$out = $row;
			$output = array("infocode" => "SUCCESS", "data" => $out);
		} else {
			$output = array("infocode" => "failure", "message" => "No GRN data found.");
		}
        // file_put_contents("testlog.log",print_r($output, true), FILE_APPEND | LOCK_EX);

		return $output;
	}

	function getPreviousBill(){
		global $dbc;
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$query = "SELECT * FROM bonded_billing_invoice WHERE grn_id='$grnId' ORDER BY billing_date DESC LIMIT 1";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$out = $row;
			$output = array("infocode" => "SUCCESS", "data" => $out);
		} else {
			$output = array("infocode" => "failure", "message" => "No GRN available for selected details.");
		}
        // file_put_contents("testlog.log",print_r($output, true), FILE_APPEND | LOCK_EX);
		return $output;
	}

	function getPartyId($partyName){
		global $dbc;
		$query = "SELECT * FROM party_master WHERE pm_customerName='$partyName'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		return $row['pm_id'];
	}

	function getPartyFromSAC($grnId){
		global $dbc;
		$query = "SELECT sac.importing_firm_name, sac.cha_name FROM sac_request sac, bonded_good_receipt_note grn WHERE grn.grn_id='$grnId' AND grn.sac_id=sac.sac_id";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$partyNames = array('customer_name' => $row['importing_firm_name'], 'cha_name' => $row['cha_name']);
        // file_put_contents("testlog.log",print_r($partyNames, true), FILE_APPEND | LOCK_EX);
		return $partyNames;
	}

	function getUnitDetails($grnId){
		global $dbc;
		$query = "SELECT unit, no_of_units FROM bonded_good_receipt_note WHERE grn_id='$grnId'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$unitDetails = array('no_of_units' => $row['no_of_units'], 'unit' => $row['unit']);
		return $unitDetails;
	}

	function getTariffMasterId($unit){
		global $dbc;
		$query = "SELECT tariff_master_id FROM tariff_master WHERE unit='$unit'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$tariffMasterId = $row['tariff_master_id'];
		return $tariffMasterId;
	}

	function getBaseTariffData($tariffMasterId){
		global $dbc;
		$query = "SELECT * FROM tariff_master WHERE tariff_master_id='$tariffMasterId'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$tariff = array('price_per_unit' => $row['price_per_unit'], 'minimum_slab' => $row['minimum_slab']);
		return $tariff;
	}

	function getDiscountTariff($customerPartyId, $chaPartyId, $tariffMasterId){
		global $dbc; 
		$query = "SELECT * FROM discount_master WHERE customer_pm_id='$customerPartyId' AND cha_pm_id='$chaPartyId' AND tariff_master_id='$tariffMasterId'";
		$result = mysqli_query($dbc, $query);
		$rowCount = mysqli_num_rows($result);
		if($rowCount > 0){
			$row = mysqli_fetch_assoc($result);
			$discountDetails = array('row_count' => $rowCount, 'discount_percentage' => $row['discount_percentage']);
		} else {
			$discountDetails = array('row_count' => $rowCount);
		}
		return $discountDetails;
	}

	function generateHandlingChargesBill($descriptions, $amounts, $gstSlabs, $gstType){
		global $dbc;
		$count = count($amounts);
		$finalSubTotal = 0;
		$finalTaxAmount = 0;
		$finalTotalAmount = 0;
		$gstType = 'same_state';
        //file_put_contents("testlog.log", print_r($amounts, true), FILE_APPEND | LOCK_EX);
		for($i = 0; $i < $count; $i++){
			$description = $descriptions[$i];
			$amount = $amounts[$i];
			$query = '';
			$totalAmount = 0;
			$taxAmount = 0;
			
			$taxAmount = $amount * ($gstSlabs[$i]/100);
			$totalAmount = $amount + $taxAmount;

			// switch ($gstType) {
			// 	case 'same_state':
			// 		$sgst = $amount * (($gstPercentages['same_state']/2)/100);
			// 		$cgst = $amount * (($gstPercentages['same_state']/2)/100);
			// 		$taxAmount = $amount * ($gstPercentages['same_state']/100);
			// 		$totalAmount =  $amount + $taxAmount;
			// 		break;
			// 	case 'other_state':
			// 		$igst = $amount * ($gstPercentages['other_state']/100);;
			// 		$taxAmount = $amount * ($gstPercentages['other_state']/100);
			// 		$totalAmount =  $amount + $taxAmount;
			// 		break;
			// 	case 'union_teritory':
			// 		$ugst = $amount * ($gstPercentages['union_teritory']/100);
			// 		$taxAmount = $amount * ($gstPercentages['union_teritory']/100);
			// 		$totalAmount =  $amount + $taxAmount;
			// 		break;
			// 	case 'exempt':
			// 		$totalAmount =  $amount;
			// 		break;
			// }
			$finalSubTotal += $amount;
			$finalTaxAmount += $taxAmount;
			$finalTotalAmount += $totalAmount;
        	//file_put_contents("testlog.log", print_r($query, true), FILE_APPEND | LOCK_EX);
		}

        //file_put_contents("testlog.log", print_r(array('sub_total' => $finalSubTotal, 'tax_amount' => $finalTaxAmount, 'total_amount' => $finalTotalAmount), true), FILE_APPEND | LOCK_EX);

		return array('sub_total' => $finalSubTotal, 'tax_amount' => $finalTaxAmount, 'total_amount' => $finalTotalAmount);
	}

	function generateBill(){
		global $dbc; 
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$billDate = mysqli_real_escape_string($dbc, trim($_POST['bill_date']));
		$fromDateStr = mysqli_real_escape_string($dbc, trim($_POST['from_date']));
		$toDateStr = mysqli_real_escape_string($dbc, trim($_POST['to_date']));
		$billGstType = 'same_state';
		$handlingDescriptions = $_POST['description'];
		$handlingAmounts = $_POST['amount'];
		$handlingGSTSlabs = $_POST['gst_slab'];

		$gstValues = json_decode($_POST['gst_values']);
		$gstPercentages = array();
  		$gstPercentages = json_decode(json_encode($gstValues), True);

        //file_put_contents("testlog.log", print_r($gstPercentages, true), FILE_APPEND | LOCK_EX);

		$unitDetails = getUnitDetails($grnId);
		$partyNames = getPartyFromSAC($grnId);
		
		$customerPartyId = getPartyId($partyNames['customer_name']);
		$chaPartyId = getPartyId($partyNames['cha_name']);
		
		$tariffMasterId = getTariffMasterId($unitDetails['unit']);
		$baseTariffData = getBaseTariffData($tariffMasterId);
		$pricePerUnitPerDay = $baseTariffData['price_per_unit'];
		$discountDetails = getDiscountTariff($customerPartyId, $chaPartyId, $tariffMasterId);
		
		$discountPercentage = 0;
		if($discountDetails['row_count'] > 0){
			$discountPercentage = $discountDetails['discount_percentage'];
		}		

		$noOfUnits = $unitDetails['no_of_units'];
		$minimumSlab = $baseTariffData['minimum_slab'];
		if($noOfUnits < $minimumSlab){
			$noOfUnits = $minimumSlab;
		}

		$fromDate = strtotime($fromDateStr);
		$toDate = strtotime($toDateStr);
		$noOfDays = $fromDate - $toDate;
		$noOfDays = abs(floor($noOfDays / (60 * 60 * 24))) + 1;
		
		if($discountDetails['row_count'] > 0){
			//discounted price
			$subTotal = $noOfDays * ($pricePerUnitPerDay - ($pricePerUnitPerDay * ($discountPercentage/100))) * $noOfUnits;
		} else {
			// base tariff
			$subTotal = $noOfDays * $pricePerUnitPerDay * $noOfUnits;
		}

		$taxAmount = 0;
		$grandTotal = 0;
		switch ($billGstType) { 
			case 'same_state':
				$cgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$sgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$taxAmount = $subTotal * ($gstPercentages['same_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				break;
			case 'other_state':
				$igst = $subTotal * ($gstPercentages['other_state']/100);
				$taxAmount = $subTotal * ($gstPercentages['other_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				break;
			case 'union_teritory':
				$ugst = $subTotal * ($gstPercentages['union_teritory']/100);
				$taxAmount = $subTotal * ($gstPercentages['union_teritory']/100); 
				$grandTotal = $subTotal + $taxAmount;
				break;
			case 'exempt':
				$grandTotal = $subTotal;
				break;
		}

		//$handlingCharges = generateHandlingChargesBill('1',$handlingDescriptions, $handlingAmounts, $handlingGSTTypes, $gstPercentages);

		$output = array();
		$handlingCharges = generateHandlingChargesBill($handlingDescriptions, $handlingAmounts, $handlingGSTSlabs, $billGstType);
		$finalSubTotal = $subTotal + $handlingCharges['sub_total'];
		$finalTaxPayable = $taxAmount + $handlingCharges['tax_amount'];
		$finalGrandTotal = $grandTotal + $handlingCharges['total_amount'];

		$output = array('infocode' => 'SUCCESS', 'sub_total' => $finalSubTotal, 'tax_payable' => $finalTaxPayable, 'grand_total' => $finalGrandTotal);
	
        //file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
        return $output;
	}

	function saveHandlingChargesBill($invoiceId, $descriptions, $amounts, $gstSlabs, $gstType){
		global $dbc;
		$count = count($amounts);
		$finalSubTotal = 0;
		$finalTaxAmount = 0;
		$finalTotalAmount = 0;
        //file_put_contents("testlog.log", print_r($amounts, true), FILE_APPEND | LOCK_EX);
		for($i = 0; $i < $count; $i++){
			$description = $descriptions[$i];
			$amount = $amounts[$i];
			$query = '';
			$totalAmount = 0;
			$taxAmount = 0;
			
			$taxAmount = $amount * ($gstSlabs[$i]/100);
			$totalAmount = $amount + $taxAmount;
			switch ($gstType) {
				case 'same_state':
					$sgst = $taxAmount/2;
					$cgst = $taxAmount/2;
					$totalAmount =  $amount + $taxAmount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, sgst, cgst, tax_payable, total) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$sgst', '$cgst', '$taxAmount', '$totalAmount')";
					break;
				case 'other_state':
					$igst = $taxAmount;
					$totalAmount =  $amount + $taxAmount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, igst, tax_payable, total) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$igst', '$taxAmount', '$totalAmount')";
					break;
				case 'union_teritory':
					$ugst = $taxAmount;
					$totalAmount =  $amount + $taxAmount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, ugst, tax_payable, total) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$ugst', '$taxAmount', '$totalAmount')";
					break;
				case 'exempt':
					$totalAmount =  $amount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, tax_payable, total) VALUES ('$invoiceId', '$description', '$amount', '$gstType','$taxAmount', '$totalAmount')";
					break;
			}
			mysqli_query($dbc, $query);
			$finalSubTotal += $amount;
			$finalTaxAmount += $taxAmount;
			$finalTotalAmount += $totalAmount;
        	//file_put_contents("testlog.log", print_r($query, true), FILE_APPEND | LOCK_EX);
		}

        //file_put_contents("testlog.log", print_r(array('sub_total' => $finalSubTotal, 'tax_amount' => $finalTaxAmount, 'total_amount' => $finalTotalAmount), true), FILE_APPEND | LOCK_EX);

		return array('sub_total' => $finalSubTotal, 'tax_amount' => $finalTaxAmount, 'total_amount' => $finalTotalAmount);
	}


	function saveBill(){
		global $dbc; 
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$billDate = mysqli_real_escape_string($dbc, trim($_POST['bill_date']));
		$fromDateStr = mysqli_real_escape_string($dbc, trim($_POST['from_date']));
		$toDateStr = mysqli_real_escape_string($dbc, trim($_POST['to_date']));
		$billGstType = 'same_state';
		$handlingDescriptions = $_POST['description'];
		$handlingAmounts = $_POST['amount'];
		$handlingGSTSlabs = $_POST['gst_slab'];

		$gstValues = json_decode($_POST['gst_values']);
		$gstPercentages = array();
  		$gstPercentages = json_decode(json_encode($gstValues), True);

        //file_put_contents("testlog.log", print_r($gstPercentages, true), FILE_APPEND | LOCK_EX);

		$unitDetails = getUnitDetails($grnId);
		$partyNames = getPartyFromSAC($grnId);
		
		$customerPartyId = getPartyId($partyNames['customer_name']);
		$chaPartyId = getPartyId($partyNames['cha_name']);
		
		$tariffMasterId = getTariffMasterId($unitDetails['unit']);
		$baseTariffData = getBaseTariffData($tariffMasterId);
		$pricePerUnitPerDay = $baseTariffData['price_per_unit'];
		$discountDetails = getDiscountTariff($customerPartyId, $chaPartyId, $tariffMasterId);
		
		$discountPercentage = 0;
		if($discountDetails['row_count'] > 0){
			$discountPercentage = $discountDetails['discount_percentage'];
		}
		
		$noOfUnits = $unitDetails['no_of_units'];
		$minimumSlab = $baseTariffData['minimum_slab'];
		if($noOfUnits < $minimumSlab){
			$noOfUnits = $minimumSlab;
		}

		$fromDate = strtotime($fromDateStr);
		$toDate = strtotime($toDateStr);
		$noOfDays = $fromDate - $toDate;
		$noOfDays = abs(floor($noOfDays / (60 * 60 * 24))) + 1;
		
		if($discountDetails['row_count'] > 0){
			//discounted price
			$subTotal = $noOfDays * ($pricePerUnitPerDay - ($pricePerUnitPerDay * ($discountPercentage/100))) * $noOfUnits;
		} else {
			// base tariff
			$subTotal = $noOfDays * $pricePerUnitPerDay * $noOfUnits;
		}

		$taxAmount = 0;
		$grandTotal = 0;
		switch ($billGstType) { 
			case 'same_state':
				$cgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$sgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$taxAmount = $subTotal * ($gstPercentages['same_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$query = "INSERT INTO bonded_billing_invoice (grn_id, billing_date, period_from, period_to, bill_amount, gst_type, sgst, cgst, tax_payable, grand_total) VALUES ('$grnId', '$billDate', '$fromDateStr', '$toDateStr', '$subTotal', '$billGstType', '$sgst', '$cgst', '$taxAmount', '$grandTotal')";
				break;
			case 'other_state':
				$igst = $subTotal * ($gstPercentages['other_state']/100);
				$taxAmount = $subTotal * ($gstPercentages['other_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$query = "INSERT INTO bonded_billing_invoice (grn_id, billing_date, period_from, period_to, bill_amount, gst_type, igst, tax_payable, grand_total) VALUES ('$grnId', '$billDate', '$fromDateStr', '$toDateStr', '$subTotal', '$billGstType', '$igst', '$taxAmount', '$grandTotal')";
				break;
			case 'union_teritory':
				$ugst = $subTotal * ($gstPercentages['union_teritory']/100);
				$taxAmount = $subTotal * ($gstPercentages['union_teritory']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$query = "INSERT INTO bonded_billing_invoice (grn_id, billing_date, period_from, period_to, bill_amount, gst_type, ugst, tax_payable, grand_total) VALUES ('$grnId', '$billDate', '$fromDateStr', '$toDateStr', '$subTotal', '$billGstType', '$ugst', '$taxAmount', '$grandTotal')";
				break;
			case 'exempt':
				$grandTotal = $subTotal;
				$query = "INSERT INTO bonded_billing_invoice (grn_id, billing_date, period_from, period_to, bill_amount, gst_type, tax_payable, grand_total) VALUES ('$grnId', '$billDate', '$fromDateStr', '$toDateStr', '$subTotal', '$billGstType', '$taxAmount', '$grandTotal')";
				break;
		}

		//$handlingCharges = generateHandlingChargesBill('1',$handlingDescriptions, $handlingAmounts, $handlingGSTTypes, $gstPercentages);

		$output = array();
		if(mysqli_query($dbc, $query)){
			$lastInsertInvoiceId = mysqli_insert_id($dbc);
			$handlingCharges = saveHandlingChargesBill($lastInsertInvoiceId, $handlingDescriptions, $handlingAmounts, $handlingGSTSlabs, $billGstType);
			$finalSubTotal = $subTotal + $handlingCharges['sub_total'];
			$finalTaxPayable = $taxAmount + $handlingCharges['tax_amount'];
			$finalGrandTotal = $grandTotal + $handlingCharges['total_amount'];

			$output = array('infocode' => 'SUCCESS', 'sub_total' => $finalSubTotal, 'tax_payable' => $finalTaxPayable, 'grand_total' => $finalGrandTotal);
		} else {
			$output = array('infocode' => 'failure');
		}
        file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
        return $output;
	}

?>