function getPartyDetails(){
	var partyName = '';

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

function getBillingInfo(grnId){
	var data = 'grn_id=' + grnId + '&action=get_previous_bill';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
	$('#previous_billing_div').show();
	$('#billing_div').show();
}
