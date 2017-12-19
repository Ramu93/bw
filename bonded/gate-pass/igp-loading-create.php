<?php
  include('../header.php');
  include('../sidebar.php');
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
                  <option value="pdr_id">PDR ID</option>
                  <option value="boe_number">BOE Number</option>
                  <option value="bond_number">Bond Number</option>
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
            <div id="pdr_data">
              <div class="row">
                <div class="col-md-3">
                  <label>PDR ID</label>
                  <div class="clearfix"></div>
                  <label id="pdr_id_label"></label>
                  <input type="hidden" name="pdr_id_hidden" id="pdr_id_hidden">
                </div>
                <div class="col-md-3">
                  <label>Bond Number</label>
                  <div class="clearfix"></div>
                  <label id="bond_number_label"></label>
                </div>
                <div class="col-md-3">
                  <label>BOE Number</label>
                  <div class="clearfix"></div>
                  <label id="boe_number_label"></label>
                </div>
                <div class="col-md-3">
                  <label>Client Web</label>
                  <div class="clearfix"></div>
                  <label id="client_web_label"></label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <label>CHA Name</label>
                  <div class="clearfix"></div>
                  <label id="cha_name_label"></label>
                </div>
                <div class="col-md-3">
                  <label>ExBond BE Number</label>
                  <div class="clearfix"></div>
                  <label id="exbond_be_number_label"></label>
                </div>
                <div class="col-md-3">
                  <label>ExBond BE Date</label>
                  <div class="clearfix"></div>
                  <label id="exbond_be_date_label"></label>
                </div>
                <!-- <div class="col-md-3">
                  <label>Customs Officer Name</label>
                  <div class="clearfix"></div>
                  <label id="customs_officer_name_label"></label>
                </div> -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="vehicle_number">Vehicle Number</label>
                  <input type="text" tabindex="4" class="form-control required" id="vehicle_number" name="vehicle_number" placeholder="Vehicle number">
                </div>
              </div>
              <div class="col-md-3">
                <label for="driver_name">Driver Name</label>
                <input type="text" tabindex="5" class="form-control required" id="driver_name" name="driver_name" placeholder="Driver name">
              </div>
              <div class="col-md-3">
                <label for="driver_license">Driving License</label>
                <input type="text" tabindex="6" class="form-control required" id="driving_license" name="driving_license" placeholder="Driving license">
              </div>
              <div class="col-md-3">
                <label for="time_in">Time In</label>
                <input type="hidden" tabindex="-1" class="form-control required" id="entry_date" name="entry_date" >
                <input type="text" tabindex="7" class="form-control required" id="time_in" name="in_time" placeholder="">
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="container_number">Container Number</label>
                  <select name="container_number" id="container_number_select" class="form-control required">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <label for="seal_number">Seal Number</label>
                <input type="text" tabindex="8" class="form-control required" id="seal_number" name="seal_number" placeholder="Seal number">
              </div>            
            </div> -->
            <!-- <div class="row">
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
                <label for="vehicle_type">Vehicle Type</label>
                <select class="form-control" tabindex="11" id="vehicle_type" name="vehicle_type">
                  <option value="20">20</option>
                  <option value="40">40</option>
                  <option value="LCL">LCL</option>
                  <option value="Break Bulk">Break Bulk</option>
                  <option value="ODC">ODC</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="transporter_name">Transporter Name</label>
                <input type="text" tabindex="12" class="form-control required" id="transporter_name" name="transporter_name" placeholder="Transporter name" >
              </div>
            </div>
            <input type="hidden" name="sac_par_table" id="sac_par_table" value="">
            <input type="hidden" name="sac_par_id" id="sac_par_id" value=""> -->
            <!-- <div class="clearfix"></div>
            <div id="container_data_div" class="responsive">
              
            </div> -->
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" tabindex="8" value="Generate Gate Pass" class="btn btn-primary btn-block pull-left" onclick="generateIGP();">
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
      $('#igp-loading-form').validate({
        errorClass: "my-error-class"
      });

      // auto load time and date
      $('#time_in').val(setTime());
      $('#entry_date').val(setDate());

      //alert(setTime() + " " + setDate());

      //initial value of label
      $('#fetch_by_label').html('PDR ID');
      //change label name according to selected value
      $('#select_by_type').on('change', function() {
        $('#data_item').val('');
        changeLabelText();
      })

      $('#pdr_data').hide();

      $('#driver_name').rules("add", { regex: "^[a-zA-Z ]+$" });
      $('#driving_license').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#vehicle_number').rules("add", { regex: "^[0-9a-zA-Z ]{0,13}$" });
    });

  </script>
  <?php
    include('../footer.php');
  ?>
