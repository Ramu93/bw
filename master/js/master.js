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
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayTypes(typeData){
	var dp = '';
	typeData.forEach( function(type, index) {
		dp += '<tr>';
			dp += '<td>'+ (parseInt(index)+1) +'</td>';
			dp += '<td>'+type.type_name+'</td>';
			dp += '<td><input type="button" onclick="openEditTypeModal('+type.type_id+',\''+type.type_name+'\')" class="btn btn-primary" value="Edit" /> <input type="button" onclick="deleteType('+type.type_id+')" class="btn btn-danger" value="Delete"/></td>'
		dp += '</tr>';
	});
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
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayItems(typeData){
	var dp = '';
	typeData.forEach( function(item, index) {
		dp += '<tr>';
			dp += '<td>'+ (parseInt(index)+1) +'</td>';
			dp += '<td>'+item.item_name+'</td>';
			dp += '<td>'+item.type_name+'</td>';
			dp += '<td><input type="button" onclick="openEditItemModal('+item.item_master_id+',\''+item.item_name+'\',\''+item.type_id+'\')" class="btn btn-primary" value="Edit" /> <input type="button" onclick="deleteItem('+item.item_master_id+')" class="btn btn-danger" value="Delete"/></td>'
		dp += '</tr>';
	});
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