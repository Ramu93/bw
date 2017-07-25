<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pre Arrival Request - Create
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="par-form" name="par-form" action="#" method="post" onsubmit="return false;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Name of the Importer/Customer</label>
                  <input type="text" tabindex="1" class="form-control required" id="importing_firm_name" name="importing_firm_name" placeholder="Name of the importing firm">
                </div>
                <div class="form-group">
                  <label for="bol_awb_no">BOL/Invoice Number</label>
                  <input type="text" tabindex="3" class="form-control required" id="bol_awb_no" name="bol_awb_number" placeholder="BOL/Invoice Number">
                </div>
                <div class="form-group">
                  <label for="bol_awb_no">BOL/Invoice Date</label>
                  <input type="text" tabindex="3" class="form-control required" id="bol_awb_date" name="bol_awb_date" placeholder="BOL/Invoice Date">
                </div>
                <div class="form-group">
                  <label for="material_name">Name of the Material</label>
                  <input type="text" tabindex="5" class="form-control required" id="material_name" name="material_name" placeholder="Name of the Material">
                </div>
                <div class="form-group">
                  <label for="packing_nature">Nature of Packing</label>
                  <select class="form-control" tabindex="7" id="packing_nature" name="packing_nature">
                    <option value="Metal Drum">Metal Drum</option>
                    <option value="Fibre Drum">Fibre Drum</option>
                    <option value="Wooden Crate Bags Cartons">Wooden Crate Bags Cartons</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="qty_units">Assessable Value</label>
                  <input type="text" tabindex="9" class="form-control required" id="assessable_value" name="assessable_value" placeholder="Assessable Value">
                </div>
                <div class="form-group">
                  <label for="material_nature">Nature of Materials</label>
                  <select class="form-control" tabindex="11" id="material_nature" name="material_nature" required="">
                    <option value="Non Hazardous">Non Hazardous</option>
                    <option value="Hazardous">Hazardous</option>
                    <option value="Chemcals Compositor">Chemcals Compositor</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cargo_life">Cargo Life</label>
                  <input type="text" tabindex="13" class="form-control required" id="cargo_life" name="cargo_life" placeholder="Cargo Life">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="importing_firm_name">Name of the CHA</label>
                  <input type="text" tabindex="1" class="form-control required" id="cha_name" name="cha_name" placeholder="Name of the CHA">
                </div>
                <div class="form-group">
                  <label for="boe_num">BOE Number</label>
                  <input type="text" tabindex="4" class="form-control required" id="boe_num" name="boe_number" placeholder="BOE Number">
                </div>   
                <div class="form-group">
                  <label for="boe_num">BOE Date</label>
                  <input type="text" tabindex="4" class="form-control required" id="boe_date" name="boe_date" placeholder="BOE Date">
                </div>            
                <div class="form-group">
                  <label for="qty_units">Quantity in Number of Units</label>
                  <input type="text" tabindex="6" class="form-control required" id="qty_units" name="qty_units" placeholder="Quantity in No of units">
                </div>
                <div class="form-group">
                  <label for="qty_units">Requirement of Space</label>
                  <input type="text" tabindex="8" class="form-control required" id="space_req" name="space_requirement" placeholder="Requirement of Space">
                </div>
                <div class="form-group">
                  <label for="qty_units">Duty Amount in Rupees</label>
                  <input type="text" tabindex="10" class="form-control required" id="duty_amount" name="duty_amount" placeholder="Duty Amount in Rupees">
                </div>
                <div class="form-group">
                  <label for="expected_date">Expected Date of Warehousing</label>
                  <input type="text" tabindex="12" class="form-control required" id="expected_date" name="expected_date" placeholder="Expected Date of Warehousing">
                </div>
                <div class="form-group">
                  <label for="shelf_life">Shelf Life</label>
                  <input type="text" tabindex="14" class="form-control required" id="shelf_life" name="shelf_life" placeholder="Shelf Life">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="expected_date">Required Period of Warehousing</label>
                  <input type="text" tabindex="15" class="form-control required" id="required_period_of_warehousing" name="required_period" placeholder="Required Period of Warehousing">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="insurance_by">Insurance By</label>
                  <div class="form-group">
                    <input type="radio" tabindex="16" id="insurance_by" name="insurance_by" value="TRLPL" checked onclick="disableClientInsuranceFile();"> TRLPL &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="17" id="insurance_by" name="insurance_by" value="Client" onclick="enableClientInsuranceFile();"> Client
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" id="client_insurance_file_div">
                  <label class="btn btn-primary">
                      Attach copy <input type="file" style="display: none;" name="client_insurance_file">
                  </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="insurance_declaration">Insurance Declaration</label>
                  <div class="form-group">
                    <input type="radio" tabindex="18" id="insurance_declaration" name="insurance_declaration" value="Yes"  onclick="enableClientInsuranceDeclararionFile();"> Yes &nbsp;&nbsp;&nbsp;
                    <input type="radio" tabindex="19" id="insurance_declaration" name="insurance_declaration" value="No" checked onclick="disableClientInsuranceDeclararionFile();"> No
                  </div>
                </div>
              </div>
              <div class="col-md-2"">
                <div class="form-group" id="client_insurance_declaration_file_div">
                  <label class="btn btn-primary">
                      Attach copy <input type="file" style="display: none;" name="insurance_declaration_file">
                  </label>
                </div>
              </div>
            </div>
            <input type="hidden" name="action" value="create_par">
            <input type="hidden" id="container_stringified" name="container_stringified" >
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <input type="submit" name="submit" value="Create PAR" class="btn btn-primary btn-block pull-left" onclick="createPAR();">
              </div>
              <div class="col-md-6 col-sm-6">
                <input type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#containerlist_modal" value="Add Container">
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
 <div class="modal fade" id="containerlist_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="containerlist_form" name="containerlist_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Container Details</h4>
              </div>
              <div class="modal-body">
                <div class="" id="containeritems_div">
                  <div class="col-md-4">
                    <label for="dimension">Dimension</label>
                    <select class="form-control required" id="dimension" name="dimension">
                      <option value="20 ft. Container">20 ft. Container</option>
                      <option value="40 ft. Container">40 ft. container</option>
                      <option value="ODC">ODC</option>
                      <option value="Break Bulk">Break Bulk</option>
                      <option value="LCL">LCL</option>
                    </select>
                  </div>
                  <div id="container_fields_div">
                    <div class="col-md-4">
                      <label for="container_detail">No. of Containers</label>
                      <div class="form-group">
                        <input type="text" class="form-control" name="container_count" id="container_count" placeholder="" value="1" />
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="container_number_div">
                      <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" class="form-control required" name="container_number_1" id="container_number_1" placeholder="Container Number" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="col-sm-12" id="accordion_div_container">
                  <div class="panel-group" id="accordion_container" role="tablist" aria-multiselectable="true" style="display:none;">
                    <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingOne_container">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_c" aria-expanded="false" aria-controls="collapseOne">
                            Collapsible Group Item #1
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne_c" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" onclick="addContainerItem();" >Add Detail</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>


  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/par/js/par.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $("#client_insurance_file_div").hide();
      $("#client_insurance_declaration_file_div").hide();
      $('#containerlist_form').validate({
        errorClass: "my-error-class" //error class defined in header file style tag
      });
      $('#par-form').validate({
        errorClass: "my-error-class"
      });

      $('#dimension').on('change', function(){
        replaceFieldsForContainers();
      });

    });

    //Date picker
    var startDate = new Date();

    $('#bol_awb_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });
    $('#boe_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });
    $('#expected_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });
    $('#cargo_life').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
      minDate: startDate
    });
    $('#shelf_life').datepicker({
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

  </script>
  <?php
    include('../footer.php');
  ?>
