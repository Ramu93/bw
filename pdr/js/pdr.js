var gItemList = new Array;
var gItemSelectedCount = 0;

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

function showItemsList(){
	var sacParTable = $('#sac_par_table').val();
	var sacParID = $('#sac_par_id').val();

	var data = 'sac_par_table=' + sacParTable + '&sac_par_id=' + sacParID + '&action=get_items_list';
	$.ajax({
		url: "pdr-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'ITEMDATAFETCHSUCCESS'){
				var itemData = JSON.parse(result.data);
				displayItemsList(itemData);
				$('#select_items_modal').modal();
				
				//set default selected value for item list
				setDefaultSelectedValueForItemList();
				//set bind events for checkbox
				selectItemsBindEvents();
			} else {
				bootbox.alert('No item data available.');
			}
		},
		error: function(){} 	        
	});
}

function displayItemsList(itemData){
	var dp = '';

	itemData.forEach( function(item, index) {
		dp += '<tr>';
			dp += '<td><input type="checkbox" id="item_checkbox_'+index+'" class="select_item_checkbox"></td>';
			dp += '<td>'+item.item_name+'</td>';
			dp += '<td>'+item.item_qty+'</td>';
			dp += '<td><input type="text" name="item_despatch_qty[]"></td>';
		dp += '</tr>';

		//push item to global item array
		gItemList.push(item);
	});

	$('#item_list_tbody').html(dp);
}

function setDefaultSelectedValueForItemList(){
	gItemList.forEach( function(item, index) {
		item.isItemSelected = 'false';
	});
	console.log(gItemList);
}

function selectItemsBindEvents(){
	$('.select_item_checkbox').on("change", function() {
	    var selectItemCheckBoxID = $(this).attr("id");
	    var selectItemCheckBoxVal = $('#'+selectItemCheckBoxID).val();
	    var selectItemCheckBoxIDArray = selectItemCheckBoxID.split('_'); 
	    var idCountVal = selectItemCheckBoxIDArray[selectItemCheckBoxIDArray.length-1];
	    console.log(idCountVal);
	    if ($('#'+selectItemCheckBoxID).is(':checked')){
	      gItemList[idCountVal].isItemSelected = 'true'; 
	      console.log(gItemList);

	      //to validate selected item count
	      gItemSelectedCount++;
	    } else {
	      gItemList[idCountVal].isItemSelected = 'false';
	      gItemSelectedCount--;
	    }  
	});
}

function createPDR(){
	if($('#pdr_create_form').valid()){
		if(gItemSelectedCount > 0){
			confirmCreatePDR();
		} else {
			bootbox.alert('No items selected. Please try again!');
		}
	}
}

function confirmCreatePDR(){
	var data = $('#pdr_create_form').serialize() + '&' + $('#select_items_form').serialize() + '&action=create_pdr';

	$.ajax({
		url: "pdr-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'CREATEPDRSUCCESS'){
				
			} else {
				bootbox.alert(result.message);
			}
		},
		error: function(){} 	        
	});
}