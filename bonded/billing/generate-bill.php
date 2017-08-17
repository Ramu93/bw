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
                  <label for="importing_firm_name">Name of the Importer</label>
                  <input type="text" tabindex="1" class="form-control required autofillparty" id="importing_firm_name" name="importing_firm_name" placeholder="Name of the importing firm">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Name of the CHA</label>
                  <input type="text" tabindex="1" class="form-control required autofillparty" id="cha_name" name="cha_name" placeholder="Name of the CHA">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group" id="customer_details_div">
                  <label for="importing_firm_name">Party Master ID:</label>
                  <div class="clearfix"></div>
                  <label id="customer_id_label"></label>
                  <input type="hidden" name="customer_id_hidden" id="customer_id_hidden">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group" id="cha_details_div">
                  <label for="importing_firm_name">Party Master ID:</label>
                  <div class="clearfix"></div>
                  <label id="cha_id_label"></label>
                  <input type="hidden" name="cha_id_hidden" id="cha_id_hidden">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                <input type="button" class="btn btn-primary btn-block" onclick="getGRNList()" value="Get GRN List">
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

      $('#customer_details_div').hide();
      $('#cha_details_div').hide();
      $('#grn_table').hide();

    });

    //Date picker
    var startDate = new Date();
    $('#boe_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });
    $('#expected_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });

    $('#container_count').spinner({
      min: 1,
      stop: function( event, ui ){
              containerSpinner();
          }
    });

    $('#importing_firm_name').on('change', function(){
      getPartyDetails('customer');
    });
    $('#cha_name').on('change', function(){
      getPartyDetails('cha');
    });

    //for enter key press
    $('#importing_firm_name').keypress(function(event){
      if(event.which == 13){
        getPartyDetails('customer');
      }
    });
    $('#cha_name').keypress(function(event){
      if(event.which == 13){
        getPartyDetails('cha');
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
