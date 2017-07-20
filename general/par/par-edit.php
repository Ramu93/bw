
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
      $containerSelect = "SELECT * FROM sac_par_container_info WHERE id='$parID' AND added_from='par'";
      $result = mysqli_query($dbc,$containerSelect);
      $containerOutput = array();
      if(mysqli_num_rows($result) > 0){
        while ($containerRow = mysqli_fetch_array($result)) {
          $containerOutput[] = array (
           'dimension'=>$containerRow['dimension'],
           'container_count' => $containerRow['container_count'],
           'container_details'=> $containerRow['container_details']
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
        Pre Arrival Request - Edit
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
                  <label for="importing_firm_name">Name of the Importing Firm</label>
                  <input type="text" tabindex="1" class="form-control required" id="importing_firm_name" name="importing_firm_name" placeholder="Name of the importing firm" value="<?php echo $row['importing_firm_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="bol_awb_no">BOL/AWB Number</label>
                  <input type="text" tabindex="3" class="form-control required" id="bol_awb_no" name="bol_awb_number" placeholder="BOL/AWB Number" value="<?php echo $row['bol_awb_number']; ?>">
                </div>
                <div class="form-group">
                  <label for="material_name">Name of the Material</label>
                  <input type="text" tabindex="5" class="form-control required" id="material_name" name="material_name" placeholder="Name of the Material" value="<?php echo $row['material_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="packing_nature">Nature of Packing</label>
                  <select class="form-control" tabindex="7" id="packing_nature" name="packing_nature">
                    <option value="Metal Drum" <?php echo (($row['packing_nature']=='Metal Drum')?'selected="selected"':''); ?> >Metal Drum</option>
                    <option value="Fibre Drum" <?php echo (($row['packing_nature']=='Fibre Drum')?'selected="selected"':''); ?> >Fibre Drum</option>
                    <option value="Wooden Crate Bags Cartons" <?php echo (($row['packing_nature']=='Wooden Crate Bags Cartons')?'selected="selected"':''); ?>>Wooden Crate Bags Cartons</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="qty_units">Assessable Value</label>
                  <input type="text" tabindex="9" class="form-control required" id="assessable_value" name="assessable_value" placeholder="Assessable Value" value="<?php echo $row['assessable_value']; ?>">
                </div>
                <div class="form-group">
                  <label for="material_nature">Nature of Materials</label>
                  <select class="form-control" tabindex="11" id="material_nature" name="material_nature" required="">
                    <option value="Non Hazardous" <?php echo (($row['material_nature']=='Non Hazardous')?'selected="selected"':''); ?> >Non Hazardous</option>
                    <option value="Hazardous" <?php echo (($row['material_nature']=='Hazardous')?'selected="selected"':''); ?> >Hazardous</option>
                    <option value="Chemcals Compositor" <?php echo (($row['material_nature']=='Chemcals Compositor')?'selected="selected"':''); ?> >Chemcals Compositor</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cargo_life">Cargo Life</label>
                  <input type="text" tabindex="13" class="form-control required" id="cargo_life" name="cargo_life" placeholder="Cargo Life" value="<?php echo $row['cargo_life']; ?>" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="licence_code">Licence Code</label>
                  <input type="text" tabindex="2" class="form-control required" id="licence_code" name="licence_code" placeholder="Licence code" value="<?php echo $row['licence_code']; ?>">
                </div>
                <div class="form-group">
                  <label for="boe_num">BOE Number</label>
                  <input type="text" tabindex="4" class="form-control required" id="boe_num" name="boe_number" placeholder="BOE Number" value="<?php echo $row['boe_number']; ?>">
                </div>            
                <div class="form-group">
                  <label for="qty_units">Quantity in Number of Units</label>
                  <input type="text" tabindex="6" class="form-control required" id="qty_units" name="qty_units" placeholder="Quantity in No of units" value="<?php echo $row['qty_units']; ?>">
                </div>
                <div class="form-group">
                  <label for="space_requirement">Requirement of Space</label>
                  <input type="text" tabindex="8" class="form-control required" id="space_req" name="space_requirement" placeholder="Requirement of Space" value="<?php echo $row['space_requirement']; ?>">
                </div>
                <div class="form-group">
                  <label for="duty_amount">Duty Amount in Rupees</label>
                  <input type="text" tabindex="10" class="form-control required" id="duty_amount" name="duty_amount" placeholder="Duty Amount in Rupees" value="<?php echo $row['duty_amount']; ?>">
                </div>
                <div class="form-group">
                  <label for="expected_date">Expected Date of Warehousing</label>
                  <input type="text" tabindex="12" class="form-control required" id="expected_date" name="expected_date" placeholder="Expected Date of Warehousing" value="<?php echo $row['expected_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="shelf_life">Shelf Life</label>
                  <input type="text" tabindex="14" class="form-control required" id="shelf_life" name="shelf_life" placeholder="Shelf Life" value="<?php echo $row['shelf_life']; ?>" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="required_period">Required Period of Warehousing</label>
                  <input type="text" tabindex="15" class="form-control required" id="required_period_of_warehousing" name="required_period" placeholder="Required Period of Warehousing" value="<?php echo $row['required_period']; ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="insurance_by">Insurance By</label>
                  <div class="form-group">
                    <input type="radio" tabindex="16" id="insurance_by" name="insurance_by" value="TRLPL" <?php echo (($row['insurance_by']=='TRLPL')?'checked':''); ?> onclick="disableClientInsuranceFile();"> TRLPL &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="17" id="insurance_by" name="insurance_by" value="Client" <?php echo (($row['insurance_by']=='Client')?'checked':''); ?> onclick="enableClientInsuranceFile();"> Client
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
                    <input type="radio" tabindex="18" id="insurance_declaration" name="insurance_declaration" value="Yes" <?php echo (($row['insurance_declaration']=='Yes')?'checked':''); ?> onclick="enableClientInsuranceDeclararionFile();"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="19" id="insurance_declaration" name="insurance_declaration" value="No" <?php echo (($row['insurance_declaration']=='No')?'checked':''); ?> onclick="disableClientInsuranceDeclararionFile();"> No
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
            <input type="hidden" name="action" value="update_par">
            <input type="hidden" id="container_stringified" name="container_stringified" >
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <input type="submit" name="submit" value="Update PAR" class="btn btn-primary btn-block pull-left" onclick="updatePAR(<?php echo $parID; ?>);">
              </div>
              <div class="col-md-6 col-sm-6">
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

    gContainerList = <?php echo json_encode($containerOutput); ?>;
    for(i = 0; i < gContainerList.length; i++){
      gContainerList[i].container_details = JSON.parse(gContainerList[i].container_details);
    }
    displayContainersInEditMode();

    var isEditPage = true;// used to redirect to par-view.php when update method is called

  </script>
  <?php
    include('../footer.php');
  ?>
