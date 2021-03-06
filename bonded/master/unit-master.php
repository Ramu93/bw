<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Unit Master
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
                <input type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_unit_modal" value="Add Unit">
              </div>
            </div>
          </form>
          <br />

          <div style="width: 50%;">
            <table id="unit_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Unit</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="unit_table_body">
                
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

 <!-- Add Unit Modal Div -->
 <div class="modal fade" id="add_unit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="add_unit_form" name="add_unit_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Unit</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="unit_name">Unit Name</label>
                    <input type="text" tabindex="1" class="form-control required" id="unit_name" name="unit_name" placeholder="Unit name">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addUnit();" >Add</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <!-- Edit Unit Modal Div -->
 <div class="modal fade" id="edit_unit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="edit_unit_form" name="edit_unit_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Edit Unit</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="unit_name">Unit Name</label>
                    <input type="text" tabindex="1" class="form-control required" id="edit_unit_name" name="edit_unit_name" placeholder="Unit name">
                    <input type="hidden" id="unit_id_hidden" name="unit_id_hidden">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="editUnit();" >Save</button>
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
      $('#add_unit_form').validate({
        errorClass: "my-error-class"
      });
      $('#edit_unit_form').validate({
        errorClass: "my-error-class"
      });

      getUnits();

      $('#unit_name').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#edit_unit_name').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
    });
  </script>
  <?php
    include('../footer.php');
  ?>
