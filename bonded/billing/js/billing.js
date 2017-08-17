var gCheck = 0; // for checking if both the cha party id and customer party id are filled

function getPartyDetails(type){
	var partyName = '';
	if(type === 'customer'){
		partyName = $('#importing_firm_name').val();
	} else {
		partyName = $('#cha_name').val();
	}

	var data = 'party_name=' + partyName + '&action=get_party_details';
	$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				if(type === 'customer'){
					$('#customer_id_label').html(result.data);
					$('#customer_id_hidden').val(result.data);
					$('#customer_details_div').show();
					gCheck += 1;
				} else {
					$('#cha_id_label').html(result.data);
					$('#cha_id_hidden').val(result.data);
					$('#cha_details_div').show();
					gCheck += 1;
				}

				if(gCheck === 2){
					$('#add_discount_tariff_btn').prop('disabled', '');
					gCheck = 0;
				}
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function getGRNList(){
	var importingFirmName = $('#importing_firm_name').val();
	var chaName = $('#cha_name').val();
	var data = 'importing_firm_name=' + importingFirmName + '&cha_name=' + chaName + '&action=get_grn_list';
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

}
