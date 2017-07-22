<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Job order Loading - Outward Process
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="job_order_loading_form" name="job_order_loading_form" action="#" method="post" onsubmit="return false;">
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
            <div class="row" id="space_data">
              <div class="col-md-4">
                <label>Space Occupied Before Loading</label>
                <input type="text" tabindex="6" class="form-control required" id="space_occupied_before" name="space_occupied_before" readonly="true">
              </div>
              <div class="col-md-4">
                <label>Space Occupied After Loading</label>
                <input type="text" tabindex="6" class="form-control required" id="space_occupied_after" name="space_occupied_after" placeholder="Space Occupied After Loading">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
              <label>Name of the Supervisor</label>
                <input type="text" tabindex="6" class="form-control required" id="supervisor_name" name="supervisor_name" placeholder="Supervisor Name">
              </div>
              <div class="col-md-4">
                <label for="unloading_type">Type of Loading</label>
                <select class="form-control" tabindex="9" id="loading_type" name="loading_type">
                  <option value="1">Manual 100%</option>
                  <option value="2">75% Manual + 25% FLT</option>
                  <option value="3">50% Manual + 50% FLT 25%-</option>
                  <option value="4">Manual 75% + FLT FLT100%-</option>
                  <option value="5">Crane + Manual Spl</option>
                  <option value="6">Equipments + Manual</option>
                </select>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="equipment_ref_number">Equipment Reference Number</label>
                  <input type="text" tabindex="10" class="form-control" id="equipment_ref_number" name="equipment_ref_number" placeholder="Equipment reference number">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_of_labors">Number of labors</label>
                  <input type="text" tabindex="" class="form-control required" id="no_of_labors" name="no_of_labors" placeholder="Number of labors">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="unloading_time">Time for Loading</label>
                  <input type="text" tabindex="" class="form-control required" id="loading_time" name="loading_time" placeholder="Time for loading">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table id="view_items_table" class="table table-striped table-bordered" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Despatch Qty.</th>
                    </tr>
                  </thead>
                  <tbody id="item_list_tbody">
                   
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" value="Create Job Order" class="btn btn-primary btn-block pull-left" onclick="createJobOrder();">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

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

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/job-order/js/job-order-loading.js"></script>
  <script type="text/javascript">

    $('#loading_type').on('change', function() {
      var loadingType = $('#loading_type').val();
      if(loadingType == 1){
        $('#equipment_ref_number').removeAttr('required');
      } else {
        $('#equipment_ref_number').attr('required','true');
      }
    })

    $('#job_order_loading_form').validate({
        errorClass: "my-error-class"
    });

    //initial value of label
    $('#fetch_by_label').html('Customer Name');
    //change label name according to selected value
    $('#select_by_type').on('change', function() {
      $('#data_item').val('');
      changeLabelText();
    })

    $('#pdr_data').hide();
    $('#space_data').hide();
    $('#view_items_table').hide();
  </script>
  <?php
    include('../footer.php');
  ?>
