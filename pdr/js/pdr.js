function getBondOrderList(){
	$('#data_fetch_message').html('');
	var data = "&action=get_bond_order_list";
	
	$.ajax({
		url: "pdr-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "DATAFETCHSUCCESS"){
				var viewListData = result.data;
				var dp = '';
				for(c=0;c<viewListData.length;c++){
					dp += '<tr><td>'+(c+1)+'</td><td>'+viewListData[c].bond_number+'</td><td><button class="btn btn-primary" type="button" onclick="getDataDetails(\''+viewListData[c].do_ver_id+'\',\''+viewListData[c].bond_number+'\');">Select</button></td></tr>';
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

function getDataDetails(dvId, bondNumber){
	//alert('data req');
	$('#bond_number').val(bondNumber);
	$('#view_list_modal').modal('hide');
	$('#data_fetch_message').html('Data fetched successfully').fadeIn(400).fadeOut(2000);
	$('#ju_id').val(dvId);
	var selectType = $('#select_by_type').val();
	var data = 'dv_id=' + dvId + '&action=get_selected_data_details';
	//alert(data)
	$.ajax({
		url: "pdr-services.php",
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
				if(tableName == 'sac'){
					id_head = 'SAC ID:';
				} else {
					id_head = 'PAR ID:';
				}

				$('#sac_par_table').val(tableName);
				$('#sac_par_id').val(id);

				$('#sac_par_table_label').html(id_head);
				$('#sac_par_id').html(id);

				$('#fields').show();
				$('#create_pdr_btn').show();			}
		},
		error: function(){
			alert('error');
		} 	        
	});
}