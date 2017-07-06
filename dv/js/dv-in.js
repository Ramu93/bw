var g_rowcount=2;
var g_snocount=2;
var g_itemslist = new Array;
var additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><input type="text" name="item_name[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="item_qty[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="assessabe_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="duty_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="insurance_value[]" placeholder="" class="form-control" value=""></td>\
							<td>\
							<select name="container_number[]" id="container_number_select" class="form-control">\
							</select>\
							</td>\
							<td><button onclick="additemrow([addcount]);">+</button><button class="item_removebutton" style="display:none;" onclick="removeitemrow([removecount])">-</button></td></tr>';

function submitDocumentVerification(){
	if($('#document_verification_form').valid()){
		setValueBasedOnCheckBox();
		var data = $('#document_verification_form').serialize() + '&action=submit_verification';
		//alert(data);
		$.ajax({
			url: "dv-in-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'DOCUMENTVERIFICATIONSUCCESS'){
					bootbox.alert(result.message,function(){
						window.location='dv-in-view.php';	
					});
				} else if(result.infocode == 'DOCUMENTNOTVERIFIED') {
					bootbox.alert(result.message,function(){
						window.location='dv-in-view.php';	
					});
				}		
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function setValueBasedOnCheckBox(){

	if($('#weight_check').is(":checked")){
		$('#weight_text').val('yes');
	} else {
		$('#weight_text').val('no');
	}
	
	if($('#no_of_packages_check').is(":checked")){
		$('#no_of_packages_text').val('yes');
	} else {
		$('#no_of_packages_text').val('no');
	}
	
	if($('#description_check').is(":checked")){
		$('#description_text').val('yes');
	} else {
		$('#description_text').val('no');
	}

	if($('#invoice_copy_check').is(":checked")){
		$('#invoice_copy_text').val('yes');
	} else {
		$('#invoice_copy_text').val('no');
	}
	
	if($('#packing_list_check').is(":checked")){
		$('#packing_list_text').val('yes');
	} else {
		$('#packing_list_text').val('no');
	}
	
	if($('#boe_copy_check').is(":checked")){
		$('#boe_copy_text').val('yes');
	} else {
		$('#boe_copy_text').val('no');
	}
	
	if($('#bond_order_check').is(":checked")){
		$('#bond_order_text').val('yes');
	} else {
		$('#bond_order_text').val('no');
	}
	
	if($('#do_verification_check').is(":checked")){
		$('#do_verification_text').val('yes');
	} else {
		$('#do_verification_text').val('no');
	}
}

function getSelectedtContainerData(){
	var sacParTable = $('#sac_par_table').val();
	var sacParID = $('#sac_par_id').val();
	var data = 'sac_par_table=' + sacParTable + "&sac_par_id=" + sacParID + '&action=get_container_data';
	//alert(data);
	$.ajax({
		url: "dv-in-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){	
			if(result.infocode == 'CONTAINERDATAFETCHSUCCESS'){
				var containers = result.data;
				//displayContainerData(containers);
				displayContainerNumbersInItemModal(containers);
			}
		},
		error: function(){} 	        
	});
}

function displayContainerNumbersInItemModal(containers){
	//parse the container data
	containers = JSON.parse(containers);

	//push all the container numbers (belonging to different dimensions) in one array.
	var containerNumberArray = new Array;
	for(var i=0; i < containers.length; i++){
		//parse the stringified container_details
		containers[i].container_details = JSON.parse(containers[i].container_details);
		for(index = 0; index < Object.keys(containers[i].container_details).length; index++){
			containerNumberArray.push((containers[i].container_details)[index].container_number);
		}
	}

	var dp = '';
	dp += '<option value="">Select container number...</option>';
	containerNumberArray.forEach( function(element, index) {
		dp += '<option value="' + element + '">' + element + '</option>';
	});

	$('#container_number_select').html(dp);

	//change add_item template for adding select input for container numbers
	additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><input type="text" name="item_name[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="item_qty[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="assessabe_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="duty_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="insurance_value[]" placeholder="" class="form-control" value=""></td>\
							<td>\
							<select name="container_number[]" id="container_number_select" class="form-control">\
							<option value="">Select container number...</option>';
	containerNumberArray.forEach( function(element, index) {
		additem_template += '<option value="' + element + '">' + element + '</option>';
	});
	additem_template +=	'</select>\
							</td>\
							<td><button onclick="additemrow([addcount]);">+</button><button class="item_removebutton" style="display:none;" onclick="removeitemrow([removecount])">-</button></td></tr>';
}

function displayContainerData(containers){
	var dp = '';
	
	dp += '<table class="table"><thead><tr><th>Select</th><th>Dimension</th><th>Container Count</th><th>Container Number</th></tr></thead><tbody id="addcontainer_tbody">';
	containers = JSON.parse(containers);
	
	for(var i=0; i < containers.length; i++){
		dp += '<tr><td><input type="checkbox" value="' + containers[i].container_info_id + '" name="container_info_id[]" ></td>';
		dp += '<td><input type="text" disabled="true" name="dimension[]" class="form-control" value="' + containers[i].dimension + '"></td>';
		dp += '<td><input type="text" name="container_count[]" class="form-control" value="' + containers[i].container_count + '"></td>';
		
		//parse the stringified object
		containers[i].container_details = JSON.parse(containers[i].container_details);
		dp += '<td>';
			dp += '<select name="container_number[]" class="form-control">';
				dp += '<option value="">Select container number...</option>';
				for(index = 0; index < Object.keys(containers[i].container_details).length; index++){
					var containerNumber = (containers[i].container_details)[index].container_number;
					dp += '<option value="'+containerNumber+'">'+containerNumber+'</option>';
				}
			dp += '</select>';
		dp += '</td>';

	}
	dp += '</tbody></table>';
	$('#container_data_div').html(dp);
}

var g_rowcount=2;
var g_snocount=2;
function additemrow(rowcount){
	var addrow = additem_template.replace('[trid]','itemtr_'+g_rowcount)
								.replace('[sno]',g_snocount)
								.replace('[addcount]',g_rowcount)
								.replace('[removecount]',g_rowcount)
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
