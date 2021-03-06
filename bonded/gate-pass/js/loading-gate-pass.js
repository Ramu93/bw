$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);

function setTime(){
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	// add a zero in front of numbers<10
	m = checkTime(m);
	s = checkTime(s);
	return h + ":" + m + ":" + s;
}

function checkTime(i) {
	if (i < 10) {
	i = "0" + i;
	}
	return i;
}

function setDate()
{
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();

	if (month < 10) month = "0" + month;
	if (day < 10) day = "0" + day;

	var today = day + "-" + month + "-" + year;
	return today;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function changeLabelText(){
	var selectType = $('#select_by_type').val();
	switch (selectType) {
		//for column name
		case 'pdr_id':
			$('#fetch_by_label').html('PDR ID');
		break;
		case 'boe_number':
			$('#fetch_by_label').html('BOE Number');
		break;
		case 'bond_number':
			$('#fetch_by_label').html('Bond Number');
		break;
	}
}

function getDataList(){
	$('#data_fetch_message').html('');
	var selectType = $('#select_by_type').val();
	var data = "data_type=" + selectType + "&action=get_list";
	//alert(data);
	switch (selectType) {
		//for column name
		case 'pdr_id':
			$('#data_name').html('PDR ID');
			$('#modal_title').html('Select Approved PDR ID'); // modal title
		break;
		case 'boe_number':
			$('#data_name').html('BOE Number');
			$('#modal_title').html('Select Approved BOE Number');
		break;
		case 'bond_number':
			$('#data_name').html('Bond Number');
			$('#modal_title').html('Select Approved Bond Number');
		break;
	}
	
	$.ajax({
		url: "loading-gate-pass-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "DATAFETCHSUCCESS"){
				var viewListData = result.data;
				var dp = '';
				for(c=0;c<viewListData.length;c++){
					dp += '<tr><td>'+(c+1)+'</td><td>'+viewListData[c].data_item+'</td><td><button class="btn btn-primary" type="button" onclick="getDataDetails(\''+viewListData[c].data_item+'\');">Select</button></td></tr>';
				}
				$('#datalist_tbody').html(dp);
				$('#view_list_modal').modal('show');
			}else{
				$('#datalist_tbody').html('<tr><td colspan="3">There are no approved data waiting to be processed.</td></tr>');
				$('#view_list_modal').modal('show');
			}
		},
		error: function(){} 	        
	});
}

function getDataDetails(dataItem){
	//alert('data req');
	$('#data_item').val(dataItem);
	$('#view_list_modal').modal('hide');
	$('#data_fetch_message').html('Data fetched successfully').fadeIn(400).fadeOut(2000);
	var selectType = $('#select_by_type').val();
	var data = '';
	switch (selectType) {
		//for column name
		case 'pdr_id':
			data += 'data_type=pdr_id';
		break;
		case 'boe_number':
			data += 'data_type=boe_number';
		break;
		case 'bond_number':
			data += 'data_type=bond_number';
		break;
	}
	data += '&data_value=' + dataItem + '&action=get_selected_data_details';
	//alert(data)
	$.ajax({
		url: "loading-gate-pass-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){			
			if(result.infocode == 'DATADETAILFETCHSUCCESS'){
				var selectedData = result.data;
				selectedData = JSON.parse(selectedData)[0];

				$('#pdr_id_label').html(selectedData.pdr_id);
				$('#pdr_id_hidden').val(selectedData.pdr_id);

				$('#bond_number_label').html(selectedData.bond_number);
				$('#boe_number_label').html(selectedData.boe_number);
				$('#client_web_label').html(selectedData.client_web);
				$('#cha_name_label').html(selectedData.cha_name);
				$('#exbond_be_number_label').html(selectedData.exbond_be_number);
				$('#exbond_be_date_label').html(selectedData.exbond_be_date);
				// $('#customs_officer_name_label').html(selectedData.customs_officer_name);

				$('#pdr_data').show();
			}
		},
		error: function(){
			bootbox.alert('error');
		} 	        
	});
}

function generateIGP(){
	if($('#igp-loading-form').valid()){
		var data = $('#igp-loading-form').serialize() + "&action=generate_igp";
		//alert(data);
		$.ajax({
			url: "loading-gate-pass-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.status == 'Success'){
					bootbox.alert(result.message,function(){
						window.location='igp-loading-list-view.php';	
					});
				}
				
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function printData(divName) {
	var printContents = $('#'+divName).html();
	/*var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;*/
	var printWindow = window.open('','','height=400,width=800');
	printWindow.document.write('<html><head><title>Print</title><link href="<?php echo HOMEURL; ?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" /></head><body>'+printContents+'</body></html>');
	printWindow.document.close();
	printWindow.print();
}

function getPDRItemsCount(){
	var pdrId = $('#pdr_id_hidden').val();
	var data = 'pdr_id=' + pdrId + '&action=get_pdr_items_count';
	$.ajax({
		url: "loading-gate-pass-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'ITEMDATAFETCHSUCCESS'){
				//alert(result.data)
				var qty = result.data;
				$('#item_total_qty').html(qty);
			} else {
				bootbox.alert('No item data available.');
			}
		},
		error: function(){} 	        
	});
}


function setVehicleLeftTimeStamp(ogpId){
	var data = 'ogp_lo_id=' + ogpId + '&action=set_vehivle_left_timestamp';
	$.ajax({
		url: "loading-gate-pass-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'success'){
				bootbox.alert(result.message,function(){
					window.location='ogp-loading-list-view.php';	
				});
			}
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}