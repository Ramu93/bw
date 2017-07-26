<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $pdrID = $_GET['pdr_id'];
  $select = "SELECT * FROM bonded_despatch_request WHERE pdr_id='$pdrID'";
  $query = mysqli_query($dbc,$select);
  $out = array();
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
    //file_put_contents("editlog.log", print_r( json_encode($containerOutput), true ));
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Despatch Request - Approve/Reject
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="pdr_update_form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="pdr_id" value="<?php echo $pdrID; ?>">
            <!-- <div class="row" id="fields">
              <div class="form-group col-md-4">
                <label for="sac_par_id" id="sac_par_table_label"></label>
                <input type="text" class="form-control" id="sac_par_id" name="sac_par_id" readonly="true">
                <input type="hidden" class="form-control" id="sac_par_table" name="sac_par_table">
              </div>
            </div> -->
            <div class="row">
              <div class="form-group col-md-4">
                <label for="client_web">Client Web</label>
                <select class="form-control" id="client_web" name="client_web" class="client-web" required="">
                  <option value="">Select client web...</option>
                  <option value="Debond" <?php echo (($out['client_web']=='Debond')?'selected="selected"':''); ?> >Debond</option>
                  <option value="Inbond Sales" <?php echo (($out['client_web']=='Inbond Sales')?'selected="selected"':''); ?> >Inbond Sales</option>
                  <option value="Reexport" <?php echo (($out['client_web']=='Reexport')?'selected="selected"':''); ?> >Reexport</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="order_number">CHA Name/Exporter</label>
                <input type="text" class="form-control required autofillparty" id="cha_name_exporter" name="cha_name_exporter" value="<?php echo $out['cha_name']; ?>" placeholder="CHA Name/Exporter">
              </div>
              <div class="form-group col-md-4">
                <label for="order_number">Order Number</label>
                <input type="text" class="form-control required" id="order_number" value="<?php echo $out['order_number']; ?>" name="order_number" placeholder="Order Number">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="boe_number">Warehouse BOE Number</label>
                <input type="text" value="<?php echo $out['boe_number']; ?>" class="form-control required" id="boe_number" name="boe_number" placeholder="BOE Number">
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_number">EXBond BE Number</label>
                <input type="text" class="form-control required" value="<?php echo $out['exbond_be_number']; ?>" id="exbond_be_number" name="exbond_be_number" placeholder="EXBond BE Number">
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_date">EXBond BE Date</label>
                <input type="text" class="form-control required" id="exbond_be_date" value="<?php echo $out['exbond_be_date']; ?>" name="exbond_be_date" placeholder="EXBond BE Date">
              </div>
              <div class="form-group col-md-3">
                <label for="customs_officer_name">Customer Officer Name</label>
                <input type="text" class="form-control required" id="customs_officer_name" name="customs_officer_name" value="<?php echo $out['customs_officer_name']; ?>" placeholder="Customer Officer Name">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="packages_number">Number of Packages</label>
                <input type="text" class="form-control required" id="packages_number" value="<?php echo $out['number_of_packages']; ?>" name="packages_number" placeholder="Number of Packages">
              </div>
              <div class="form-group col-md-3">
                <label for="assessment_value">Assessment Value</label>
                <input type="text" class="form-control required" id="assessment_value" value="<?php echo $out['assessment_value']; ?>" name="assessment_value" placeholder="Assessment Value">
              </div>
              <div class="form-group col-md-3">
                <label for="duty_value">Duty Value</label>
                <input type="text" class="form-control required" value="<?php echo $out['duty_value']; ?>" id="duty_value" name="duty_value" placeholder="Duty Value">
              </div>
              <div class="form-group col-md-3">
                <label for="transporter_name">Transporter Name</label>
                <input type="text" class="form-control required" value="<?php echo $out['transporter_name']; ?>" id="transporter_name" name="transporter_name" placeholder="Transporter Name">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <input type="button" id="view_items_btn" name="submit" value="View Items" class="btn btn-success btn-block pull-left" onclick="getPDRItems(<?php echo $pdrID; ?>)">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="submit" id="update_pdr_btn" name="submit" value="Update PDR" class="btn btn-primary btn-block pull-left" onclick="updatePDR()">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="submit" id="update_pdr_btn" name="submit" value="Approve PDR" class="btn btn-primary btn-block pull-left" onclick="approvePDR(<?php echo $out['pdr_id']; ?>)">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="submit" id="update_pdr_btn" name="submit" value="Reject PDR" class="btn btn-primary btn-block pull-left" onclick="rejectPDR(<?php echo $out['pdr_id']; ?>)">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

      <!--Items Modal -->
      <div class="modal fade" id="view_items_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form  id="select_items_form" name="dataapprovedlist_form" method="post" class="validator-form1" action="" onsubmit="return false;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="modal_title">Item List</h4>
                </div>
                <div class="modal-body">
                  <div class="responsive">
                    <table id="tariff_master_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                <div class="modal-footer">
                  <button type="button" onclick="setDespatchQtyForItems()" class="btn btn-default" data-dismiss="modal">Close</button>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/pdr/js/pdr.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#client_insurance_file_div").hide();
      $("#client_insurance_declaration_file_div").hide();
      $('#containerlist_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });
      $('#pdr_update_form').validate({
        errorClass: "my-error-class"
      });
    });

    //Date picker
    $('#exbond_be_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });

    function updateClicked(){
      $('#action_hidden_text').val('update_pdr');
    }

    var isEditPage = false;// used to redirect to pdr-apprvoe-reject-view.php when update method is called

    $('.autofillparty').autocomplete({
      source : "auto-complete-services.php?action=fetch_party_info",
      minLength : 2,
      select : function(event, ui) {
              
              if(ui.item.value == "No customers found"){
                event.preventDefault();
                // $('#customer_name').val('');
                console.log('s');
              }else{
              }
          },
    });

  </script>
  <?php
    include('../footer.php');
  ?>
