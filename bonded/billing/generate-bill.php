<?php
  include('../header.php');
  include('../sidebar.php');
  // include('gst-config.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Generate Bill
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="generate_bill_form" name="generate_bill_form" action="#" method="post" onsubmit="return false;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Select Customer/CHA</label>
                  <input type="text" tabindex="1" class="form-control required autofillparty" id="party_name" name="party_name" placeholder="Customer/CHA">
                </div>
              </div>
              <div class="col-md-3">
                <div class="clearfix">&nbsp;</div>
                <input type="button" class="btn btn-primary btn-block" onclick="getGRNList()" value="Get GRN List" >
              </div>
              <div class="col-sm-3">
                <div class="form-group" id="party_details_div">
                  <label for="">Party Master ID:</label>
                  <div class="clearfix"></div>
                  <label id="party_id_label"></label>
                  <input type="hidden" name="party_id_hidden" id="party_id_hidden">
                </div>
              </div>
            </div>
            <div class="row" style="text-align: center; margin: 10px;">
              <table id="grn_table" style="width: 90%"  class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S. No.</th>
                    <th>GRN ID</th>
                    <th>Customer Name</th>
                    <th>CHA Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="grn_list_tbody">
                  
                </tbody>
              </table>
            </div>
            <div class="row" id="selected_grn_div">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="">Selected GRN ID:</label>
                  <div class="clearfix"></div>
                  <label id="grn_id_label"></label>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="">SAC ID:</label>
                  <div class="clearfix"></div>
                  <label id="sac_id_label"></label>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="">Job order - Unloading ID:</label>
                  <div class="clearfix"></div>
                  <label id="jul_id_label"></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="well" id="previous_billing_div">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Last Bill Date:</label>
                        <div class="clearfix"></div>
                        <label id="previous_bill_date_label"></label>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Last Bill Period:</label>
                        <div class="clearfix"></div>
                        <label id="previus_period_label"></label>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Last Bill Amount:</label>
                        <div class="clearfix"></div>
                        <label id="last_bill_amount_label"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="billing_div">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="bol_awb_no">Bill Date:</label>
                  <input type="text" tabindex="" class="form-control required" id="bill_date" name="bill_date" placeholder="Bill Date">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="bol_awb_no">From:</label>
                  <input type="text" tabindex="" class="form-control required" id="from_date" name="from_date" placeholder="From Date">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="bol_awb_no">To:</label>
                  <input type="text" tabindex="" class="form-control required" id="to_date" name="to_date" placeholder="To Date">
                </div>
              </div>
            </div>
            <div id="handling_charges_div">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Handling Charges:</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Sl.no</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>GST Slab</th>
                      </tr>
                    </thead>
                    <tbody id="additem_tbody">
                        <tr id="itemtr_1">
                          <td><span class="td_sno">1</span></td>

                          <td><input type="text" id="description" name="description[]" placeholder="" class="form-control" value=""></td>

                          <td><input type="text" name="amount[]" placeholder="" class="form-control" value=""></td>

                          <td>
                            <select class="form-control required" id="gst_slab" name="gst_slab[]">
                              <option value="0">0</option>
                              <option value="5">5</option>
                              <option value="12">12</option>
                              <option value="18">18</option>
                              <option value="28">28</option>
                            </select>
                          </td>

                          <td><input type="button" class="btn btn-warning" onclick="additemrow(1)" value="+"><!-- <button class="item_removebutton" style="display:none;" onclick="removeitemrow(1)">-</button> --></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-1">
              
                </div>
              </div>
            </div>
            <div class="row" id="bill_amount_div">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="form-group" >
                        <label for="">Sub Total:</label>
                        <label id="bill_amount_label"></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group" >
                        <label for="">Tax Payable:</label>
                        <label id="total_taxes_label"></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group" >
                        <label for="">Grand Total:</label>
                        <label id="grand_total_label"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
              </div>
              <div class="col-md-3">
                <div class="clearfix">&nbsp;</div>
                <input type="button" id="generate_bill_btn" class="btn btn-primary btn-block" onclick="generateBill()" value="Generate Bill">
              </div>
              <div class="col-md-4">
                <div class="clearfix">&nbsp;</div>
                <input type="button" id="save_bill_btn" class="btn btn-primary btn-block" onclick="saveBill()" value="Save Bill">
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/billing/js/billing.js"></script>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/billing/js/gst-config.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#generate_bill_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });

      loadGstCombo('bill_gst_type');
      loadGstCombo('gst_type');

      $('#selected_grn_div').hide();
      $('#party_details_div').hide();
      $('#grn_table').hide();
      $('#previous_billing_div').hide();
      $('#billing_div').hide();
      $('#generate_bill_btn').hide();
      $('#save_bill_btn').hide();
      $('#handling_charges_div').hide();
      $('#bill_amount_div').hide();

    });

    function loadGstCombo(elementId){
      var dp = '';
      for(var gstType in gstTypes){
        dp += '<option value="'+gstType+'">'+gstTypes[gstType]+'</option>';
      }
      $('#'+elementId).html(dp);
    }

    //Date picker
    $('#bill_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });
    $('#from_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });
    $('#to_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });

    $('#container_count').spinner({
      min: 1,
      stop: function( event, ui ){
              containerSpinner();
          }
    });

    $('#party_name').on('change', function(){
      getPartyDetails(this.value);
      getGRNList();
    });

    //for enter key press
    $('#party_name').keypress(function(event){
      if(event.which == 13){
        getPartyDetails(this.value);
        getGRNList();
      }
    });

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
