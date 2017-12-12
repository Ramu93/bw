<?php 
	require('../dbconfig.php');
	require('../dbwrapper_mysqli.php');
	require('../../assets/fpdf/fpdf.php');

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
		$query = "SELECT * FROM bonded_party_master WHERE pm_customerName='$partyName'";
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
		$query = "SELECT * FROM bonded_party_master WHERE pm_customerName='$partyName'";
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

	function getUnitDetails($grnId, $fromDate){
		global $dbc;
		$query = "SELECT unit, no_of_units FROM bonded_grn_log WHERE grn_id='$grnId' and grn_date <= '$fromDate' ORDER BY grn_date DESC LIMIT 1";
        // file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$unitDetails = array('no_of_units' => $row['no_of_units'], 'unit' => $row['unit']);
		return $unitDetails;
	}

	function getTariffMasterId($unit){
		global $dbc;
		$query = "SELECT tariff_master_id FROM bonded_tariff_master WHERE unit='$unit'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$tariffMasterId = $row['tariff_master_id'];
		return $tariffMasterId;
	}

	function getBaseTariffData($tariffMasterId){
		global $dbc;
		$query = "SELECT * FROM bonded_tariff_master WHERE tariff_master_id='$tariffMasterId'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$tariff = array('price_per_unit' => $row['price_per_unit'], 'minimum_slab' => $row['minimum_slab']);
		return $tariff;
	}

	function getDiscountTariff($customerPartyId, $chaPartyId, $tariffMasterId){
		global $dbc; 
		$query = "SELECT * FROM bonded_discount_master WHERE customer_pm_id='$customerPartyId' AND cha_pm_id='$chaPartyId' AND tariff_master_id='$tariffMasterId'";
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

	function generateHandlingChargesBill($descriptions, $amounts, $gstSlabs, $gstType, $billArray){
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

			$billArray[] = $description . ' - ' . $gstSlabs[$i] . '% GST on ₹' . $amount . ': ₹' . $taxAmount;

			$finalSubTotal += $amount;
			$finalTaxAmount += $taxAmount;
			$finalTotalAmount += $totalAmount;
        	//file_put_contents("testlog.log", print_r($query, true), FILE_APPEND | LOCK_EX);
		}

        //file_put_contents("testlog.log", print_r($billArray, true), FILE_APPEND | LOCK_EX);

		return $billArray;
	}

	function isCurrentInvoiceDateGreaterThanOrEqualToPrevious($currentInvoiceDate){
		global $dbc;
		$query = "SELECT billing_date FROM bonded_billing_invoice ORDER BY bill_id DESC LIMIT 1";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
		$previousBillDate = strtotime($row['billing_date']);
		$currentBillingDate = strtotime($currentInvoiceDate);
		if($currentBillingDate >= $previousBillDate){
			return true;
		} else {
			return false;
		}
	}

	function generateBill(){
		global $dbc; 
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$billDate = mysqli_real_escape_string($dbc, trim($_POST['bill_date']));
		$fromDateStr = mysqli_real_escape_string($dbc, trim($_POST['from_date']));
		$toDateStr = mysqli_real_escape_string($dbc, trim($_POST['to_date']));
		$isBillingFirst = $_POST['is_billing_first'];
		$billGstType = 'same_state';
		$handlingDescriptions = $_POST['description'];
		$handlingAmounts = $_POST['amount'];
		$handlingGSTSlabs = $_POST['gst_slab'];

		$gstValues = json_decode($_POST['gst_values']);
		$gstPercentages = array();
  		$gstPercentages = json_decode(json_encode($gstValues), True);

        //file_put_contents("testlog.log", print_r($gstPercentages, true), FILE_APPEND | LOCK_EX);

		$unitDetails = getUnitDetails($grnId, $fromDateStr);
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

		//if billing first for the GRN then value is 30 else value is noOfDays
		if($isBillingFirst == 'true'){
			if($noOfDays < 28){
				$noOfDays = 28;
			}
		}
		
		if($discountDetails['row_count'] > 0){
			//discounted price
			$subTotal = $noOfDays * ($pricePerUnitPerDay - ($pricePerUnitPerDay * ($discountPercentage/100))) * $noOfUnits;
		} else {
			// base tariff
			$subTotal = $noOfDays * $pricePerUnitPerDay * $noOfUnits;
		}

		$billArray = array();
		$taxAmount = 0;
		$grandTotal = 0;
		switch ($billGstType) { 
			case 'same_state':
				$cgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$sgst = $subTotal * (($gstPercentages['same_state']/2)/100);
				$taxAmount = $subTotal * ($gstPercentages['same_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$gstPercentage = $gstPercentages['same_state']/2;
				$taxAmount = $taxAmount / 2; // for displaying CGST & IGST seperately
				$billArray[] = "Storage - {$gstPercentage}% CGST on ₹{$subTotal}: ₹{$taxAmount}";
				$billArray[] = "Storage - {$gstPercentage}% SGST on ₹{$subTotal}: ₹{$taxAmount}";
				break;
			case 'other_state':
				$igst = $subTotal * ($gstPercentages['other_state']/100);
				$taxAmount = $subTotal * ($gstPercentages['other_state']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$gstPercentage = $gstPercentages['other_state'];
				$billArray[] = "Storage - {$gstPercentage}% IGST on ₹{$subTotal}: ₹{$taxAmount}";
				break;
			case 'union_teritory':
				$ugst = $subTotal * ($gstPercentages['union_teritory']/100);
				$taxAmount = $subTotal * ($gstPercentages['union_teritory']/100); 
				$grandTotal = $subTotal + $taxAmount;
				$gstPercentage = $gstPercentages['union_teritory'];
				$billArray[] = "Storage - {$gstPercentage}% UGST on ₹{$subTotal}: ₹{$taxAmount}";
				break;
			case 'exempt':
				$grandTotal = $subTotal;
				break;
		}

		//$handlingCharges = generateHandlingChargesBill('1',$handlingDescriptions, $handlingAmounts, $handlingGSTTypes, $gstPercentages);

		$output = array();
		$finalBillArray = generateHandlingChargesBill($handlingDescriptions, $handlingAmounts, $handlingGSTSlabs, $billGstType, $billArray);
		// $finalSubTotal = $subTotal + $handlingCharges['sub_total'];
		// $finalTaxPayable = $taxAmount + $handlingCharges['tax_amount'];
		// $finalGrandTotal = $grandTotal + $handlingCharges['total_amount'];

		if(isCurrentInvoiceDateGreaterThanOrEqualToPrevious($billDate)){
			$output = array('infocode' => 'SUCCESS', 'data' => $finalBillArray);
		} else {
			$output = array('infocode' => 'FAILURE', 'message' => 'There exists an invoice whose date is greater than the entered one. Plrease try again!');
		}
	
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
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, sgst, cgst, tax_payable, total, service_type) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$sgst', '$cgst', '$taxAmount', '$totalAmount', 'vas')";
					break;
				case 'other_state':
					$igst = $taxAmount;
					$totalAmount =  $amount + $taxAmount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, igst, tax_payable, total, service_type) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$igst', '$taxAmount', '$totalAmount', 'vas')";
					break;
				case 'union_teritory':
					$ugst = $taxAmount;
					$totalAmount =  $amount + $taxAmount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, ugst, tax_payable, total, service_type) VALUES ('$invoiceId', '$description', '$amount', '$gstType', '$ugst', '$taxAmount', '$totalAmount', 'vas')";
					break;
				case 'exempt':
					$totalAmount =  $amount;
					$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, description, amount, gst_type, tax_payable, total, service_type) VALUES ('$invoiceId', '$description', '$amount', '$gstType','$taxAmount', '$totalAmount', 'vas')";
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

	function saveStorageCharges($invoiceId, $storageDetails){
		global $dbc; 
		$amount = $storageDetails['amount'];
		$gstType = $storageDetails['gst_type'];
		$taxAmount = $storageDetails['tax_payable'];
		$totalAmount = $storageDetails['total'];
		switch ($gstType) {
			case 'same_state':
				$cgst = $storageDetails['cgst'];
				$sgst = $storageDetails['sgst'];
				$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, amount, gst_type, sgst, cgst, tax_payable, total, service_type) VALUES ('$invoiceId', '$amount', '$gstType', '$sgst', '$cgst', '$taxAmount', '$totalAmount', 'storage')";
				break;
			case 'other_state':
				$igst = $storageDetails['igst'];
				break;$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, amount, gst_type, igst, tax_payable, total, service_type) VALUES ('$invoiceId', '$amount', '$gstType', '$igst', '$taxAmount', '$totalAmount', 'storage')";
			case 'union_teritory':
				$ugst = $storageDetails['ugst'];
				break;$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, amount, gst_type, ugst, tax_payable, total, service_type) VALUES ('$invoiceId', '$amount', '$gstType', '$ugst', '$taxAmount', '$totalAmount', 'storage')";
			case 'exempt':
				break;$query = "INSERT INTO bonded_billing_invoice_details (invoice_id, amount, gst_type, tax_payable, total, service_type) VALUES ('$invoiceId', '$amount', '$gstType', '$taxAmount', '$totalAmount', 'storage')";
		}
		mysqli_query($dbc, $query);
	}


	function saveBill(){
		global $dbc; 
		$grnId = mysqli_real_escape_string($dbc, trim($_POST['grn_id']));
		$billDate = mysqli_real_escape_string($dbc, trim($_POST['bill_date']));
		$fromDateStr = mysqli_real_escape_string($dbc, trim($_POST['from_date']));
		$toDateStr = mysqli_real_escape_string($dbc, trim($_POST['to_date']));
		$isBillingFirst = $_POST['is_billing_first'];
		$billGstType = 'same_state';
		$handlingDescriptions = $_POST['description'];
		$handlingAmounts = $_POST['amount'];
		$handlingGSTSlabs = $_POST['gst_slab'];

		$gstValues = json_decode($_POST['gst_values']);
		$gstPercentages = array();
  		$gstPercentages = json_decode(json_encode($gstValues), True);

        //file_put_contents("testlog.log", print_r($gstPercentages, true), FILE_APPEND | LOCK_EX);

		$unitDetails = getUnitDetails($grnId, $fromDateStr);
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

		//if billing first for the GRN then value is 30 else value is noOfDays
		if($isBillingFirst == 'true'){
			if($noOfDays < 28){
				$noOfDays = 28;
			}
		}
		
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
		if(isCurrentInvoiceDateGreaterThanOrEqualToPrevious($billDate)){
			if(mysqli_query($dbc, $query)){
				$lastInsertInvoiceId = mysqli_insert_id($dbc);
				$storageDetails = array();
				$storageDetails['amount'] = $subTotal;
				$storageDetails['gst_type'] = $billGstType;
				$storageDetails['tax_payable'] = $taxAmount;
				$storageDetails['total'] = $grandTotal;
				switch ($billGstType) {
					case 'same_state':
						$storageDetails['sgst'] = $sgst;
						$storageDetails['cgst'] = $cgst;
						break;
					case 'other_state':
						$storageDetails['igst'] = $igst;
						break;
					case 'union_teritory':
						$storageDetails['iugst'] = $ugst;
						break;
					case 'exempt':
						break;
				}
				$handlingCharges = saveHandlingChargesBill($lastInsertInvoiceId, $handlingDescriptions, $handlingAmounts, $handlingGSTSlabs, $billGstType);
				saveStorageCharges($lastInsertInvoiceId, $storageDetails);
				updateTotalBillValues($lastInsertInvoiceId);
				generatePdfBill($lastInsertInvoiceId, $billGstType, $gstPercentages);
				$finalSubTotal = $subTotal + $handlingCharges['sub_total'];
				$finalTaxPayable = $taxAmount + $handlingCharges['tax_amount'];
				$finalGrandTotal = $grandTotal + $handlingCharges['total_amount'];

				$output = array('infocode' => 'SUCCESS', 'sub_total' => $finalSubTotal, 'tax_payable' => $finalTaxPayable, 'grand_total' => $finalGrandTotal, 'file_name' => 'Invoice-'.$lastInsertInvoiceId);
			} else {
				$output = array('infocode' => 'failure');
			}
		} else {
			$output = array('infocode' => 'FAILURE', 'message' => 'There exists an invoice whose date is greater than the entered one. Plrease try again!');
		}
		
        //file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
        return $output;
	}

	function getSumInvoiceDetailsSumValues($invoiceId){
		global $dbc;
		$query = "SELECT sum(amount) as 'amount', sum(sgst) as 'sgst', sum(cgst) as 'cgst', sum(igst) as'igst', sum(ugst) as 'ugst', sum(tax_payable) as 'tax_payable', sum(total) as 'total' FROM bonded_billing_invoice_details WHERE invoice_id='$invoiceId'";
		$result = mysqli_query($dbc, $query);
		$row = mysqli_fetch_assoc($result);
        // file_put_contents("testlog.log", print_r($row, true), FILE_APPEND | LOCK_EX);
		return $row;
	}

	function updateTotalBillValues($invoiceId){
		global $dbc;
		$invoiceSumValues = getSumInvoiceDetailsSumValues($invoiceId);
		$amount = $invoiceSumValues['amount'];
		$sgst = $invoiceSumValues['sgst'];
		$cgst = $invoiceSumValues['cgst'];
		$igst = $invoiceSumValues['igst'];
		$ugst = $invoiceSumValues['ugst'];
		$taxPayable = $invoiceSumValues['tax_payable'];
		$total = $invoiceSumValues['total'];
		$query = "UPDATE bonded_billing_invoice SET bill_amount='$amount', sgst='$sgst', cgst='$cgst', igst='$igst', ugst='$ugst', tax_payable='$taxPayable', grand_total='$total' WHERE bill_id='$invoiceId'";
        // file_put_contents("testlog.log", $query, FILE_APPEND | LOCK_EX);
		mysqli_query($dbc, $query);
	}

	function generatePdfBill($invoiceId, $billGstType, $gstPercentages){
		global $dbc;
		$invoiceQuery = "SELECT billing.bill_id, billing.billing_date, billing.period_from, billing.period_to, billing.bill_amount, billing.gst_type, billing.sgst, billing.cgst, billing.igst, billing.ugst, billing.grand_total, billing.tax_payable, sac.sac_id, sac.importing_firm_name, sac.cha_name, sac.bol_awb_number, sac.bol_awb_date, sac.boe_number, sac.boe_date, dv.bond_number, dv.bond_date, pdr.client_web, pdr.created_date as 'delivery_date', sac.qty_units, sac.material_name, (SELECT grnlog.no_of_units FROM bonded_grn_log grnlog WHERE grnlog.grn_id=grn.grn_id ORDER BY grnlog.grn_date DESC LIMIT 1) as 'no_of_units', (SELECT grnlog.unit FROM bonded_grn_log grnlog WHERE grnlog.grn_id=grn.grn_id ORDER BY grnlog.grn_date DESC LIMIT 1) as 'unit_name' FROM bonded_billing_invoice billing, bonded_good_receipt_note grn, sac_request sac, bonded_dv_inward dv, bonded_despatch_request pdr, bonded_good_delivery_note gdn WHERE bill_id='$invoiceId' AND billing.grn_id=grn.grn_id AND grn.sac_id=sac.sac_id AND sac.sac_id=dv.sac_id AND sac.sac_id=pdr.sac_id AND pdr.pdr_id=gdn.pdr_id LIMIT 1";
		$invoiceResult = mysqli_query($dbc, $invoiceQuery);
		$invoiceRow = mysqli_fetch_assoc($invoiceResult);
		$invoiceDetailsQuery = "SELECT * FROM bonded_billing_invoice_details WHERE invoice_id='$invoiceId' ORDER BY service_type";
		$invoiceDetailsResult = mysqli_query($dbc, $invoiceDetailsQuery);
		$invoiceDetails = array();
		while($invoiceDetailsRow = mysqli_fetch_assoc($invoiceDetailsResult)){
			$invoiceDetails[] = $invoiceDetailsRow;
		}
		$tariffMasterQuery = "SELECT * FROM bonded_tariff_master WHERE unit='".$invoiceRow['unit_name']."'";
		$tariffResult = mysqli_query($dbc, $tariffMasterQuery);
		$tariffRow = mysqli_fetch_assoc($tariffResult);
		$invoiceRow['price_per_unit'] = $tariffRow['price_per_unit'];
		//format date
		$invoiceRow['billing_date'] = date_format(date_create($invoiceRow['billing_date']), 'd-m-Y');
		$invoiceRow['bond_date'] = date_format(date_create($invoiceRow['bond_date']), 'd-m-Y');
		$invoiceRow['boe_date'] = date_format(date_create($invoiceRow['boe_date']), 'd-m-Y');
		$invoiceRow['delivery_date'] = date_format(date_create($invoiceRow['delivery_date']), 'd-m-Y');

		$periodFrom = date_create($invoiceRow['period_from']);
		$periodTo = date_create($invoiceRow['period_to']);
		$dateIntervalObj = date_diff($periodTo, $periodFrom);
		$noOfDays = $dateIntervalObj->d;
		$invoiceRow['weeks'] = ceil($noOfDays/7);
		$periodFrom = date_format($periodFrom, 'd-m-Y');
		$periodTo = date_format($periodTo, 'd-m-Y');

        // file_put_contents("testlog.log", print_r($invoiceRow, true), FILE_APPEND | LOCK_EX);
        // file_put_contents("testlog.log", print_r($invoiceDetails, true), FILE_APPEND | LOCK_EX);


		$pdf = new FPDF();
		$pdf->AddPage();
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetMargins(1,1);
		$pdf->SetLineWidth(0.5);
		$pdf->Rect(10, 10, 190, 275, 'D');
		$leftMarginStart = 10;

		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(190,10,"Thiru Rani Logistics Private Limitted",0,2,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(190,5,"Customs Public Bonded Warehouse - C068 / MAA1U013",0,2,'C');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(190,5,"No 1, New North, 200 Ft Road, Madhavaram, Chennai - 600 110",0,2,'C');
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(95,5,"Phone No.: +91 98410 77558",0,0,'L');
		$pdf->Cell(95,5,"Email: mktgbond@trlpl.com",0,1,'R');
		$pdf->Cell(190,0,"",0,2);

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(190,10,"INVOICE",1,2,'C');
		
		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(95,5,"To",0,0,'L');
		$pdf->Cell(40,5,"Invoice No.",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,"TMT/".$invoiceId,0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(95,5,$invoiceRow['cha_name'],0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Invoice Date",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,$invoiceRow['billing_date'],0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(95,5,"Rajah Annamalai Building, Annexe 3rd Floor,",0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Financial Year",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,"2017-18",0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(95,5,"18/3, Rukhmani Lakshmipathy Road, Egmore.",0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Bond No. & Date",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,$invoiceRow['bond_number'].' & '.$invoiceRow['bond_date'],0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,"GSTIN",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,5,"33AACCT5483F1ZD",0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"BOE No. & Date",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,$invoiceRow['boe_number'].' & '.$invoiceRow['boe_date'],0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,"TAN",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,5,"",0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"WH Operation",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,$invoiceRow['client_web'],0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,"Importer Name",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,5,$invoiceRow['importing_firm_name'],0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Delivery Date",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,$invoiceRow['delivery_date'],0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,"Description",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,5,$invoiceRow['material_name'],0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"",0,0,'L');
		$pdf->Cell(5,5,"",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,"",0,1);

		//row
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,"Quantity",0,0,'L');
		$pdf->Cell(5,5,":",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,5,$invoiceRow['qty_units'],0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"",0,0,'L');
		$pdf->Cell(5,5,"",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(55,5,"",0,1);


		//these values also present in drawVerticalLine($y, $pdf) method
		$sNoWidth = 15;
		$particularsWidth = 74;
		$areaWidth = 25;
		$rateWidth = 28;
		$periodWidth = 25;
		$totalWidth = 23;
		$cellHeight = 5;
		$pageWidth = 190;

		//heading
		$pdf->SetX($leftMarginStart);
		$y =  $pdf->GetY();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell($sNoWidth,10,"S. No.",1,0,'C');
		$pdf->SetXY(25, $y);
		$pdf->Cell($particularsWidth,10,"Particulars",1,0,'C');
		$pdf->SetXY(99, $y);
		$pdf->MultiCell(25,$cellHeight,"Area / Value / Container",1);
		$pdf->SetXY(124, $y);
		$pdf->Cell($rateWidth,10,"Rate(INR)",1,0,'C');
		$pdf->SetXY(152, $y);
		$pdf->Cell($periodWidth,10,"Period",1,0,'C');
		$pdf->SetXY(177, $y);
		$pdf->Cell($totalWidth,10,"Total(INR)",1,1,'C');
			
		$y += 10;
		$invoiceDetailsLength = count($invoiceDetails);
		for($i = 0; $i < $invoiceDetailsLength; $i++){
			$count = $i + 1;
			if($invoiceDetails[$i]['service_type'] == 'storage'){
				//row
				$pdf->SetXY($leftMarginStart, $y);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($sNoWidth,$cellHeight,$count,0,0,'C');
				$pdf->SetFont('Arial','BU',10);
				$pdf->Cell($particularsWidth,$cellHeight,"Storage Charges",0,0);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($areaWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($rateWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($periodWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($totalWidth,$cellHeight,"",0,1,'C');
				drawVerticalLine($y, $pdf);
				
				//row
				$y += $cellHeight;
				$pdf->SetXY($leftMarginStart, $y);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($sNoWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($particularsWidth,$cellHeight,"Area Reserved: ".$invoiceRow['no_of_units']." ".$invoiceRow['unit_name'],0,0);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($areaWidth,$cellHeight,$invoiceRow['no_of_units']." ".$invoiceRow['unit_name'],0,0,'C');
				$pdf->Cell($rateWidth,$cellHeight,$invoiceRow['price_per_unit']." per ".$invoiceRow['unit_name'],0,0,'C');
				$pdf->Cell($periodWidth,$cellHeight,$invoiceRow['weeks']." weeks",0,0,'C');
				$pdf->Cell($totalWidth,$cellHeight,round(floatval($invoiceDetails[$i]['amount']), 2),0,1,'C');
				drawVerticalLine($y, $pdf);

				//row
				$y += $cellHeight;
				$pdf->SetXY($leftMarginStart, $y);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($sNoWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($particularsWidth,$cellHeight,"",0,0);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($areaWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($rateWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($periodWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($totalWidth,$cellHeight,"",0,1,'C');
				drawVerticalLine($y, $pdf);

				//row
				$y += $cellHeight;
				$pdf->SetXY($leftMarginStart, $y);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($sNoWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($particularsWidth,$cellHeight,"(From ".$periodFrom." to ".$periodTo.")",0,0);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($areaWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($rateWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($periodWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($totalWidth,$cellHeight,"",0,1,'C');
				drawVerticalLine($y, $pdf);
			} else if($invoiceDetails[$i]['service_type'] == 'vas'){
				$pdf->SetXY($leftMarginStart, $y);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($sNoWidth,$cellHeight,$count,0,0,'C');
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell($particularsWidth,$cellHeight,$invoiceDetails[$i]['description'],0,0);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell($areaWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($rateWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($periodWidth,$cellHeight,"",0,0,'C');
				$pdf->Cell($totalWidth,$cellHeight,$invoiceDetails[$i]['amount'],0,1,'C');
				drawVerticalLine($y, $pdf);
			}
			$y += $cellHeight;
			drawVerticalLine($y, $pdf);
			if($i != $invoiceDetailsLength-1){
				$y += $cellHeight;
				drawVerticalLine($y, $pdf);
			}
		}
		$y += $cellHeight;
		$pdf->Line($leftMarginStart, $y, 200, $y);

		switch($billGstType){
			case 'same_state':
				$cgst = $invoiceRow['cgst'];
				$sgst = $invoiceRow['sgst'];
				$igst = 0;
				$totalAmount = $invoiceRow['grand_total'] - ($cgst + $sgst);
				break;
			case 'other_state':
				$cgst = 0;
				$sgst = 0;
				$igst = $invoiceRow['igst'];
				$totalAmount = $invoiceRow['grand_total'] - $igst;
				break;
		}

		//$y += $cellHeight;
		$pdf->SetXY($leftMarginStart, $y);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(115,5,"Bank Details",0,0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"Total",0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,$totalAmount,0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"Account Number",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"157150350870009",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"CGST @ ".($gstPercentages['same_state']/2),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,$sgst,0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"Name of Bank",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"Tamil Nadu Merchantile Bank",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"SGST @ ".($gstPercentages['same_state']/2),0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,$sgst,0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"Branch",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"Perambur",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"IGST @ ".$gstPercentages['other_state'],0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,$igst,0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"IFSC Code",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"TMBL0000157",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"Grand Total",0,0,'L');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(40,5,round($invoiceRow['grand_total']),0,1,'R');

		$numberToWords = new NumberFormatter("en", NumberFormatter::SPELLOUT);
		$grandTotalInWords = $numberToWords->format(round($invoiceRow['grand_total']));
		$grandTotalInWords = 'Total invoice amount in words: ' . ucfirst($grandTotalInWords) . ' only/-';
		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(190,10,$grandTotalInWords,1,2,'C');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"GST No.",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"33AABCT8023G1ZM",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"PAN No. :",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(40,5,"AABCT8023G",0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"CIN No.",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"U63090TN2002PTC049504",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"TAN No. :",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(40,5,"CHET06202A",0,1,'R');

		$pdf->SetX($leftMarginStart);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"SERVICE TYPE",0,0,'L');
		$pdf->Cell(10,5,":",0,0,'L');
		$pdf->Cell(70,5,"Other Storage and Warehousing Services",0,0,'');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,"SERVICE CODE :",0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(40,5,"996729",0,1,'R');

		$y = $pdf->GetY() + $cellHeight;
		$pdf->Line($leftMarginStart, $y, 200, $y);

		//$pdf->Output("Invoice-.pdf", "F");
		$pdf->Output("Invoice-".$invoiceId.".pdf", "F");
	}

	function drawVerticalLine($y, $pdf){
		$leftMarginStart = 10;
		$sNoWidth = 15;
		$particularsWidth = 74;
		$areaWidth = 25;
		$rateWidth = 28;
		$periodWidth = 25;
		$totalWidth = 23;
		$cellHeight = 5;

		$x1 = $leftMarginStart + $sNoWidth;
		$x2 = $leftMarginStart + $sNoWidth;
		$y1 = $y;
		$y2 = $y + $cellHeight;
		$pdf->Line($x1, $y1, $x2, $y2); 
		$x1 = $leftMarginStart + $sNoWidth + $particularsWidth;
		$x2 = $leftMarginStart + $sNoWidth + $particularsWidth;
		$y1 = $y;
		$y2 = $y + $cellHeight;
		$pdf->Line($x1, $y1, $x2, $y2); 
		$x1 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth;
		$x2 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth;
		$y1 = $y;
		$y2 = $y + $cellHeight;
		$pdf->Line($x1, $y1, $x2, $y2); 
		$x1 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth + $rateWidth;
		$x2 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth + $rateWidth;
		$y1 = $y;
		$y2 = $y + $cellHeight;
		$pdf->Line($x1, $y1, $x2, $y2); 
		$x1 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth + $rateWidth + $periodWidth;
		$x2 = $leftMarginStart + $sNoWidth + $particularsWidth + $areaWidth + $rateWidth + $periodWidth;
		$y1 = $y;
		$y2 = $y + $cellHeight;
		$pdf->Line($x1, $y1, $x2, $y2); 
	}

?>