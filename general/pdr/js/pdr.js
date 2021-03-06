var gItemList = new Array;
var gItemSelectedCount = 0;

function changeLabelText(){
	var selectType = $('#select_by_type').val();
	switch (selectType) {
		//for column name
		case 'boe_number':
			$('#fetch_by_label').html('BOE Number');
		break;
		case 'grn':
			$('#fetch_by_label').html('GRN');
		break;
		case 'invoice':
			$('#fetch_by_label').html('Invoice');
		break;
	}
}

function getCurrentDate(){
  var today = new Date();
  var yy = today.getFullYear();
  var mm = today.getMonth();
  var dd = today.getDate();
  mm += 1;
  if(dd < 10){
    dd = '0' + dd;
  } 
  if(mm < 10){
    mm = '0' + mm;
  }
  var todayDate = yy + '-' + mm + '-' + dd;
  return todayDate;
}

function getBondOrderList(){
	$('#data_fetch_message').html('');
	var type = $('#select_by_type').val();
	var data = "type=" + type + "&action=get_bond_order_list";
	
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
					dp += '<tr><td>'+(c+1)+'</td><td>'+viewListData[c].data_item+'</td><td><button class="btn btn-primary" type="button" onclick="getDataDetails(\''+viewListData[c].par_id+'\',\''+viewListData[c].data_item+'\');">Select</button></td></tr>';
				}
				$('#datalist_tbody').html(dp);
				$('#view_list_modal').modal('show');
				switch(type){
					case 'boe':
						$('#type_th').html('BOE Number');
					break;
					case 'grn':
						$('#type_th').html('GRN ID');
					break;
					case 'invoice':
						$('#type_th').html('Invoice Number');
					break;
				}
				
			}else{
				$('#datalist_tbody').html('<tr><td colspan="3">There are no complted job orders waiting to be processed.</td></tr>');
				$('#view_list_modal').modal('show');
			}
		},
		error: function(){} 	        
	});
}

function getDataDetails(parId, dataItemVal){
	//alert('data req');
	$('#data_item_val').val(dataItemVal);
	$('#view_list_modal').modal('hide');
	$('#data_fetch_message').html('Data fetched successfully').fadeIn(400).fadeOut(2000);
	$('#ju_id').val(parId);
	var selectType = $('#select_by_type').val();
	var data = 'par_id=' + parId + '&action=get_selected_data_details';
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

				$('#par_id').val(id);

				$('#sac_par_table_label').html(id_head);
				$('#par_id').html(id);
				$('#assessable_value').val(selectedData.assessable_value);
				$('#duty_amount').val(selectedData.duty_amount);

				$('#fields').show();
				$('#create_pdr_btn').show();			}
		},
		error: function(){
			alert('error');
		} 	        
	});
}

function showItemsList(){
	var parId = $('#par_id').val();

	var data = 'par_id=' + parId + '&action=get_items_list';
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
				
				//set default values for item list
				setDefaultValuesForItemList();
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
	//reset item data
	gItemList = new Array;

	var dp = '';

	itemData.forEach( function(item, index) {
		dp += '<tr>';
			dp += '<td><input type="checkbox" id="item_checkbox_'+index+'" class="select_item_checkbox"></td>';
			dp += '<td>'+item.dv_item_id+'</td>';
			dp += '<td>'+item.item_name+'</td>';
			dp += '<td>'+item.item_qty+'</td>';
			dp += '<td><input type="text" id="item_despatch_qty_'+index+'" name="item_despatch_qty[]"></td>';
		dp += '</tr>';

		//push item to global item array
		gItemList.push(item);
	});

	$('#item_list_tbody').html(dp);
}

function setDefaultValuesForItemList(){
	gItemList.forEach( function(item, index) {
		item.is_item_selected = 'false';
		item.despatch_qty = 0;
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
	      gItemList[idCountVal].is_item_selected = 'true'; 
	      console.log(gItemList);

	      //to validate selected item count
	      gItemSelectedCount++;
	    } else {
	      gItemList[idCountVal].is_item_selected = 'false';
	      gItemSelectedCount--;
	    }  
	});
}

//call this method on closing the item list modal
function setDespatchQtyForItems(){
	gItemList.forEach( function(item, index) {
		if(item.is_item_selected == 'true'){
			item.despatch_qty = $('#item_despatch_qty_' + index).val();
		}
	});
	console.log(gItemList);
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
	var bondNumber = $('#bond_number').val();
	var data = $('#pdr_create_form').serialize() + '&bond_number=' + bondNumber + '&item_data=' + JSON.stringify(gItemList) + '&action=create_pdr';

	$.ajax({
		url: "pdr-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'CREATEPDRSUCCESS'){
				bootbox.alert(result.message, function(){
					window.location = 'pdr-approve-reject-view.php';
				});
			} else {
				bootbox.alert(result.message);
			}
		},
		error: function(){} 	        
	});
}

function updatePDR(){
	if($('#pdr_update_form').valid()){
		var data = $('#pdr_update_form').serialize() + '&action=update_pdr';
		$.ajax({
			url: "pdr-services.php",
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'UPDATEPDRSUCCESS'){
					bootbox.alert(result.message, function(){
					
						window.location = 'pdr-approve-reject-view.php';
						
					});
				} else {
					bootbox.alert(result.message);
				}
			},
			error: function(){} 	        
		});
	}
}

function approvePDR(pdrId){
	if($('#pdr_update_form').valid()){
		bootbox.confirm('You sure you want to approve this PDR?',function(result){
			if(result){
				var data = $('#pdr_update_form').serialize() + '&status=approved' + '&action=update_status_pdr';
				$.ajax({
					url: "pdr-services.php",
					type: "POST",
					data: data,
					dataType: 'json',
					success: function(result){
						if(result.infocode == 'UPDATEPDRSUCCESS'){
							bootbox.alert(result.message, function(){
								window.location = 'pdr-approve-reject-view.php';
							});
						} else {
							bootbox.alert(result.message);
						}
					},
					error: function(){} 	        
				});
			}
		});
	}
}

function rejectPDR(pdrId){
	if($('#pdr_update_form').valid()){
		if($('#pdr_update_form').valid()){
			bootbox.confirm('You sure you want to reject this PDR?',function(result){
				if(result){
					var data = $('#pdr_update_form').serialize() + '&status=rejected' + '&action=update_status_pdr';
					$.ajax({
						url: "pdr-services.php",
						type: "POST",
						data: data,
						dataType: 'json',
						success: function(result){
							if(result.infocode == 'UPDATEPDRSUCCESS'){
								bootbox.alert(result.message, function(){
									window.location = 'pdr-approve-reject-view.php';
								});
							} else {
								bootbox.alert(result.message);
							}
						},
						error: function(){} 	        
					});
				}
			});
		}
	}
}

function getPDRItems(pdrId){
	var data = 'pdr_id=' + pdrId + '&action=get_pdr_items';
	$.ajax({
		url: "pdr-services.php",
		type: "POST",
		data: data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'ITEMDATAFETCHSUCCESS'){
				//alert(result.data)
				var itemData = JSON.parse(result.data);
				displayItemsListInViewMode(itemData);
				$('#view_items_modal').modal();
			} else {
				bootbox.alert('No item data available.');
			}
		},
		error: function(){} 	        
	});
}

function displayItemsListInViewMode(itemData){
	var dp = '';

	itemData.forEach( function(item, index) {
		dp += '<tr>';
			dp += '<td>'+item.pdr_item_id+'</td>';
			dp += '<td>'+item.item_name+'</td>';
			dp += '<td>'+item.despatch_qty+'</td>';
		dp += '</tr>';
	});
	$('#item_list_tbody').html(dp);
}

function loadPage(){
	var status = $('#select_by_status').val();
	var filterFrom = $('#filter_from').val();
	var filterTo = $('#filter_to').val();
	var url = 'pdr-approve-reject-view.php?status=';
	switch(status){
		case 'created':
			url += 'created';
		break;
		case 'approved':
			url += 'approved';
		break;
		case 'rejected':
			url += 'rejected';
		break;
	}
	url += '&filter_from=' + filterFrom + '&filter_to=' + filterTo;
	this.document.location.href = url;
}