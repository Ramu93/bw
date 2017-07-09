
  <?php
    include('../header.php');
    include('../sidebar.php');
    require('../dbconfig.php'); 

    $out = array();
    $ogpId = $_GET['ogp_un_id'];
    $select = "SELECT ou.ogp_un_id, ju.ju_id, ju.sac_par_table, ju.sac_par_id, iu.vehicle_number, iu.driver_name, iu.driving_license FROM ogp_unloading ou, joborder_unloading ju, igp_unloading iu WHERE ou.ju_id=ju.ju_id AND ju.sac_par_table=iu.sac_par_table AND ju.sac_par_id=iu.sac_par_id AND ogp_un_id='$ogpId'";
    $query = mysqli_query($dbc,$select);
    if(mysqli_num_rows($query) > 0) {
      $row = mysqli_fetch_array($query);
      $out = $row;
    }
    //file_put_contents("editlog.log", print_r( $out, true ));

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Out Gate Pass - Inward
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="igp-unloading-form" name="igp-unloading-form" action="#" method="post" onsubmit="return false;">
            <div id="print-div">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">OGP Unloading ID:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['ogp_un_id']; ?></label>
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
                  
                </div>
                <div class="col-md-4 col-sm-4">
                  <input type="submit" name="submit" value="Vehicle Left" class="btn btn-primary btn-block pull-left" onclick="setVehicleLeftTimeStamp(<?php echo $ogpId; ?>)">
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/gate-pass/js/unloading-gate-pass.js"></script>
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
      getPDRItems();

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
