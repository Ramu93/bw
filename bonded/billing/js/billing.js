function getPartyDetails(partyName){
	var data = 'party_name=' + partyName + '&action=get_party_details';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#party_id_label').html(result.data);
				$('#party_id_hidden').val(result.data);
				$('#party_details_div').show();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function getGRNList(){
	var partyName = $('#party_name').val();
	getPartyDetails(partyName);
	var data = 'party_name=' + partyName + '&action=get_grn_list';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				displayGRNList(result.data);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayGRNList(grnList){
	console.log(grnList);
	var dp = '';
	grnList.forEach( function(grn, index) {
		dp += '<tr>\
					<td>'+ (index+1) +'</td>\
					<td>'+ grn.grn_id +'</td>\
					<td>'+ grn.importing_firm_name +'</td>\
					<td>'+ grn.cha_name +'</td>\
					<td><button type="button" class="btn btn-success" onclick="getBillingInfo('+ grn.grn_id +')" >Select</button></td>\
			  </tr>';
	});
	$('#grn_list_tbody').html(dp);
	$('#grn_table').show();
}

var gGrnId = -1;

function getSelectedGRNInfo(grnId){
	gGrnId = grnId;
	var data = 'grn_id=' + grnId + '&action=get_grn_info';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#grn_id_label').html(result.data.grn_id);
				$('#jul_id_label').html(result.data.ju_id);
				$('#sac_id_label').html(result.data.sac_id);
				$('#selected_grn_div').show();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function getBillingInfo(grnId){
	getSelectedGRNInfo(grnId);
	var data = 'grn_id=' + grnId + '&action=get_previous_bill';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#previous_bill_date_label').html(result.data.billing_date);
				$('#previus_period_label').html(result.data.period_from + ' to ' + result.data.period_to);
				$('#last_bill_amount_label').html('₹ ' + result.data.bill_amount);
				$('#previous_billing_div').show();
				$('#billing_div').show();
				$('#generate_bill_btn').show();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
}

function generateBill(){
	if($('#generate_bill_form').valid()){
		var grnId = gGrnId;
		var billDate = $('#bill_date').val();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();
		var data = 'grn_id=' + grnId + '&bill_date=' + billDate + '&from_date=' + fromDate + '&to_date=' + toDate + '&action=generate_bill'; 
		$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#bill_amount_label').html('₹ ' + result.data); //sub-total 
				$('#total_taxes_label').html();
				$('#grand_total_label').html();
				$('#bill_amount_div').show();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
	}
}
