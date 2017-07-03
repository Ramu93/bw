function generateIGP(){
	if($('#igp-unloading-form').valid()){
		var data = $('#igp-unloading-form').serialize() + "&action=generate_igp";
		//alert(data);
		$.ajax({
			url: "gate-pass-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(data){
				if(data.status == 'Success'){
					bootbox.alert(data.message,function(){
						window.location='igp-unloading-list-view.php';	
					});
				}
				
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

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
		case 'customer_name':
			$('#fetch_by_label').html('Customer Name');
		break;
		case 'boe_number':
			$('#fetch_by_label').html('BOE Number');
		break;
		case 'par':
			$('#fetch_by_label').html('PAR ID');
		break;
		case 'sac':
			$('#fetch_by_label').html('SAC ID');
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
		case 'customer_name':
			$('#data_name').html('Customer Name');
			$('#modal_title').html('Select Approved Customer Name'); // modal title
		break;
		case 'boe_number':
			$('#data_name').html('BOE Number');
			$('#modal_title').html('Select Approved BOE Number');
		break;
		case 'par':
			$('#data_name').html('PAR ID');
			$('#modal_title').html('Select Approved PAR');
		break;
		case 'sac':
			$('#data_name').html('SAC ID');
			$('#modal_title').html('Select Approved SAC');
		break;
	}
	
	$.ajax({
		url: "gate-pass-services.php",
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
		case 'customer_name':
			data += 'data_type=customer_name';
		break;
		case 'boe_number':
			data += 'data_type=boe_number';
		break;
		case 'par':
			data += 'data_type=par';
		break;
		case 'sac':
			data += 'data_type=sac';
		break;
	}
	data += '&data_value=' + dataItem + '&action=get_selected_data_details';
	//alert(data)
	$.ajax({
		url: "gate-pass-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){			
			if(result.infocode == 'DATADETAILFETCHSUCCESS'){
				var selectedData = result.data;
				selectedData = JSON.parse(selectedData)[0];
				var id = selectedData.id;
				var tableName = selectedData.table_name;
				var customerName = selectedData.importing_firm_name;
				var id_head = '';
				if(tableName == 'sac'){
					id_head = 'SAC ID:';
				} else {
					id_head = 'PAR ID:';
				}

				$('#sac_par_table').val(tableName);
				$('#sac_par_id').val(id);

				$('#id_label').html(id_head);
				$('#id_value').html(id);
				$('#customer_name_label').html('Customer Name:');
				$('#customer_name_value').html(customerName);

				//load container numbers in form
				getSelectedtContainerData(tableName, id);
			}
		},
		error: function(){
			alert('error');
		} 	        
	});
}

function getSelectedtContainerData(sacParTable, sacParId){
	var data = 'sac_par_table=' + sacParTable + "&sac_par_id=" + sacParId + '&action=get_container_data';
	//alert(data);
	$.ajax({
		url: "gate-pass-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){	
			if(result.infocode == 'CONTAINERDATAFETCHSUCCESS'){
				var containers = result.data;
				displayContainerNumbers(containers);
			}
		},
		error: function(){} 	        
	});
}


function displayContainerNumbers(containers){
	//parse the container data
	containers = JSON.parse(containers);

	//push all the container numbers (belonging to different dimensions) in one array.
	var containerNumberArray = new Array;
	for(var i=0; i < containers.length; i++){
		//parse the stringified container_details
		containers[i].container_details = JSON.parse(containers[i].container_details);
		for(index = 0; index < Object.keys(containers[i].container_details).length; index++){
			containerNumberArray.push( containers[i].dimension + '_' + index + '_' +(containers[i].container_details)[index].container_number);
		}
	}

	var dp = '';
	dp += '<option value="">Select container number...</option>';
	containerNumberArray.forEach( function(element, index) {
		dp += '<option value="' + element + '">' + (element.split('_'))[2] + '</option>';
	});

	console.log(containerNumberArray);

	$('#container_number_select').html(dp);
}