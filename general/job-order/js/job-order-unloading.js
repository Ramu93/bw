(function($) {
  $.fn.serializefiles = function() {
      var obj = $(this);
      /* ADD FILE TO PARAM AJAX */
      var formData = new FormData();
      $.each($(obj).find("input[type='file']"), function(i, tag) {
          $.each($(tag)[0].files, function(i, file) {
              formData.append(tag.name, file);
          });
      });
      var params = $(obj).serializeArray();
      $.each(params, function (i, val) {
          formData.append(val.name, val.value);
      });
      return formData;
  };
})(jQuery);

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
		case 'igp':
			$('#fetch_by_label').html('IGP Unloading ID');
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
		case 'igp':
			$('#data_name').html('IGP ID');
			$('#modal_title').html('Select IGP');
		break;
	}
	
	$.ajax({
		url: "job-order-unloading-services.php",
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
			}else{
				$('#datalist_tbody').html('<tr><td colspan="3">There are no approved data waiting to be processed.</td></tr>');
				$('#view_list_modal').modal('show');
			}
		},
		error: function(){} 	        
	});
}

function getDataDetails(parId, dataItem){
	//alert('data req');
	$('#data_item').val(dataItem);
	$('#view_list_modal').modal('hide');
	$('#data_fetch_message').html('Data fetched successfully').fadeIn(400).fadeOut(2000);
	var selectType = $('#select_by_type').val();
	var data = 'par_id=' + parId + '&action=get_selected_data_details';
	//alert(data)
	$.ajax({
		url: "job-order-unloading-services.php",
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
				//var dimension = selectedData.dimension;
				var id_head = '';
				id_head = 'PAR ID:';
				$('#par_id').val(id);
				getContainersList(id);
				$('#id_label').html(id_head);
				$('#id_value').html(id);
				$('#customer_name_label').html('Customer Name:');
				$('#customer_name_value').html(customerName);	
				//$('#dimension').val(dimension);
			}
		},
		error: function(){
			alert('error');
		} 	        
	});
}

function getContainersList(parId){
	var data = 'par_id=' + parId + '&action=get_containers_list';
	$.ajax({
		url: "job-order-unloading-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == 'CONTAINERDATAFETCHSUCCESS'){
				displayContainersList(result.data);
			}
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function displayContainersList(containerData){
	//parse the container data
	containerData = JSON.parse(containerData);

	//push all the container numbers (belonging to different dimensions) in one array.
	var containerNumberArray = new Array;
	for(var i=0; i < containerData.length; i++){
		//parse the stringified container_details
		containerData[i].container_details = JSON.parse(containerData[i].container_details);
		for(index = 0; index < Object.keys(containerData[i].container_details).length; index++){
			if('igp_id' in (containerData[i].container_details)[index]){
				containerNumberArray.push( (containerData[i].container_details)[index].igp_id + '_' + (containerData[i].container_details)[index].container_number);
			}
		}
	}

	var dp = '';
	dp += '<option value="">Select container number...</option>';
	containerNumberArray.forEach( function(element, index) {
		dp += '<option value="' + element + '">' + (element.split('_'))[1] + '</option>';
	});

	 //console.log(containerNumberArray);

	$('#igp_id').html(dp);
	$('#select_container_div').show();
}

function createJobOrder(){
	if($('#job_order_unloading_form').valid()){
		var data = $('#job_order_unloading_form').serialize() + "&action=create_job_order";
		//alert(data);
		var sacParTable = $('#sac_par_table').val();
		var sacParId = $('#par_id').val();
		$.ajax({
			url: "job-order-unloading-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(data){
				if(data.status == 'Success'){
					bootbox.alert(data.message,function(){
						window.location='job-order-unloading-view.php?ju_id='+data.last_id;	//replace with last insert id
					});
				}
				
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
	}
}

function showRaiseException(){
  $('#exception_remarks').val('');
  $('#raiseexception_modal').modal('show');
}

function showCloseException(){
  $('#exception_closingremarks').val('');
  $('#closeexception_modal').modal('show');
}

function raiseException(){
	var data = $('#exception_form').serializefiles();
	//alert(data);
	$.ajax({
		url: "job-order-unloading-services.php",
		type: "POST",
		data:  data,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "RAISEEXCEPTIONSUCCESS"){
				bootbox.alert(result.message,function(){
					location.reload();
				});
				
			}else{
				bootbox.alert(result.message);
			}
		},
		error: function(){} 	        
	});
}

function closException(exceptionId){
	var data = $('#close_exception_form').serialize() + '&exception_id=' + exceptionId + '&action=close_exception';
	$.ajax({
		url: "job-order-unloading-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "CLOSEEXCEPTIONSUCCESS"){
				bootbox.alert(result.message,function(){
					location.reload();
				});
			}else{
				bootbox.alert(result.message);
			}
		},
		error: function(){} 	        
	});
}

function rejectJobOrder(juId){
	bootbox.confirm('You sure you want to reject this Job Order?',function(result){
			if(result){
				var data = 'ju_id=' + juId + '&action=reject_joborder';
				$.ajax({
					url: "job-order-unloading-services.php",
					type: "POST",
					data:  data,
					dataType: 'json',
					success: function(result){
						if(result.infocode == "JOBORDERREJECTED"){
							bootbox.alert(result.message,function(){
								location.reload();
							});
						}else{
							bootbox.alert(result.message);
						}
					},
					error: function(){} 	        
				});
			}
		});
}

function completeJobOrder(juId){
	bootbox.confirm('You sure you want to complete this Job Order?',function(result){
			if(result){
				var data = 'ju_id=' + juId + "&action=complete_joborder";
				$.ajax({
					url: "job-order-unloading-services.php",
					type: "POST",
					data:  data,
					dataType: 'json',
					success: function(result){
						if(result.infocode == "JOBORDERCOMPLETED"){
							bootbox.alert(result.message,function(){
								location.reload();	
							});
						}else{
							bootbox.alert(result.message);
						}
					},
					error: function(){} 	        
				});
			}
		});
	
}

function checkIfJobOrderExists(){
	var igpId = $('#igp_id').val().split('_')[0];
	var data = 'igp_id=' + igpId + '&action=check_joborder_exists';
	$.ajax({
		url: "job-order-unloading-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(result){
			if(result.infocode == "EXISTS"){
				$('input[type=submit]').attr('disabled', 'true');
				bootbox.alert('Job order already created for the selected container.');
			} else {
				$('input[type=submit]').removeAttr('disabled');
			}
		},
		error: function(){} 	        
	});
}

function printJobOrder(divName) {
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
