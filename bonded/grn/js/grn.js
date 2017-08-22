function getJobOrderList(){
	$('#data_fetch_message').html('');
	var data = "&action=get_joborder_list";
	
	$.ajax({
		url: "grn-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "DATAFETCHSUCCESS"){
				var viewListData = result.data;
				var dp = '';
				for(c=0;c<viewListData.length;c++){
					dp += '<tr><td>'+(c+1)+'</td><td>'+viewListData[c].ju_id+'</td><td><button class="btn btn-primary" type="button" onclick="getDataDetails(\''+viewListData[c].ju_id+'\');">Select</button></td></tr>';
				}
				$('#datalist_tbody').html(dp);
				$('#view_list_modal').modal('show');
			}else{
				$('#datalist_tbody').html('<tr><td colspan="3">There are no complted job orders waiting to be processed.</td></tr>');
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
	$('#ju_id').val(dataItem);
	var selectType = $('#select_by_type').val();
	var data = 'data_value=' + dataItem + '&action=get_selected_data_details';
	//alert(data)
	$.ajax({
		url: "grn-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){			
			if(result.infocode == 'DATADETAILFETCHSUCCESS'){
				var selectedData = result.data;
				selectedData = JSON.parse(selectedData);
				var id = selectedData.id;
				var tableName = selectedData.table_name;
				var customerName = selectedData.importing_firm_name;
				//var dimension = selectedData.dimension;
				var id_head = '';
				id_head = 'SAC ID:';

				$('#sac_id').val(id);

				$('#id_label').html(id_head);
				$('#id_value').html(id);
				if(selectType != 'igp'){
					$('#customer_name_label').html('Customer Name:');
					$('#customer_name_value').html(customerName);
				} else {
					$('#customer_name_label').html('');
					$('#customer_name_value').html('');
				}
				$('#licence_code_label').html('Licence Code:');
				$('#licence_code').html(selectedData.licence_code);
				$('#bol_awb_number_label').html('BOL/AWB Number:');
				$('#bol_awb_number').html(selectedData.bol_awb_number);
				$('#boe_number_label').html('BOE Number:');
				$('#boe_number').html(selectedData.boe_number);
				$('#material_nature_label').html('Material Nature:');
				$('#material_nature').html(selectedData.material_nature);
				$('#material_name_label').html('Material Name:');
				$('#material_name').html(selectedData.material_name);
				$('#packing_nature_label').html('Packing Nature:');
				$('#packing_nature').html(selectedData.packing_nature);
				$('#job_order_id').val(dataItem);
				$('#fields').show();
				$('#create_grn_button').show();			}
		},
		error: function(){
			alert('error');
		} 	        
	});
}

function createGRN(){
	if($('#grn_form').valid()){
		var data = $('#grn_form').serialize() + "&action=create_grn";
		//alert(data);
		$.ajax({
			url: "grn-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(data){
				if(data.status == 'success'){
					bootbox.alert(data.message,function(){
						//window.location='job-order-unloading-view.php?ju_id='+sacParId;	//replace with last insert id
					});
				}
				
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function printGRN(divName){
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