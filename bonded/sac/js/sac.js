$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);

$.validator.addMethod(
        "assessableValue",
        function(value, element) {
        	var assessableValue = $('#assessable_value').val();
        	var dutyAmount = $('#duty_amount').value();
		  return this.optional( element ) || (dutyAmount >= assessableValue ? false : true);
		},
        "Duty amount cmust be lesser than assessable value."
);

var gContainerList = new Array;
var g_rowcount=2;
var g_snocount=2;
var additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><select class="form-control required" id="dimension" name="dimension[]"><option value="20 ft. Container">20 ft. Container</option><option value="40 ft. Container">40 ft. container</option><option value="Break Bulk ODC LCL">Break Bulk ODC LCL</option></select></td>\
							<td><input type="text" name="qty_numbers[]" placeholder="" class="form-control"></td>\
							<td><input type="text" name="container_weight[]" placeholder="" class="form-control"></td>\
							<td><input type="text" name="vehicle_number[]" placeholder="" class="form-control"></td>\
							<td><button onclick="addContainerRow([addcount])">+</button><button class="item_removebutton" onclick="removeContainerRow([removecount])">-</button></td></tr>';

function replaceFieldsForContainers(){
	var dimension = $('#dimension').val();
	var dp = '';
	switch(dimension){
		case 'Break Bulk':
		case 'LCL':
			dp += '<div class="col-md-6">\
                      <label for="container_detail">No. of Packages/tonnage</label>\
                      <div class="form-group">\
                        <input type="text" class="form-control" name="tonnage" id="tonnage" placeholder="" />\
                      </div>\
                    </div>';
		break;
		case '20 ft. Container':
		case '40 ft. Container':
		case 'ODC':
			dp += '<div class="col-md-4">\
                      <label for="container_detail">No. of Containers</label>\
                      <div class="form-group">\
                        <input type="text" class="form-control" name="container_count" id="container_count" placeholder="" value="1" />\
                      </div>\
                    </div>\
                    <div class="clearfix"></div>\
                    <div id="container_number_div">\
                      <div class="col-md-4">\
                        <div class="form-group">\
                          <input type="text" class="form-control required" name="container_number_1" id="container_number_1" placeholder="Container Number" />\
                        </div>\
                      </div>\
                    </div>';
		break;
	}
	$('#container_fields_div').html(dp);

	$('#container_count').spinner({
        min: 1,
        stop: function( event, ui ){
                containerSpinner();
            }
    });
}

function addContainerRow(rowcount){
	var addrow = additem_template.replace('[trid]','itemtr_'+g_rowcount)
								.replace('[sno]',g_snocount)
								.replace('[addcount]',g_rowcount)
								.replace('[removecount]',g_rowcount)
	$('#addcontainer_tbody').append(addrow);
	g_rowcount++;
	g_snocount++;
	$('.item_removebutton').show();
}


function removeContainerRow(rowcount){
	$('#itemtr_'+rowcount).remove();
	refreshSNoCount();
}

function refreshSNoCount(){
	var sillycount = 1;
	$('.td_sno').each(function(d){
		//console.log(d);
		$(this).html(sillycount++);
	});
	g_snocount = sillycount;
	if(sillycount<=2)
		$('.item_removebutton').hide();
}

function createSACRequest(){
	if($("#sac-req-form").valid()){
		if (gContainerList.length == 0){
			bootbox.confirm('No containers added. You sure you want to continue?',function(result){
				if(result){
					confirmCreateSACRequest();
				}
			});
		} else {
			confirmCreateSACRequest();
		}
	}
}

function confirmCreateSACRequest(){
	var data = $('#sac-req-form').serialize() + "&containerdata=" +JSON.stringify(gContainerList) + "&action=create_sac_req";
		//alert(data);
		$.ajax({
			url: "sac-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(data){
				bootbox.alert(data.message,function(){
					window.location='sac-request-view.php';	
				});
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
}

function updateSACRequest(sacID){
	if($("#sac-req-form").valid()){
		bootbox.confirm('You sure you want to update this SAC request?',function(result){
			if(result){
				if (gContainerList.length == 0){
					bootbox.confirm('No containers added. You sure you want to continue?',function(result2){
						if(result2){
							confirmUpdateSACRequest(sacID);
						}
					});
				} else {
					confirmUpdateSACRequest(sacID);
				}
			}
		});
	}
}

function confirmUpdateSACRequest(sacID){
	var data = $('#sac-req-form').serialize() + "&sac_id=" + sacID + "&action=update_sac_req";
	//alert(data);
	$.ajax({
		url: "sac-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				if(isEditPage){
					window.location='sac-request-view.php';
				} else {
					window.location='sac-request-approve-reject-view.php';
				}	
			});
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function approveSACRequest(sacID){
	if($("#sac-req-form").valid()){
		bootbox.confirm('You sure you want to approve this SAC request?',function(result){
			if(result){
				confirmApproveSACRequest(sacID);
			}
		});
	}
}

function confirmApproveSACRequest(sacID){
	var data = $('#sac-req-form').serialize() + "&sac_id=" + sacID + "&status=approved&action=sac_status_change";
		//alert(data);
		$.ajax({
			url: "sac-services.php",
			type: "POST",
			data:  data,
			dataType: 'json',
			success: function(data){
				bootbox.alert(data.message,function(){
					window.location='sac-request-approve-reject-view.php';	
				});
				
			},
			error: function(){
				bootbox.alert("failure");
			} 	        
		});
}

function rejectSACRequest(sacID){
	if($("#sac-req-form").valid()){
		bootbox.confirm('You sure you want to reject this SAC?',function(result){
			if(result){
				confirmRejectSACRequest(sacID);
			}
		});
	}
}

function confirmRejectSACRequest(sacID){
	var data = $('#sac-req-form').serialize() + "&sac_id=" + sacID + "&status=rejected&action=sac_status_change";
	//alert(data);
	$.ajax({
		url: "sac-services.php",
		type: "POST",
		data:  data,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				window.location='sac-request-approve-reject-view.php';	
			});
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}


function addContainerItem(){
	if($('#containerlist_form').valid()){
		var containerItem = {};
		var containerDetail = new Array;
		dimension= $('#dimension').val().trim();
		containerItem.dimension = dimension;
		
		switch(dimension){
			case 'Break Bulk':
			case 'LCL':
				containerItem.tonnage = $('#tonnage').val().trim();
				gContainerList.push(containerItem);
			break;
			case '20 ft. Container':
			case '40 ft. Container':
			case 'ODC':
				containerCount= $('#container_count').val().trim();
				for(i = 1; i <= containerCount; i++){
					containerDetail.push($('#container_number_'+i).val().trim());
				}
				containerItem.container_count = containerCount;
				containerItem.container_detail = convertArrayToJSON(containerDetail);
				gContainerList.push(containerItem);
			break;
		}
		displayContainers();
		$('#containerlist_form')[0].reset();
		containerSpinner();
		replaceFieldsForContainers();
	}
}

function convertArrayToJSON(container){
	var containerDetailJSON = new Array;
	container.forEach( function(element, index) {
		var containerDetail = {};
		containerDetail.container_number = element;
		containerDetail.status = 'not_picked';
		containerDetailJSON.push(containerDetail);
	});
	return containerDetailJSON;
}

function containerSpinner(){
	var count = $('#container_count').val().trim(); 
	var dp='';
	for(i=1;i<=count;i++){
		dp += '<div class="form-group"><div class="col-md-4"><input type="text" class="form-control required" name="container_number_'+i+'" id="container_number_'+i+'" placeholder="Container Number"/></div></div>';
	}

	$('#container_number_div').html(dp);
}

function displayContainers(){
	var dp='<br/>';
	
	if(gContainerList.length){
		for(q in gContainerList){
			dp += '<div class="panel panel-default"><div class="panel-heading" role="tab" id="headingtabc'+q+'"><h4 class="panel-title">\
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetabc'+q+'" aria-expanded="false" aria-controls="collapseOne">\
				'+gContainerList[q].dimension.replace('_',' to ')+' </a><span style<button</h4>\
				<span style="float:right;"><a href="javascript:deleteContainerItem(\''+q+'\');"><i class="fa fa-trash"></i></a></span> </div>\
				<div id="collapsetabc'+q+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtabc'+q+'">\
						<div class="panel-body">';
			switch(gContainerList[q].dimension){
				case 'Break Bulk':
				case 'LCL':
					dp+= '<div class="col-sm-7">No. of Packages/Tonnage : '+gContainerList[q].tonnage+'</div>';
				break;
				case '20 ft. Container':
				case '40 ft. Container':
				case 'ODC':
					dp+= '<div class="col-sm-4">Container Count : '+gContainerList[q].container_count+'</div>';
					//dp+= '<div class="col-sm-8">Container Numbers : '+gContainerList[q].container_detail.join(' , ')+'</div>';
					dp+= '<div class="col-sm-4">Container Numbers : ';

					gContainerList[q].container_detail.forEach( function(element, index) {
						dp += element.container_number;
						if(index !== gContainerList[q].container_detail.length - 1){
							dp += ', ';
						}
					});

					dp += '</div>'
					dp += '</div></div></div>';
				break;
			}
			
		}
		$('#accordion_container').html(dp).show();
	}else{
		$('#accordion_container').hide();
	}
}

function displayContainersInEditMode(){
	var dp='<br/>';
	
	if(gContainerList.length){
		for(q in gContainerList){
			dp += '<div class="panel panel-default"><div class="panel-heading" role="tab" id="headingtabc'+q+'"><h4 class="panel-title">\
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetabc'+q+'" aria-expanded="false" aria-controls="collapseOne">\
				'+gContainerList[q].dimension.replace('_',' to ')+' </a><span style<button</h4>\
				<span style="float:right;"><a href="javascript:deleteContainerItem(\''+q+'\');"><i class="fa fa-trash"></i></a></span> </div>\
				<div id="collapsetabc'+q+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtabc'+q+'">\
						<div class="panel-body">';

			switch(gContainerList[q].dimension){
				case 'Break Bulk':
				case 'LCL':
					dp+= '<div class="col-sm-7">No. of Packages/Tonnage : '+gContainerList[q].tonnage+'</div>';
				break;
				case '20 ft. Container':
				case '40 ft. Container':
				case 'ODC':
					dp+= '<div class="col-sm-4">Container Count : '+gContainerList[q].container_count+'</div>';

					//dp+= '<div class="col-sm-8">Container Numbers : '+gContainerList[q].container_detail.join(' , ')+'</div>';
					dp+= '<div class="col-sm-4">Container Numbers : ';

					for(index = 0; index < Object.keys(gContainerList[q].container_details).length; index++){
						dp += (gContainerList[q].container_details)[index].container_number;
						if(index != Object.keys(gContainerList[q].container_details).length - 1){
							dp += ', ';
						}
					}

					dp += '</div>'
					dp += '</div></div></div>';
				break;
			}

			
		}
		$('#accordion_container').html(dp).show();
	}else{
		$('#accordion_container').hide();
	}
}

function deleteContainerItem(arrayindex){
	bootbox.confirm('You sure you want to delete this detail?',function(result){
		if(result){
			gContainerList.splice(arrayindex,1);
			displayContainers();
		}
	});
}

function loadPage(){
	var status = $('#select_by_status').val();
	var url = 'sac-request-approve-reject-view.php?status=';
	switch(status){
		case 'submitted':
			url += 'submitted';
		break;
		case 'approved':
			url += 'approved';
		break;
		case 'rejected':
			url += 'rejected';
		break;
	}
	this.document.location.href = url;
}