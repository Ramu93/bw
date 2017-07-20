function getTypes(){
	var data = 'action=get_types';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'success'){
				displayTypes(result.data);
			} else {
				displayTypes([]);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayTypes(typeData){
	var dp = '';
	if(typeData.length !== 0){
		typeData.forEach( function(type, index) {
			dp += '<tr>';
				dp += '<td>'+ (parseInt(index)+1) +'</td>';
				dp += '<td>'+type.type_name+'</td>';
				dp += '<td><input type="button" onclick="openEditTypeModal('+type.type_id+',\''+type.type_name+'\')" class="btn btn-primary" value="Edit" /> <input type="button" onclick="deleteType('+type.type_id+')" class="btn btn-danger" value="Delete"/></td>'
			dp += '</tr>';
		});
	}
	$('#type_table_body').html(dp);
	$("#type_table").DataTable();
}

function addType(){
	if($('#add_type_form').valid()){
		var typeName = $('#type_name').val();
		var data = 'type_name=' + typeName + '&action=add_type';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					getTypes();
					$('#type_name').val('');
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function openEditTypeModal(typeId, typeName){
	$('#type_id_hidden').val(typeId);
	$('#edit_type_name').val(typeName);
	$('#edit_type_modal').modal();
}

function editType(){
	if($('#edit_type_form').valid()){
		var typeId = $('#type_id_hidden').val();
		var typeName = $('#edit_type_name').val();
		var data = 'type_name=' + typeName + '&type_id=' + typeId + '&action=edit_type';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					getTypes();
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function deleteType(typeId){
	bootbox.confirm('You sure you want to delete this product type?',function(result){
		if(result){
			var data = 'type_id=' + typeId + '&action=del_type';
			$.ajax({
				url: "master-services.php",
				type: "POST",
				data:  data,
				dataType: 'json',
				success: function(result){
					if(result.infocode == 'success'){
						getTypes();
					}
				},
				error: function(){
					bootbox.alert("failure");
				} 	        
			});
		}
	});
}

function getItems(){
	var data = 'action=get_items';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'success'){
				displayItems(result.data);
			} else {
				displayItems([]);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayItems(itemData){
	var dp = '';
	if(itemData.length !== 0){
		itemData.forEach( function(item, index) {
			dp += '<tr>';
				dp += '<td>'+ (parseInt(index)+1) +'</td>';
				dp += '<td>'+item.item_name+'</td>';
				dp += '<td>'+item.type_name+'</td>';
				dp += '<td><input type="button" onclick="openEditItemModal('+item.item_master_id+',\''+item.item_name+'\',\''+item.type_id+'\')" class="btn btn-primary" value="Edit" /> <input type="button" onclick="deleteItem('+item.item_master_id+')" class="btn btn-danger" value="Delete"/></td>'
			dp += '</tr>';
		});
	}
	$('#item_table_body').html(dp);
	$("#item_table").DataTable();
}

function addItem(){
	if($('#add_item_form').valid()){
		var itemName = $('#item_name').val();
		var itemType = $('#item_type').val();
		var data = 'item_name=' + itemName + '&item_type=' + itemType + '&action=add_item';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					getItems();
					$('#item_name').val('');
					$('#item_type').val('');
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function openEditItemModal(itemId, itemName, itemTypeId){
	$('#item_id_hidden').val(itemId);
	$('#edit_item_name').val(itemName);
	$('#edit_item_type').val(itemTypeId);
	$('#edit_item_modal').modal();
}

function editItem(){
	if($('#edit_item_form').valid()){
		var itemId = $('#item_id_hidden').val();
		var itemName = $('#edit_item_name').val();
		var itemType = $('#edit_item_type').val();
		var data = 'item_id=' + itemId + '&item_name=' + itemName + '&item_type=' + itemType + '&action=edit_item';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					getItems();
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function deleteItem(itemId){
	bootbox.confirm('You sure you want to delete this item?',function(result){
		if(result){
			var data = 'item_id=' + itemId + '&action=del_item';
			$.ajax({
				url: "master-services.php",
				type: "POST",
				data:  data,
				dataType: 'json',
				success: function(result){
					if(result.infocode == 'success'){
						getItems();
					}
				},
				error: function(){
					bootbox.alert("failure");
				} 	        
			});
		}
	});
}

function getTariffs(){
	var data = 'action=get_tariffs';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'success'){
				displayTariffs(result.data);
			} else {
				displayTariffs([]);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}
	
var gTariff = new Array;

function displayTariffs(tariffData){
	var dp = '';
	if(tariffData.length !== 0){
		tariffData.forEach( function(tariff, index) {
			//save values in object for passing to edit modal
			gTariff.push(tariff);

			dp += '<tr>';
				dp += '<td>'+ (parseInt(index)+1) +'</td>';
				dp += '<td>'+tariff.service_name+'</td>';
				dp += '<td>'+tariff.service_type+'</td>';
				dp += '<td>'+tariff.storage_unit+'</td>';
				dp += '<td>'+tariff.base_tariff+'</td>';
				dp += '<td><input type="button" onclick="openEditTariffModal('+index+')" class="btn btn-primary" value="Edit" /> <input type="button" onclick="deleteTariff('+tariff.tariff_master_id+')" class="btn btn-danger" value="Delete"/></td>'
			dp += '</tr>';
		});
	}
	$('#tariff_table_body').html(dp);
	$("#tariff_table").DataTable();
}

function addTariff(){
	if($('#add_tariff_form').valid()){
		var data = $('#add_tariff_form').serialize() + '&action=add_tariff';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					//reset gTariff array
					gTariff = new Array;
					getTariffs();
					$('#service_name').val('');
					$('#service_type').val('');
					$('#storage_unit').val('');
					$('#rate').val('');
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function openEditTariffModal(index){
	//var gTariff = JSON.parse(tariffString);
	$('#tariff_id_hidden').val(gTariff[index].tariff_master_id);
	$('#edit_service_name').val(gTariff[index].service_name);
	$('#edit_service_type').val(gTariff[index].service_type);
	$('#edit_storage_unit').val(gTariff[index].storage_unit);
	$('#edit_rate').val(gTariff[index].base_tariff);
	$('#edit_tariff_modal').modal();
}

function editTariff(){
	if($('#edit_tariff_form').valid()){
		var data = $('#edit_tariff_form').serialize() + '&action=edit_tariff';
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'success'){
					//reset gTariff array
					gTariff = new Array;
					getTariffs();
				}
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function deleteTariff(tariffId){
	bootbox.confirm('You sure you want to delete this item?',function(result){
		if(result){
			var data = 'tariff_id=' + tariffId + '&action=del_tariff';
			$.ajax({
				url: "master-services.php",
				type: "POST",
				data:  data,
				dataType: 'json',
				success: function(res){
					if(res.infocode == 'success'){
						//reset gTariff array
						gTariff = new Array;
						getTariffs();
					}
				},
				error: function(){
					bootbox.alert("failure");
				} 	        
			});
		}
	});
}

function changePartyType(patryType){
	if(patryType == 'serviceprovider'){
		$('#sp_div').show();
		$('#sp_div2').hide();
	}else if(patryType == 'principalclient'){
		$('#sp_div2').show();
		$('#sp_div').hide();
	}else{
		$('#sp_div').hide();
		$('#sp_div2').hide();
	}
}

function addParty(){
	if($('#add_party_form').valid()){
		var data = $('#add_party_form').serialize() + '&action=add_party';
		//console.log(data);
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'INSERTSUCCESSFULLY'){
					$('#add_party_form')[0].reset();
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

function editParty(pmId){
	if($('#edit_party_master').valid()){
		var data = $('#edit_party_master').serialize() + '&pm_id=' + pmId + '&action=edit_party';
		//console.log(data);
		$.ajax({
			url: "master-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'SUCCESS'){
					bootbox.alert(result.message, function(){
						window.location='party-master-view.php';
					});
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

function deleteParty(pmId){
	bootbox.confirm('You sure you want to delete this item?',function(res){
		if(res){
			var data = 'pm_id=' + pmId + '&action=del_party';
			$.ajax({
				url: "master-services.php",
				type: "POST",
				data:  data,
				dataType: 'json',
				success: function(result){
					if(result.infocode == 'SUCCESS'){
						bootbox.alert(result.message, function(){
							window.location='party-master-view.php';
						});
					} else {
						bootbox.alert(result.message);
					}
				},
				error: function(){
					bootbox.alert("failure");
				} 	        
			});
		}
	});
}