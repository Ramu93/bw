
  <?php
    include('../header.php');
    include('../sidebar.php');
    include('../dbconfig.php');

    $sacID = $_GET['sac_id'];
    $select = "SELECT * FROM sac_request WHERE sac_id='$sacID'";
    $query = mysqli_query($dbc,$select);
    if(mysqli_num_rows($query) > 0) {
      $row = mysqli_fetch_array($query);
      //loading containers from db
      $containerSelect = "SELECT * FROM sac_par_container_info WHERE id='$sacID' AND added_from='sac'";
      $result = mysqli_query($dbc,$containerSelect);
      $containerOutput = array();
      if(mysqli_num_rows($result) > 0){
        while ($containerRow = mysqli_fetch_array($result)) {
          $containerOutput[] = array (
           'dimension'=>$containerRow['dimension'],
           'qty_numbers' => $containerRow['qty_numbers'],
           'container_weight'=> $containerRow['container_weight'],
           'vehicle_number' => $containerRow['vehicle_number']
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
        Request for Issue of Space Availability Certificate - Approve/Reject
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="sac-req-form" name="sac-req-form" action="#" method="post" onsubmit="return false;">
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
                    <option value="Wooden Crate Bags Cartons" <?php echo (($row['packing_nature']=='Wooden Crate Bags Cartons')?'selected="selected"':''); ?> >Wooden Crate Bags Cartons</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="qty_units">Assessable Value</label>
                  <input type="text" tabindex="9" class="form-control required" id="assessable_value" name="assessable_value" placeholder="Assessable Value" value="<?php echo $row['assessable_value']; ?>">
                </div>
                <div class="form-group">
                  <label for="material_nature">Nature of Materials</label>
                  <select class="form-control" tabindex="11" id="material_nature" name="material_nature">
                    <option value="Non Hazardous" <?php echo (($row['material_nature']=='Non Hazardous')?'selected="selected"':'');  ?> >Non Hazardous</option>
                    <option value="Hazardous" <?php echo (($row['material_nature']=='Hazardous')?'selected="selected"':''); ?> >Hazardous</option>
                    <option value="Chemcals Compositor" <?php echo (($row['material_nature']=='Chemcals Compositor')?'selected="selected"':''); ?> >Chemcals Compositor</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="expected_date">Required Period of Warehousing</label>
                  <input type="text" tabindex="13" class="form-control required" id="required_period_of_warehousing" name="required_period" placeholder="Required Period of Warehousing" value="<?php echo $row['expected_date']; ?>">
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
                  <label for="qty_units">Requirement of Space</label>
                  <input type="text" tabindex="8" class="form-control required" id="space_req" name="space_requirement" placeholder="Requirement of Space" value="<?php echo $row['space_requirement']; ?>">
                </div>
                <div class="form-group">
                  <label for="qty_units">Duty Amount in Rupees</label>
                  <input type="text" tabindex="10" class="form-control required" id="duty_amount" name="duty_amount" placeholder="Duty Amount in Rupees" value="<?php echo $row['duty_amount']; ?>">
                </div>
                <div class="form-group">
                  <label for="expected_date">Expected Date of Warehousing</label>
                  <input type="text" tabindex="12" class="form-control required" id="expected_date" name="expected_date" placeholder="Expected Date of Warehousing" value="<?php echo $row['expected_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="insurance_by">Insurance By</label>
                  <div class="form-group">
                    <input type="radio" tabindex="14" id="insurance_by" name="insurance_by" value="TRLPL" <?php echo (($row['insurance_by']=='TRLPL')?'checked':''); ?>> TRLPL &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="15" id="insurance_by" name="insurance_by" value="Client" <?php echo (($row['insurance_by']=='Client')?'checked':''); ?> > Client
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <input type="button" name="approve_par" value="Approve SAC Request" class="btn btn-success btn-block pull-left" onclick="approveSACRequest(<?php echo $sacID; ?>);">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="button" name="reject_par" value="Reject SAC Request" class="btn btn-primary btn-block pull-left" onclick="rejectSACRequest(<?php echo $sacID; ?>);">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="submit" name="submit" value="Update SAC Request" class="btn btn-primary btn-block pull-left" onclick="updateSACRequest(<?php echo $sacID; ?>);">
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

 

  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/sac/js/sac.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#containerlist_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });
      $('#sac-req-form').validate({
        errorClass: "my-error-class"
      });
    });


    //Date picker
    var startDate = new Date();
    $('#expected_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });

    var isEditPage = false; // used to redirect to sac-request-approve-reject-view.php when update method is called

    // $('#vehicle_number').spinner({
    //   min: 1,
    //   max: 6,
    //   stop: function( event, ui ){
    //           vehicleSpinner();
    //       }
    // });
  </script>
  <?php
    include('../footer.php');
  ?>
