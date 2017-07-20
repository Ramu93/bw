
  <?php
    include('../header.php');
    include('../sidebar.php');
    require('../dbconfig.php'); 

    $out = array();
    $igpLoID = $_GET['igp_lo_id'];
    $select = "SELECT * FROM general_igp_loading WHERE igp_lo_id='$igpLoID'";
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
        In Gate Pass - Outward
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="igp-loading-form" name="igp-loading-form" action="#" method="post" onsubmit="return false;">
            <div id="print-div">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="igp_unloading_id">IGP Loading ID</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['igp_lo_id']; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="date">Date</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['entry_date']; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="date" id="time">Time:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['time_in']; ?></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <label for="select_by_label">Choosen By:</label>
                  <div class="clearfix"></div>
                  <label>
                    <?php 
                        switch($out['data_type']){
                          case 'pdr_id':
                            echo 'PDR ID';
                          break;
                          case 'boe_number':
                            echo 'BOE Number';
                          break;
                          case 'bond_number':
                            echo 'Bond Number';
                          break;
                        }
                    ?>
                  </label>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="data_value">
                      <?php 
                        switch($out['data_type']){
                          case 'pdr_id':
                            echo 'PDR ID';
                          break;
                          case 'boe_number':
                            echo 'BOE Number';
                          break;
                          case 'bond_number':
                            echo 'Bond Number';
                          break;
                        }
                    ?>
                    </label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['data_value']; ?></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="vehicle_number">Vehicle Number:</label>
                    <div class="clearfix"></div>
                    <label><?php echo $out['vehicle_number']; ?></label>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="driver_name">Driver Name:</label>
                  <div class="clearfix"></div>
                    <label><?php echo $out['driver_name']; ?></label>
                </div>
                <div class="col-md-4">
                  <label for="driver_license">Driving License:</label>
                  <div class="clearfix"></div>
                    <label><?php echo $out['driving_license']; ?></label>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="container_number">Container Number:</label>
                  <div class="clearfix"></div>
                  <label><?php //echo $out['container_number']; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <label for="seal_number">Seal Number:</label>
                <div class="clearfix"></div>
                <label><?php //echo $out['seal_number']; ?></label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="container_condition">Container Condition:</label>
                  <div class="form-group">
                    <div class="clearfix"></div>
                    <label><?php //echo $out['container_condition']; ?></label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <label for="vehicle_type">Vehicle Type:</label>
                <div class="clearfix"></div>
                <label><?php //echo $out['vehicle_type']; ?></label>
              </div>
              <div class="col-md-4">
                <label for="transporter_name">Transporter Name:</label>
                <div class="clearfix"></div>
                <label><?php //echo $out['transporter_name']; ?></label>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" value="Print Gate Pass" class="btn btn-primary btn-block pull-left" onclick="printData('print-div')">
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
