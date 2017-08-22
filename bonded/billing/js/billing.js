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
			}
			$('#billing_div').show();
		    $('#handling_charges_div').show();
			$('#generate_bill_btn').show();
			$('#save_bill_btn').show();
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
}

var additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><input type="text" id="description" name="description[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="amount[]" placeholder="" class="form-control" value=""></td>\
							<td><select class="form-control required" id="gst_slab" name="gst_slab[]">\
                              <option value="0">0</option>\
                              <option value="5">5</option>\
                              <option value="12">12</option>\
                              <option value="18">18</option>\
                              <option value="28">28</option>\
                            </select>\
                        	</td>\
							<td><input type="button" class="btn btn-warning" onclick="additemrow([addcount]);" value="+"><input type="button" class="item_removebutton btn btn-danger" onclick="removeitemrow([removecount])" value="-"></td></tr>';


var g_rowcount=2;
var g_snocount=2;
function additemrow(rowcount){
	var gstTypeCombo = '';
	for(var gstType in gstTypes){
        gstTypeCombo += '<option value="'+gstType+'">'+gstTypes[gstType]+'</option>';
    }
	var addrow = additem_template.replace('[trid]','itemtr_'+g_rowcount)
								.replace('[sno]',g_snocount)
								.replace('[addcount]',g_rowcount)
								.replace('[removecount]',g_rowcount)
								.replace('[gsttypes]',gstTypeCombo);
	$('#additem_tbody').append(addrow);
	g_rowcount++;
	g_snocount++;
	$('.item_removebutton').show();
}

function removeitemrow(rowcount){
	$('#itemtr_'+rowcount).remove();
	refreshsnocount();
}

function refreshsnocount(){
	var sillycount = 1;
	$('.td_sno').each(function(d){
		//console.log(d);
		$(this).html(sillycount++);
	});
	g_snocount = sillycount;
	if(sillycount<=2)
		$('.item_removebutton').hide();
}


function generateBill(){
	if($('#generate_bill_form').valid()){
		var grnId = gGrnId;
		var billDate = $('#bill_date').val();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();
		//var data = 'grn_id=' + grnId + '&bill_date=' + billDate + '&from_date=' + fromDate + '&to_date=' + toDate + '&action=generate_bill'; 
		var data = $('#generate_bill_form').serialize() + '&gst_values=' + JSON.stringify(gstValues) + '&grn_id=' + grnId + '&action=generate_bill';
		//console.log(data);
		$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				displayBill(result.data);
				$('#bill_amount_div').show();
			} else {
				bootbox.alert(result.message);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
	}
}

function displayBill(billData){
	var dp = '';
	billData.forEach( function(element, index) {
		dp += '<div class="row">\
	          <div class="form-group" >\
	            <label>'+element+'</label>\
	          </div>\
	        </div>';
	});
	$('#bill_amount_div').html(dp);
}

function saveBill(){
	if($('#generate_bill_form').valid()){
		var grnId = gGrnId;
		var billDate = $('#bill_date').val();
		var fromDate = $('#from_date').val();
		var toDate = $('#to_date').val();
		//var data = 'grn_id=' + grnId + '&bill_date=' + billDate + '&from_date=' + fromDate + '&to_date=' + toDate + '&action=generate_bill'; 
		var data = $('#generate_bill_form').serialize() + '&gst_values=' + JSON.stringify(gstValues) + '&grn_id=' + grnId + '&action=save_bill';
		//console.log(data);
		$.ajax({
		url: "billing-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#bill_amount_label').html('₹ ' + result.sub_total); //sub-total 
				$('#total_taxes_label').html('₹ ' + result.tax_payable);
				$('#grand_total_label').html('₹ ' + result.grand_total);
				$('#bill_amount_div').show();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
	}
}
