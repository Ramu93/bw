<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Job order Unloading - Inward Process
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="job_order_unloading_form" name="job_order_unloading_form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="par_id" id="par_id" value="">
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
                  <option value="customer_name">Customer Name</option>
                  <option value="boe_number">BOE Number</option>
                  <option value="par">PAR</option>
                  <option value="igp">IGP</option>
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
            <div class="row">
              <div class="col-md-3">
                <label id="id_label"></label>
                <div class="clearfix"></div>
                <label id="id_value"></label>
              </div>
              <div class="col-md-3">
                <label id="customer_name_label"></label>
                <div class="clearfix"></div>
                <label id="customer_name_value"></label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="weight">Weight in kgs</label>
                  <input type="text" tabindex="5" class="form-control required number" id="weight" name="weight" placeholder="Weight">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_of_packages">No. of Packages</label>
                  <input type="text" tabindex="6" class="form-control required" id="no_of_packages" name="no_of_packages" placeholder="Number of Packages">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" tabindex="7" class="form-control required" id="description" name="description" placeholder="Description">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="supervisor_name">Name of the Supervisor</label>
                  <input type="text" tabindex="8" class="form-control required" id="supervisor_name" name="supervisor_name" placeholder="Name of the Supervisor">
                </div>
              </div>
              <div class="col-md-4">
                <label for="unloading_type">Type of Unloading</label>
                <select class="form-control" tabindex="9" id="unloading_type" name="unloading_type">
                  <option value="1">100% Manual</option>
                  <option value="2">75% Manual + 25% Mechanical</option>
                  <option value="3">50% Manual + 50% Mechanical</option>
                  <option value="4">25% Manual + 75% Mechanical</option>
                  <option value="5">100% Mechanical</option>
                  <option value="6">Crane + Manual</option>
                  <option value="7">Crane + Mechanical + Manual</option>
                  <option value="8">Special Equipments</option>
                  <option value="9">Others</option>
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
                  <input type="text" tabindex="11" class="form-control required number" id="no_of_labors" name="no_of_labors" placeholder="Number of labors">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="unloading_time">Time for Unloading</label>
                  <input type="text" tabindex="12" class="form-control required" id="unloading_time" name="unloading_time" placeholder="Time for unloading">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dimension">Dimension per Unit and Weight</label>
                    <select class="form-control required" id="dimension" name="dimension">
                      <option value="20 ft. Container">20 ft. Container</option>
                      <option value="40 ft. Container">40 ft. container</option>
                      <option value="Break Bulk/ODC">Break Bulk/ODC</option>
                      <option value="LCL">LCL</option>
                    </select>
                </div>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/job-order/js/job-order-unloading.js"></script>
  <script type="text/javascript">

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    $('#job_order_unloading_form').validate({
        errorClass: "my-error-class"
    });

    $('#supervisor_name').rules("add", { regex: "^[a-zA-Z ]+$" });
    $('#no_of_packages').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
    $('#equipment_ref_number').rules("add", { regex: "^(?=.*?[1-9])[0-9()-]+$" });

    $('#unloading_type').on('change', function() {
      var unloadingType = $('#unloading_type').val();
      if(unloadingType == 1){
        $('#equipment_ref_number').removeAttr('required');
      } else {
        $('#equipment_ref_number').attr('required','true');
      }
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
