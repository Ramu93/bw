<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $parID = $_GET['par_id'];
  $select = "SELECT * FROM pre_arrival_request WHERE par_id='$parID'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    //loading containers from db
    $containerSelect = "SELECT * FROM par_container_info WHERE id='$parID'";
    $result = mysqli_query($dbc,$containerSelect);
    $containerOutput = array();
    if(mysqli_num_rows($result) > 0){
      while ($containerRow = mysqli_fetch_array($result)) {
        $containerOutput[] = array (
         'dimension'=>$containerRow['dimension'],
         'container_count' => $containerRow['container_count'],
         'container_details'=> $containerRow['container_details'],
         'tonnage'=>$containerRow['tonnage']
         );
      }
    }
    //file_put_contents("editlog.log", print_r( json_encode($containerOutput), true ));
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pre Arrival Request - Approve/Reject
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="par-form" name="par-form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="par_id" value="<?php echo $parID; ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Name of the Importer/Customer</label>
                  <input type="text" tabindex="1" class="form-control required autofillparty" id="importing_firm_name" name="importing_firm_name" placeholder="Name of the importing firm" value="<?php echo $row['importing_firm_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="bol_awb_no">BOL/Invoice Number</label>
                  <input type="text" tabindex="3" class="form-control required" id="bol_awb_no" name="bol_awb_number" placeholder="BOL/AWB Number" value="<?php echo $row['bol_awb_number']; ?>">
                </div>
                <div class="form-group">
                  <label for="bol_awb_no">BOL/Invoice Date</label>
                  <input type="text" tabindex="5" class="form-control required" id="bol_awb_date" name="bol_awb_date" placeholder="BOL/Invoice Date" value="<?php echo $row['bol_awb_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="material_name">Name of the Material</label>
                  <input type="text" tabindex="7" class="form-control required" id="material_name" name="material_name" placeholder="Name of the Material" value="<?php echo $row['material_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="packing_nature">Nature of Packing</label>
                  <input type="text" tabindex="9" class="form-control required autofillunit" id="packing_nature" name="packing_nature" placeholder="Nature of packing" value="<?php echo $row['packing_nature'] ?>">
                </div>
                <div class="form-group">
                  <label for="qty_units">Assessable Value</label>
                  <input type="text" tabindex="11" class="form-control required" id="assessable_value" name="assessable_value" placeholder="Assessable Value" value="<?php echo $row['assessable_value']; ?>">
                </div>
                <div class="form-group">
                  <label for="material_nature">Nature of Materials</label>
                  <select class="form-control" tabindex="13" id="material_nature" name="material_nature" required="">
                    <option value="Non Hazardous" <?php echo (($row['material_nature']=='Non Hazardous')?'selected="selected"':''); ?> >Non Hazardous</option>
                    <option value="Hazardous" <?php echo (($row['material_nature']=='Hazardous')?'selected="selected"':''); ?> >Hazardous</option>
                    <option value="Chemcals Compositor" <?php echo (($row['material_nature']=='Chemcals Compositor')?'selected="selected"':''); ?> >Chemcals Compositor</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cargo_life">Cargo Life</label>
                  <input type="text" tabindex="15" class="form-control required" id="cargo_life" name="cargo_life" placeholder="Cargo Life" value="<?php echo $row['cargo_life']; ?>" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Name of the CHA</label>
                  <input type="text" tabindex="2" class="form-control required autofillparty" id="cha_name" name="cha_name" placeholder="Name of the CHA" value="<?php echo $row['cha_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="boe_num">BOE Number</label>
                  <input type="text" tabindex="4" class="form-control required" id="boe_num" name="boe_number" placeholder="BOE Number" value="<?php echo $row['boe_number']; ?>">
                </div>     
                <div class="form-group">
                  <label for="boe_num">BOE Date</label>
                  <input type="text" tabindex="6" class="form-control required" id="boe_date" name="boe_date" placeholder="BOE Date" value="<?php echo $row['boe_date']; ?>">
                </div>       
                <div class="form-group">
                  <label for="qty_units">Quantity in Number of Units</label>
                  <input type="text" tabindex="8" class="form-control required" id="qty_units" name="qty_units" placeholder="Quantity in No of units" value="<?php echo $row['qty_units']; ?>">
                </div>
                <div class="form-group">
                  <label for="space_requirement">Requirement of Space</label>
                  <input type="text" tabindex="10" class="form-control required" id="space_req" name="space_requirement" placeholder="Requirement of Space" value="<?php echo $row['space_requirement']; ?>">
                </div>
                <div class="form-group">
                  <label for="duty_amount">Duty Amount in Rupees</label>
                  <input type="text" tabindex="12" class="form-control required" id="duty_amount" name="duty_amount" placeholder="Duty Amount in Rupees" value="<?php echo $row['duty_amount']; ?>">
                </div>
                <div class="form-group">
                  <label for="expected_date">Expected Date of Warehousing</label>
                  <input type="text" tabindex="14" class="form-control required" id="expected_date" name="expected_date" placeholder="Expected Date of Warehousing" value="<?php echo $row['expected_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="shelf_life">Shelf Life</label>
                  <input type="text" tabindex="16" class="form-control required" id="shelf_life" name="shelf_life" placeholder="Shelf Life" value="<?php echo $row['shelf_life']; ?>" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="required_period">Required Period of Warehousing</label>
                  <select tabindex="17" class="form-control required" id="required_period_of_warehousing" name="required_period">
                    <option value="">Select...</option>
                    <option value="1" <?php echo (($row['required_period']=='1')?'selected="selected"':'');  ?> >1</option>
                    <option value="2" <?php echo (($row['required_period']=='2')?'selected="selected"':'');  ?> >2</option>
                    <option value="3" <?php echo (($row['required_period']=='3')?'selected="selected"':'');  ?> >3</option>
                    <option value="4" <?php echo (($row['required_period']=='4')?'selected="selected"':'');  ?> >4</option>
                    <option value="5" <?php echo (($row['required_period']=='5')?'selected="selected"':'');  ?> >5</option>
                    <option value="6" <?php echo (($row['required_period']=='6')?'selected="selected"':'');  ?> >6</option>
                    <option value="7" <?php echo (($row['required_period']=='7')?'selected="selected"':'');  ?> >7</option>
                    <option value="8" <?php echo (($row['required_period']=='8')?'selected="selected"':'');  ?> >8</option>
                    <option value="9" <?php echo (($row['required_period']=='9')?'selected="selected"':'');  ?> >9</option>
                    <option value="10" <?php echo (($row['required_period']=='10')?'selected="selected"':'');  ?> >10</option>
                    <option value="11" <?php echo (($row['required_period']=='11')?'selected="selected"':'');  ?> >11</option>
                    <option value="12" <?php echo (($row['required_period']=='12')?'selected="selected"':'');  ?> >12</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="insurance_by">Insurance By</label>
                  <div class="form-group">
                    <input type="radio" tabindex="18" id="insurance_by" name="insurance_by" value="TRLPL" <?php echo (($row['insurance_by']=='TRLPL')?'checked':''); ?> onclick="disableClientInsuranceFile();"> TRLPL &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="19" id="insurance_by" name="insurance_by" value="Client" <?php echo (($row['insurance_by']=='Client')?'checked':''); ?> onclick="enableClientInsuranceFile();"> Client
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" id="client_insurance_file_div">
                  <label class="btn btn-primary">
                      Attach copy <input type="file" style="display: none;" name="client_insurance_file">
                  </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="insurance_declaration">Insurance Declaration</label>
                  <div class="form-group">
                    <input type="radio" tabindex="20" id="insurance_declaration" name="insurance_declaration" value="Yes" <?php echo (($row['insurance_declaration']=='Yes')?'checked':''); ?> onclick="enableClientInsuranceDeclararionFile();"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="21" id="insurance_declaration" name="insurance_declaration" value="No" <?php echo (($row['insurance_declaration']=='No')?'checked':''); ?> onclick="disableClientInsuranceDeclararionFile();"> No
                  </div>
                </div>
              </div>
              <div class="col-md-2"">
                <div class="form-group" id="client_insurance_declaration_file_div">
                  <label class="btn btn-primary">
                      Attach copy <input type="file" style="display: none;" name="insurance_declaration_file">
                  </label>
                </div>
              </div>
            </div>
            <input type="hidden" id="action_hidden_text" name="action" value="par_status_change">
            <input type="hidden" id="status" name="status" value="">
            <input type="hidden" id="container_stringified" name="container_stringified" >
            <div class="row">
              <?php if($row['status'] == 'submitted') { ?>
                <div class="col-md-3 col-sm-3">
                  <input type="button" name="approve_par" value="Approve PAR" class="btn btn-primary btn-block pull-left" tabindex="23" onclick="approvePAR();">
                </div>
                <div class="col-md-3 col-sm-3">
                  <input type="button" name="reject_par" tabindex="22" value="Reject PAR" class="btn btn-primary btn-block pull-left" onclick="rejectPAR();">
                </div>
                <div class="col-md-3 col-sm-3">
                  <input type="submit" name="submit" value="Update PAR" class="btn btn-primary btn-block pull-left" onclick="updateClicked();updatePAR(<?php echo $parID; ?>);">
                </div>
              <?php } ?>
              <div class="col-md-3 col-sm-3">
                <input type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#containerlist_modal" value="View Containers">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!--Container Modal Div -->
 <div class="modal fade" id="containerlist_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="containerlist_form" name="containerlist_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">View Container Details</h4>
              </div>
              <div class="modal-body">
                <!-- <div class="" id="containeritems_div">
                  <div class="col-md-4">
                    <label for="dimension">Dimension</label>
                    <select class="form-control required" id="dimension" name="dimension">
                      <option value="20 ft. Container">20 ft. Container</option>
                      <option value="40 ft. Container">40 ft. container</option>
                      <option value="Break Bulk/ODC">Break Bulk/ODC</option>
                      <option value="LCL">LCL</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="container_detail">No. of Containers</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="container_count" id="container_count" placeholder="" value="1" />
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div id="container_number_div">
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" class="form-control required" name="container_number_1" id="container_number_1" placeholder="Container Number" />
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div> -->
                <div class="col-sm-12" id="accordion_div_container">
                  <div class="panel-group" id="accordion_container" role="tablist" aria-multiselectable="true" style="display:none;">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne_container">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_c" aria-expanded="false" aria-controls="collapseOne">
                            Collapsible Group Item #1
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne_c" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-success" onclick="addContainerItem();" >Add Detail</button> -->
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/par/js/par.js"></script>
  <script type="text/javascript">
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    $(document).ready(function(){
      $("#client_insurance_file_div").hide();
      $("#client_insurance_declaration_file_div").hide();
      $('#containerlist_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });
      $('#par-form').validate({
        errorClass: "my-error-class"
      });
      if($("input[name='insurance_by']:checked").val() == 'Client'){
        enableClientInsuranceFile();
      }

      if($("input[name='insurance_declaration']:checked").val() == 'Yes'){
        enableClientInsuranceDeclararionFile();
      }

      $('#bol_awb_no').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#qty_units').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#boe_num').rules("add", { regex: "^[0-9]{1,8}$" });
      $('#bol_awb_date').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });
      $('#boe_date').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });
      $('#expected_date').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });
      $('#cargo_life').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });
      $('#shelf_life').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });

    });

    //Date picker
    var startDate = new Date();
    $('#expected_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });
    $('#cargo_life').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });
    $('#shelf_life').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });

    $('.autofillparty').autocomplete({
      source : "auto-complete-services.php?action=fetch_party_info",
      minLength : 2,
      select : function(event, ui) {
              
              if(ui.item.value == "No customers found"){
                event.preventDefault();
                // $('#customer_name').val('');
                console.log('s');
              }else{
              }
          },
    });

    $('.autofillunit').autocomplete({
      source : "auto-complete-services.php?action=fetch_unit_info",
      minLength : 2,
      select : function(event, ui) {
              
              if(ui.item.value == "No customers found"){
                event.preventDefault();
              }else{
              }
          },
    });

    function updateClicked(){
      $('#action_hidden_text').val('update_par');
    }

    gContainerList = <?php echo json_encode($containerOutput); ?>;
    for(i = 0; i < gContainerList.length; i++){
      gContainerList[i].container_details = JSON.parse(gContainerList[i].container_details);
    }
    displayContainersInEditMode();

    var isEditPage = false;// used to redirect to par-apprvoe-reject-view.php when update method is called

    <?php if($row['status'] != 'submitted'){ ?>
      $('.delete_btn_span').hide();
    <?php } ?>

  </script>
  <?php
    include('../footer.php');
  ?>
