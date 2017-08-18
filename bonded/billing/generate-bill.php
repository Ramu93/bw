<?php
  include('../header.php');
  include('../sidebar.php');
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
                <input type="button" class="btn btn-primary btn-block" onclick="getGRNList()" value="Get GRN List">
              </div>
              <div class="col-sm-3">
                <div class="form-group" id="party_details_div">
                  <label for="importing_firm_name">Party Master ID:</label>
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
            <div class="row" id="previous_billing_div">
              
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
  <script type="text/javascript">

    $(document).ready(function(){
      $('#generate_bill_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });

      $('#party_details_div').hide();
      $('#grn_table').hide();
      $('#previous_billing_div').hide();
      $('#billing_div').hide();

    });

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
      getPartyDetails();
      getGRNList();
    });

    //for enter key press
    $('#party_name').keypress(function(event){
      if(event.which == 13){
        getPartyDetails();
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
