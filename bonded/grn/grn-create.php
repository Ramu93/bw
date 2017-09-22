<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Goods Receipt Note - Create
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="grn_form" name="grn_form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="sac_id" id="sac_id" value="">
            <input type="hidden" name="ju_id" id="ju_id" value="">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="" id="">Job Order ID:</label>
                  <input type="text" tabindex="1" class="form-control" id="job_order_id" name="job_order_id" placeholder="">
                </div>
              </div>
              <!-- <div class="col-md-3">
                <label for="select_by_label">Choose By</label>
                <select class="form-control" tabindex="2" id="select_by_type" name="select_by_type">
                  <option value="customer_name">Customer Name</option>
                  <option value="boe_number">BOE Number</option>
                  <option value="par">PAR</option>
                  <option value="sac">SAC</option>
                  <option value="igp">IGP</option>
                </select>
              </div> -->
              <div class="col-md-3">
                <div class="clearfix">&nbsp;</div>
                <input type="button" tabindex="3" name="view_list_button" value="View List" class="btn btn-primary btn-block pull-left" onclick="getJobOrderList();">
              </div>
              <div class="col-md-3">
                <div class="control-group">
                  <div class="clearfix">&nbsp;</div>
                  <span id="data_fetch_message"></span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-2">
                <label id="id_label"></label>
                <div class="clearfix"></div>
                <label id="id_value"></label>
              </div>
              <div class="col-md-3">
                <label id="customer_name_label"></label>
                <div class="clearfix"></div>
                <label id="customer_name_value"></label>
              </div>
              <div class="col-md-3">
                <label id="bond_number_label"></label>
                <div class="clearfix"></div>
                <label id="bond_number_value"></label>
              </div>
              <div class="col-md-3">
                <label id="end_time_label"></label>
                <div class="clearfix"></div>
                <label id="end_time_value"></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4">
                <label id="licence_code_label"></label>
                <div class="clearfix"></div>
                <label id="licence_code"></label>
              </div>
              <div class="col-md-4">
                <label id="bol_awb_number_label"></label>
                <div class="clearfix"></div>
                <label id="bol_awb_number"></label>
              </div>
              <div class="col-md-4">
                <label id="boe_number_label"></label>
                <div class="clearfix"></div>
                <label id="boe_number"></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4">
                <label id="material_name_label"></label>
                <div class="clearfix"></div>
                <label id="material_name"></label>
              </div>
              <div class="col-md-4">
                <label id="material_nature_label"></label>
                <div class="clearfix"></div>
                <label id="material_nature"></label>
              </div>
              <div class="col-md-4">
                <label id="packing_nature_label"></label>
                <div class="clearfix"></div>
                <label id="packing_nature"></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" id="fields">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="space_occupied">No. of Units</label>
                  <input type="text" tabindex="2" class="form-control required" id="no_of_units" name="no_of_units" placeholder="No. of units">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="space_occupied">Unit</label>
                  <select class="form-control required" id="unit" name="unit">
                    <option value="" selected="selected">Select unit...</option>
                    <option value="Sq. m.">Sq. m.</option>
                    <option value="Sq. ft.">Sq. ft.</option>
                    <option value="No. of Containers">No. of Containers</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="location">Location</label>
                  <input type="text" tabindex="3" class="form-control required" id="location" name="location" placeholder="Location">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="validity">Validity</label>
                  <input type="text" tabindex="4" class="form-control required" id="validity" name="validity" placeholder="Validity">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" id="create_grn_button" value="Create GRN" class="btn btn-primary btn-block pull-left" onclick="createGRN();">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

      <!--Job Order Modal Div -->
      <div class="modal fade" id="view_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form  id="dataapprovedlist_form" name="dataapprovedlist_form" method="post" class="validator-form1" action="" onsubmit="return false;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="modal_title">Select Completed Job Orders</h4>
                </div>
                <div class="modal-body">
                  <div class="responsive">
                    <table id="tariff_master_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>S.No</th>
                                  <th>Job Order ID</th>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/grn/js/grn.js"></script>
  <script type="text/javascript">

    $( document ).ready(function() {
      $('#fields').hide();
      $('#create_grn_button').hide();
    });
    
    $('#grn_form').validate({
        errorClass: "my-error-class"
    });

    //initial value of label
    $('#fetch_by_label').html('Customer Name');
    //change label name according to selected value
    $('#select_by_type').on('change', function() {
      $('#data_item').val('');
      changeLabelText();
    })
  </script>
  <?php
    include('../footer.php');
  ?>
