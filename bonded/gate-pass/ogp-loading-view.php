<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $out = array();
  $ogpId = $_GET['ogp_lo_id'];
  $select = "SELECT ol.ogp_lo_id, ol.jl_id, jl.pdr_id, il.vehicle_number, il.driver_name, il.driving_license, ol.status FROM bonded_ogp_loading ol, bonded_joborder_loading jl, bonded_igp_loading il WHERE ol.jl_id=jl.jl_id AND jl.pdr_id=il.pdr_id AND ogp_lo_id='$ogpId'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
  }
  // file_put_contents("editlog.log", print_r( $out, true ));

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Out Gate Pass - Outward
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="igp-unloading-form" name="igp-unloading-form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="pdr_id_hidden" id="pdr_id_hidden" value="<?php echo $out['pdr_id']; ?>">
            <div id="print-div">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">OGP Loading ID:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['ogp_lo_id']; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="date">Vehicle Number:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['vehicle_number']; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="date" id="time">Driver Name:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['driver_name']; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="date" id="time">Driving License:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['driving_license']; ?></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4">
                  <div class="form-group">
                    <label for="date" id="time">Item Total Qty.:</label>
                    <div class="clearfix"></div>
                    <label id="item_total_qty"></label>
                  </div>
                </div>
                <?php if($out['status'] == 'created') { ?>
                  <div class="col-md-4 col-sm-4">
                    <input type="submit" name="submit" value="Vehicle Left" class="btn btn-primary btn-block pull-left" onclick="setVehicleLeftTimeStamp(<?php echo $ogpId; ?>)">
                  </div>
                <?php } ?>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/gate-pass/js/loading-gate-pass.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#igp-unloading-form').validate({
        errorClass: "my-error-class"
      });

      // auto load time and date
      $('#time_in').val(setTime());
      $('#entry_date').val(setDate());

      //alert(setTime() + " " + setDate());

     
      //change label name according to selected value
      $('#select_by_type').on('change', function() {
        $('#data_item').val('');
        changeLabelText();
      })

      //load pdr items table
      getPDRItemsCount();

    });

    
    //auto load time ends

    //Date picker
    var startDate = new Date();
    $('#expected_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });
  </script>
  <?php
    include('../footer.php');
  ?>
