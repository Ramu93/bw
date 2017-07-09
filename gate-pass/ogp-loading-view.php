
  <?php
    include('../header.php');
    include('../sidebar.php');
    require('../dbconfig.php'); 

    $out = array();
    $ogpId = $_GET['ogp_lo_id'];
    $select = "SELECT ol.ogp_lo_id, ol.jl_id, jl.pdr_id, il.vehicle_number, il.driver_name, il.driving_license FROM ogp_loading ol, joborder_loading jl, igp_loading il WHERE ol.jl_id=jl.jl_id AND jl.pdr_id=il.pdr_id AND ogp_lo_id='$ogpId'";
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
            <div id="print-div">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="igp_unloading_id">OGP Loading ID:</label>
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

  <!--Container Modal Div -->
  <div class="modal fade" id="view_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form  id="dataapprovedlist_form" name="dataapprovedlist_form" method="post" class="validator-form1" action="" onsubmit="return false;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <div class="modal-body">
              <div class="responsive">
                <table id="tariff_master_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th>S.No</th>
                              <th id="data_name"></th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody id="datalist_tbody">
                       
                      </tbody>
                  </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
    </div>
  </div>


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
