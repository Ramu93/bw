$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);

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
					$('#item_added_message').html('Item added successfully').fadeIn(400).fadeOut(3000);
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
				dp += '<td>'+tariff.unit+'</td>';
				dp += '<td>'+tariff.price_per_unit+'</td>';
				dp += '<td>'+tariff.service_type+'</td>';
				dp += '<td>'+tariff.minimum_slab+'</td>';
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
					$('#unit').val('');
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
	$('#edit_unit').val(gTariff[index].unit);
	$('#edit_service_type').val(gTariff[index].service_type);
	$('#edit_price_per_unit').val(gTariff[index].price_per_unit);
	$('#edit_minimum_slab').val(gTariff[index].minimum_slab);
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
					bootbox.alert('New party added successfully.', function(){
						$('#add_party_form')[0].reset();
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

var gCheck = 0; // for checking if both the cha party id and customer party id are filled

function getPartyDetails(type){
	var partyName = '';
	if(type === 'customer'){
		partyName = $('#importing_firm_name').val();
	} else {
		partyName = $('#cha_name').val();
	}

	var data = 'party_name=' + partyName + '&action=get_party_details';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				if(type === 'customer'){
					$('#customer_id_label').html(result.data);
					$('#customer_id_hidden').val(result.data);
					$('#customer_details_div').show();
					gCheck += 1;
				} else {
					$('#cha_id_label').html(result.data);
					$('#cha_id_hidden').val(result.data);
					$('#cha_details_div').show();
					gCheck += 1;
				}

				if(gCheck === 2){
					$('#add_discount_tariff_btn').prop('disabled', '');
					gCheck = 0;
				}
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function changeDiscountRate(tmId){
	rate = parseFloat($('#'+tmId+'_discount_rate').val().trim());
	dp = parseFloat($('#'+tmId+'_discount_percentage').val().trim());
	da = rate - (rate * (dp/100));
	$('#'+tmId+'_discount_amount').val((isNaN(da)?'0.00':da.toFixed(2)));
}

function changeDiscountPercentage(tmId){
	rate = parseFloat($('#'+tmId+'_discount_rate').val().trim());
	da = parseFloat($('#'+tmId+'_discount_amount').val().trim());
	dp = (rate - da) * (100/rate);
	$('#'+tmId+'_discount_percentage').val((isNaN(dp)?'0.00':dp.toFixed(2)));
}

function addDiscountTariff(){
	var data = $('#discount_tariff_form').serialize() + '&action=add_discount_tariff';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#added_message').html('Discount tariff added successfully').fadeIn(400).fadeOut(3000);
				$('#discount_tariff_form')[0].reset();
				$('#customer_details_div').hide();
				$('#cha_details_div').hide();
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function updateDiscountTariff(){
	var data = $('#discount_tariff_form').serialize() + '&action=update_discount_tariff';
	$.ajax({
		url: "master-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'SUCCESS'){
				$('#updated_message').html('Discount tariff updated successfully').fadeIn(400).fadeOut(3000);
			}
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	}); 
}