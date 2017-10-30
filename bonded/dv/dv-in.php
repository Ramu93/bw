<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $out = array();
  $id = $_GET['id'];
  $select = "SELECT sac_id as 'id', importing_firm_name, cha_name, licence_code, bol_awb_number, boe_number FROM sac_request WHERE sac_id='$id'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
  }
  //file_put_contents("editlog.log", print_r( $out, true ));

?>

<style type="text/css">
  .modal{
    width: 80%; /* respsonsive width */
    margin-left:-40%; /* width/2) */ 
  }

  ul.ui-autocomplete {
      z-index: 1100;
  }
  .error{
    color: red;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Document Verification - Inward
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-body">
        <form id="document_verification_form" name="document-document_verification_form-form" action="#" method="post" onsubmit="return false;">
          <input type="hidden" name="sac_id" id="sac_id" value="<?php echo $id; ?>">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>SAC ID:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['id']; ?></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Importing Firm:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['importing_firm_name']; ?></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >CHA Name:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['cha_name']; ?></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="select_by_label">BOL/AWB Number:</label>
              <div class="clearfix"></div>
              <label><?php echo $out['bol_awb_number']; ?></label>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="boe_number">BOE Number:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['boe_number']; ?></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Licence Code:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['licence_code']; ?></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name_of_cfs">Name of the CFS</label>
                <input type="text" class="form-control required" id="cfs_name" name="cfs_name" placeholder="Name of the CFS">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="customs_officer_name">Customs Officer Name</label>
                <input type="text" class="form-control required" id="customs_officer_name" name="customs_officer_name" placeholder="Name of the Customs Officer">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="name_of_cfs">Bond Number</label>
                <input type="text" class="form-control required" id="bond_number" name="bond_number" placeholder="Bond Number">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="customs_officer_name">Bond Date</label>
                <input type="text" class="form-control required" id="bond_date" name="bond_date" placeholder="Bond Date">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="do_number">DO Number</label>
                <input type="text" class="form-control required" id="do_number" name="do_number" placeholder="Document number">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="document_date">DO Date</label>
                <input type="text" class="form-control required" id="do_date" name="do_date" placeholder="Document date">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="do_issued_by">DO Issued by</label>
                <input type="text" class="form-control required" id="do_issued_by" name="do_issued_by" placeholder="Document issued by">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <input type="checkbox" name="invoice_copy_check" id="invoice_copy_check" value="yes"> Invoice Copy
                <input type="hidden" name="invoice_copy" id="invoice_copy_text" value="">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="checkbox" name="packing_list_check" id="packing_list_check" value="yes"> Packing List
                <input type="hidden" name="packing_list" id="packing_list_text" value="">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="checkbox" class="required" name="boe_copy_check" id="boe_copy_check" value="yes"> BOE Copy
                <input type="hidden" name="boe_copy" id="boe_copy_text" value="">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="checkbox" class="required" name="bond_order_check" id="bond_order_check" value="yes"> Bond Order
                <input type="hidden" name="bond_order" id="bond_order_text" value="">
              </div>
            </div>
          </div>
          <div id="container_data_div" class="responsive">
            
          </div>
      <!--Add Item Modal Div -->
      <div class="modal fade" id="view_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
              <form  id="item_list_form" name="item_list_modal" method="post" class="validator-form1" action="" onsubmit="return false;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="modal_title">Items</h4>
                </div>
                <div class="modal-body">
                  <div class="responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Sl.no</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Assessable Value</th>
                        <th>Duty Value</th>
                        <th>Insurance Value</th>
                        <th>Container Number</th>
                      </tr>
                    </thead>
                    <tbody id="additem_tbody">
                        <tr id="itemtr_1">
                          <td><span class="td_sno">1</span></td>

                          <td><input type="text" id="item_name" name="item_name[]" placeholder="" class="form-control auto-itemname" value="" autocomplete="on"></td>

                          <td><input type="text" name="item_qty[]" placeholder="" class="form-control" value=""></td>

                          <td><input type="text" name="assessabe_value[]" placeholder="" class="form-control" value=""></td>

                          <td><input type="text" name="duty_value[]" placeholder="" class="form-control" value=""></td>

                          <td><input type="text" name="insurance_value[]" placeholder="" class="form-control" value="" readonly></td>

                          <td>
                            <select name="container_number[]" id="container_number_select" class="form-control">
                              
                            </select>
                          </td>

                          <td><button onclick="additemrow(1);">+</button><!-- <button class="item_removebutton" style="display:none;" onclick="removeitemrow(1)">-</button> --></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="computeInsuranceValue()">Calculate Insurance</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
        </div>
      </div>
      <!-- modal ends -->
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <input type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#view_list_modal" onclick="bindAutocomplete()" value="Add Item">
            </div>
            <div class="col-md-4 col-sm-4">
              <input type="submit" id="dv_submit_button" name="submit" value="Submit" class="btn btn-primary btn-block pull-left" onclick="submitDocumentVerification();">
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
<script type="text/javascript" src="<?php echo HOMEURL; ?>/dv/js/dv-in.js"></script>
<script type="text/javascript">

  $(document).ready(function(){

    getSelectedtContainerData();


    $('#document_verification_form').validate({
      errorClass: "my-error-class" //error class defined in header file style tag
    });

    var startDate = new Date();
    $('#do_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });

    $('#bond_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });
  });
</script>
<?php
  include('../footer.php');
?>
