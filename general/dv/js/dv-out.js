function submitDocumentVerification(pdrId){
	//set values for checked checkboxes
	setValuesToCheckTextFields();

	var data = $('#document_verification_form').serialize() + '&action=submit_verification';
	//alert(data);
		$.ajax({
			url: "dv-out-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(result){
				if(result.infocode == 'DOCUMENTVERIFICATIONSUCCESS'){
					bootbox.alert(result.message,function(){
						window.location='dv-out-view.php';	
					});
				} else if(result.infocode == 'DOCUMENTNOTVERIFIED') {
					bootbox.alert(result.message,function(){
						window.location='dv-out-view.php';	
					});
				}		
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
}

function setValuesToCheckTextFields(){
	if($('#exbond_original_check').is(":checked")){
		$('#exbond_original').val('yes');
	} else {
		$('#exbond_original').val('no');
	}
	
	if($('#exboe_original_check').is(":checked")){
		$('#exboe_original').val('yes');
	} else {
		$('#exboe_original').val('no');
	}
	
	if($('#order_number_check').is(":checked")){
		$('#order_number').val('yes');
	} else {
		$('#order_number').val('no');
	}

	if($('#vehicle_number_check').is(":checked")){
		$('#vehicle_number').val('yes');
	} else {
		$('#vehicle_number').val('no');
	}
	
	if($('#license_number_check').is(":checked")){
		$('#license_number').val('yes');
	} else {
		$('#license_number').val('no');
	} 
}