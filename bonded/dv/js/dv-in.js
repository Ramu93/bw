var g_rowcount=2;
var g_snocount=2;
var g_itemslist = new Array;
var additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><input type="text" name="item_name[]" placeholder="" class="form-control auto-itemname" autocomplete="on" value=""></td>\
							<td><input type="text" name="item_qty[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="assessabe_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="duty_value[]" placeholder="" class="form-control" value=""></td>\
							<td><input type="text" name="insurance_value[]" placeholder="" class="form-control" value="" readonly></td>\
							<td>\
							<select name="container_number[]" id="container_number_select" class="form-control">\
							</select>\
							</td>\
							<td><button onclick="additemrow([addcount]);">+</button><button class="item_removebutton" style="display:none;" onclick="removeitemrow([removecount])">-</button></td></tr>';

var g_compareBondDate = false;

function submitDocumentVerification(){
	g_compareBondDate = false;
	if($('#document_verification_form').valid()){
		bootbox.confirm('Are you sure, you got all the documents?',function(result){
			if(result){
				compareBondDateWithBoeDate();
				if(g_compareBondDate){
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
				} else {
					bootbox.alert("Bond date is lesser than BOE date. Please renter bond date.");
				}
			}
		});
	}
}

function compareBondDateWithBoeDate(){
	var sacId = $('#sac_id').val();
	var bondDate = $('#bond_date').val();
	var data = 'sac_id=' + sacId + '&bond_date=' + bondDate + '&action=compare_bond_date';
	var result;
	$.ajax({
		async: false, //if not use this line, method will return before the ajax response and value will be false always.
		url: "dv-in-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'GREATER'){
				setCompareVal(true);
			} else if(result.infocode == 'LESSER') {
				setCompareVal(false);
			}		
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
	console.log(g_compareBondDate);
}

function setCompareVal(val){
	g_compareBondDate = val;
}

function setValueBasedOnCheckBox(){

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
	
}

function getSelectedtContainerData(){
	var sacID = $('#sac_id').val();
	var data = "&sac_id=" + sacID + '&action=get_container_data';
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
		//console.log(containers[i].container_details)
		if(containers[i].container_details != null){
			for(index = 0; index < Object.keys(containers[i].container_details).length; index++){
				containerNumberArray.push((containers[i].container_details)[index].container_number);
			}
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
							<td><input type="text" name="insurance_value[]" placeholder="" class="form-control" value="" readonly></td>\
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
	bindAutocomplete();
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

function bindAutocomplete(classname){
	$('.auto-itemname').autocomplete({
		source : "auto-complete-services.php?action=fetch_item_details&type=itemname",
		minLength : 2,
		select : function(event, ui) {
            if(ui.item.value == "No items found"){
            	event.preventDefault();
            }else{
            	var id = $(event.target).attr('id');
            	origid = id.split('_');
            	id = origid[1];
            	alert(id);
            	//$('#itemcode_'+id).val(ui.item.item_master_id);
            }
        },
	});
	
}

function computeInsuranceValue(){
	var assessableValues = new Array();
	var dutyValues = new Array();
	var insuranceValues = new Array();

	$('input[name^="assessabe_value"]').each(function() {
	    assessableValues.push($(this).val());
	});
	$('input[name^="duty_value"]').each(function() {
	    dutyValues.push($(this).val());
	});

	$.each(assessableValues, function( index, assessableValue ) {
	  insuranceValues.push(parseFloat(assessableValue) + parseFloat(dutyValues[index]));
	});

	var index = 0;
	$('input[name^="insurance_value"]').each(function() {
	    $(this).val(insuranceValues[index]);
	    index++;
	});
}
