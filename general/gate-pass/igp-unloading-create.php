<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        In Gate Pass - Inward
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="igp-unloading-form" name="igp-unloading-form" action="#" method="post" onsubmit="return false;">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fetch_by_type" id="fetch_by_label">#</label>
                  <input type="text" tabindex="1" class="form-control required" id="data_item" name="data_item" placeholder="">
                </div>
              </div>
              <div class="col-md-3">
                <label for="select_by_label">Choose By</label>
                <select class="form-control" tabindex="2" id="select_by_type" name="select_by_type">
                  <option value="customer_name">Customer Name</option>
                  <option value="boe_number">BOE Number</option>
                  <option value="par">PAR</option>
                </select>
              </div>
              <div class="col-md-3">
                <div class="clearfix">&nbsp;</div>
                <input type="button" tabindex="3" name="view_list_button" value="View List" class="btn btn-primary btn-block pull-left" onclick="getDataList();">
              </div>
              <div class="col-md-3">
                <div class="control-group">
                  <div class="clearfix">&nbsp;</div>
                  <span id="data_fetch_message"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="id_label"></label>
                <div class="clearfix"></div>
                <label id="id_value"></label>
              </div>
              <div class="col-md-3">
                <label id="customer_name_label"></label>
                <div class="clearfix"></div>
                <label id="customer_name_value"></label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label for="vehicle_type">Vehicle Type</label>
                <select class="form-control" tabindex="4" id="vehicle_type" name="vehicle_type">
                  <option value="20">20</option>
                  <option value="40">40</option>
                  <option value="ODC">ODC</option>
                  <option value="Break Bulk">Break Bulk</option>
                  <option value="LCL">LCL</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="driver_name">Driver Name</label>
                <input type="text" tabindex="5" class="form-control required" id="driver_name" name="driver_name" placeholder="Driver name">
              </div>
              <div class="col-md-4">
                <label for="driver_license">Driving License</label>
                <input type="text" tabindex="6" class="form-control required" id="driving_license" name="driving_license" placeholder="Driving license">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4" id="container_tonnage_div">
                <div class="form-group">
                  <label for="container_number">Container Number</label>
                  <select name="container_number" tabindex="7" id="container_number_select" class="form-control required">
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-4">
                <label for="seal_number">Seal Number</label>
                <input type="text" tabindex="8" class="form-control required" id="seal_number" name="seal_number" placeholder="Seal number">
              </div> -->
              <div class="col-md-4">
                <label for="time_in">Time In</label>
                <input type="hidden" tabindex="-1" class="form-control required" id="entry_date" name="entry_date" >
                <input type="text" tabindex="-8" class="form-control required" id="time_in" name="in_time" placeholder="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="container_condition">Container Condition</label>
                  <div class="form-group">
                    <input type="radio" tabindex="9" id="container_condition_good" name="container_condition" value="Good" checked> Good &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="10" id="container_condition_bad" name="container_condition" value="Bad"> Bad
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                
                <div class="form-group">
                  <label for="vehicle_number">Vehicle Number</label>
                  <input type="text" tabindex="11" class="form-control required" id="vehicle_number" name="vehicle_number" placeholder="Vehicle number">
                </div>
              </div>
              <div class="col-md-4">
                <label for="transporter_name">Transporter Name</label>
                <input type="text" tabindex="12" class="form-control required" id="transporter_name" name="transporter_name" placeholder="Transporter name" >
              </div>
            </div>
            <input type="hidden" name="par_id" id="par_id" value="">
            <!-- <div class="clearfix"></div>
            <div id="container_data_div" class="responsive">
              
            </div> -->
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" value="Generate Gate Pass" class="btn btn-primary btn-block pull-left" onclick="generateIGP();">
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

      //initial value of label
      $('#fetch_by_label').html('Customer Name');
      //change label name according to selected value
      $('#select_by_type').on('change', function() {
        $('#data_item').val('');
        changeLabelText();
      })

      $('#vehicle_type').on('change', function(){
        replaceContainerTonnageFields();
      });

      $('#driver_name').rules("add", { regex: "^[a-zA-Z ]+$" });
      $('#driving_license').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#vehicle_number').rules("add", { regex: "^[0-9a-zA-Z ]{0,13}$" });
      $('#transporter_name').rules("add", { regex: "^[a-zA-Z ]+$" });

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
