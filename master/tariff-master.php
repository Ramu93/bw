
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tariff Master
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                <input type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_tariff_modal" value="Add Tariff">
              </div>
            </div>
          </form>
          <br />

          <div style="width: 80%;">
            <table id="tariff_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Service Name</th>
                  <th>Service Type</th>
                  <th>Storage Unit</th>
                  <th>Rate</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tariff_table_body">
                
              </tbody>
            </table>
          </div>
          
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <!-- Add Tariff Modal Div -->
 <div class="modal fade" id="add_tariff_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="add_tariff_form" name="add_tariff_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Tariff</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="service_name">Service Name</label>
                      <input type="text" tabindex="1" class="form-control required" id="service_name" name="service_name" placeholder="Service  Name">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">Service Type</label>
                      <select id="service_type" name="service_type" class="form-control required">
                        <option value="" selected="selected" >Select type...</option>
                        <option value="STORAGE">STORAGE</option>
                        <option value="VAS">VAS</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="service_name">Storage Unit</label>
                      <input type="text" tabindex="1" class="form-control required" id="storage_unit" name="storage_unit" placeholder="Storage Unit">
                    </div>
                  </div>
                  <d class="col-md-4">
                    <div class="form-group">
                      <label for="rate">Rate</label>
                      <input type="text" tabindex="1" class="form-control required" id="rate" name="rate" placeholder="Rate">
                    </div>
                  </d>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addTariff();" >Add</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <!-- Edit Tariff Modal Div -->
 <div class="modal fade" id="edit_tariff_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="edit_tariff_form" name="edit_tariff_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Edit Tariff</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="service_name">Service Name</label>
                      <input type="text" tabindex="1" class="form-control required" id="edit_service_name" name="edit_service_name" placeholder="Service  Name">
                      <input type="hidden" name="tariff_id_hidden" id="tariff_id_hidden">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">Service Type</label>
                      <select id="edit_service_type" name="edit_service_type" class="form-control required">
                        <option value="" selected="selected" >Select type...</option>
                        <option value="STORAGE">STORAGE</option>
                        <option value="VAS">VAS</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="service_name">Storage Unit</label>
                      <input type="text" tabindex="1" class="form-control required" id="edit_storage_unit" name="edit_storage_unit" placeholder="Storage Unit">
                    </div>
                  </div>
                  <d class="col-md-4">
                    <div class="form-group">
                      <label for="rate">Rate</label>
                      <input type="text" tabindex="1" class="form-control required" id="edit_rate" name="edit_rate" placeholder="Rate">
                    </div>
                  </d>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="editTariff();" >Save</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/master/js/master.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#add_item_form').validate({
        errorClass: "my-error-class"
      });
      $('#edit_item_form').validate({
        errorClass: "my-error-class"
      });


      getTariffs();
    });
  </script>
  <?php
    include('../footer.php');
  ?>
