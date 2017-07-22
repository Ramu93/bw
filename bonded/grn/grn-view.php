<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $out = array();
  $grnId = $_GET['grn_id'];
  $select = "SELECT * FROM bonded_good_receipt_note WHERE grn_id='$grnId'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
    $sacId = $row['sac_id'];
    $innerQuery = "SELECT sac_id as 'id', 'sac' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number, material_name, material_nature, packing_nature FROM sac_request WHERE sac_id='$sacId'";
    $innerResult = mysqli_query($dbc,$innerQuery);
    if(mysqli_num_rows($innerResult) > 0){
      $innerRow = mysqli_fetch_assoc($innerResult);
      $out = array_merge($out, $innerRow);
    }
  }
  // file_put_contents("editlog.log", print_r( $out, true ));
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
          <form id="grn_form" name="job_ordgrn_former_unloading_form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="par_id" id="par_id" value="">
            <input type="hidden" name="grn_id" id="grn_id" value="">
            <div id="printdiv">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="" id="">GRN ID:</label>
                  <div class="clearfix"></div>
                  <label id="grn_value"><?php echo $grnId; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <label id="id_label">SAC ID:</label>
                <div class="clearfix"></div>
                <label id="id_value"><?php echo $out['sac_id']; ?></label>
              </div>
              <div class="col-md-4">
                <label id="customer_name_label">Customer Name:</label>
                <div class="clearfix"></div>
                <label id="customer_name_value"><?php echo $out['importing_firm_name']; ?></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4">
                <label id="licence_code_label">Licence Code:</label>
                <div class="clearfix"></div>
                <label id="licence_code"><?php echo $out['licence_code']; ?></label>
              </div>
              <div class="col-md-4">
                <label id="bol_awb_number_label">BOL/AWB Number:</label>
                <div class="clearfix"></div>
                <label id="bol_awb_number"><?php echo $out['bol_awb_number']; ?></label>
              </div>
              <div class="col-md-4">
                <label id="boe_number_label">BOE Number:</label>
                <div class="clearfix"></div>
                <label id="boe_number"><?php echo $out['boe_number']; ?></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4">
                <label id="material_name_label">Name of the Material:</label>
                <div class="clearfix"></div>
                <label id="material_name"><?php echo $out['material_name']; ?></label>
              </div>
              <div class="col-md-4">
                <label id="material_nature_label">Nature of the Material:</label>
                <div class="clearfix"></div>
                <label id="material_nature"><?php echo $out['material_nature']; ?></label>
              </div>
              <div class="col-md-4">
                <label id="packing_nature_label">Nature of Packing:</label>
                <div class="clearfix"></div>
                <label id="packing_nature"><?php echo $out['packing_nature']; ?></label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row" id="fields">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="space_occupied">Space Occupied</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['space_occupied']; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="location">Location</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['location']; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="validity">Validity</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['validity']; ?></label>
                </div>
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" id="create_grn_button" value="Print GRN" class="btn btn-primary btn-block pull-left" onclick="printGRN('printdiv');">
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
