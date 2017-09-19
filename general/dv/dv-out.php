<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $pdrID = $_GET['pdr_id'];
  $select = "SELECT * FROM general_despatch_request WHERE pdr_id='$pdrID'";
  $query = mysqli_query($dbc,$select);
  $out = array();
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
    //file_put_contents("editlog.log", print_r( json_encode($containerOutput), true ));
  }
?>

<style type="text/css">
  .modal{
    width: 80%; /* respsonsive width */
    margin-left:-40%; /* width/2) */ 
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Document Verification - Outward
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-body">
        <form id="document_verification_form" name="document_verification_form" action="#" method="post" onsubmit="return false;">
        <input type="hidden" name="pdr_id" value="<?php echo $pdrID; ?>">
            <!-- <div class="row" id="fields">
              <div class="form-group col-md-4">
                <label for="sac_par_id" id="sac_par_table_label"></label>
                <input type="text" class="form-control" id="sac_par_id" name="sac_par_id" readonly="true">
                <input type="hidden" class="form-control" id="sac_par_table" name="sac_par_table">
              </div>
            </div> -->
            <div class="row">
              <div class="form-group col-md-3">
                <label for="client_web">Client Web</label>
                <div class="clearfix"></div>
                <label><?php echo $out['client_web']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="order_number">CHA Name/Exporter</label>
                <div class="clearfix"></div>
                <label><?php echo $out['cha_name']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="order_number">Order Number</label>
                <div class="clearfix"></div>
                <label><?php echo $out['order_number']; ?></label>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="boe_number">BOE Number</label>
                <div class="clearfix"></div>
                <label><?php echo $out['boe_number']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_number">EXBond BE Number</label>
                <div class="clearfix"></div>
                <label><?php echo $out['exbond_be_number']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_date">EXBond BE Date</label>
                <div class="clearfix"></div>
                <label><?php echo $out['exbond_be_date']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="customs_officer_name">Customer Officer Name</label>
                <div class="clearfix"></div>
                <label><?php echo $out['customs_officer_name']; ?></label>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="packages_number">Number of Packages</label>
                <div class="clearfix"></div>
                <label><?php echo $out['number_of_packages']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="assessment_value">Assessment Value</label>
                <div class="clearfix"></div>
                <label><?php echo $out['assessment_value']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="duty_value">Duty Value</label>
                <div class="clearfix"></div>
                <label><?php echo $out['duty_value']; ?></label>
              </div>
              <div class="form-group col-md-3">
                <label for="transporter_name">Transporter Name</label>
                <div class="clearfix"></div>
                <label><?php echo $out['transporter_name']; ?></label>
              </div>
            </div>
            <table id="pdr_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Container Number</th>
                  <th>Item Name</th>
                  <th>Item Qty.</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $select_query = "SELECT * FROM general_pdr_items WHERE pdr_id='$pdrID'";
                  $result = mysqli_query($dbc,$select_query);
                  $row_counter = 0;
                  if(mysqli_num_rows($result) > 0) {
                    $dataTableFlag = true;
                    while($itemRow = mysqli_fetch_array($result)) {
                      echo "<tr>";
                      echo "<td>".++$row_counter."</td>";
                      echo "<td>".$itemRow['container_number']."</td>";
                      echo "<td>".$itemRow['item_name']."</td>";
                      echo "<td>".$itemRow['despatch_qty']."</td>";
                      echo "</tr>";
                    }
                  } else {
                    $dataTableFlag = false;
                    echo "<tr><td colspan=\"6\">No PDRs available.</td></tr>";
                  }
                ?>
              </tbody>
            </table>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <input type="checkbox" name="exboe_original_check" id="exboe_original_check" value="yes"> Ex Bond BOE
                  <input type="hidden" name="exboe_original" id="exboe_original" value="">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <input type="checkbox" name="order_number_check" id="order_number_check" value="yes"> Release Order
                  <input type="hidden" name="order_number" id="order_number" value="">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <input type="checkbox" name="vehicle_number_check" id="vehicle_number_check" value="yes"> Vehicle Number
                  <input type="hidden" name="vehicle_number" id="vehicle_number" value="">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <input type="checkbox" name="license_number_check" id="license_number_check" value="yes"> License Number
                  <input type="hidden" name="license_number" id="license_number" value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-4">
                
              </div>
              
              <div class="col-md-3 col-sm-4">
                <input type="submit" id="update_pdr_btn" name="submit" value="Submit" class="btn btn-primary btn-block pull-left" onclick="submitDocumentVerification(<?php echo $out['pdr_id']; ?>)">
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
<script type="text/javascript" src="<?php echo HOMEURL; ?>/dv/js/dv-out.js"></script>
<script type="text/javascript">

  $(document).ready(function(){

    getSelectedtContainerData();

    $('#do_verification_check').change(function() {
      if($(this).is(":checked")) {
          $('#dv_submit_button').prop('disabled', false);
      } else {
          $('#dv_submit_button').prop('disabled', true);
      }      
    });

    $('#document_verification_form').validate({
      errorClass: "my-error-class" //error class defined in header file style tag
    });

    var startDate = new Date();
    $('#do_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });

    $('#bond_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });
  });
</script>
<?php
  include('../footer.php');
?>
