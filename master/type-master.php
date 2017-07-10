
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Type Master
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
                <input type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_type_modal" value="Add Type">
              </div>
            </div>
          </form>
          <br />

          <table id="type_table" style="width: 50%;" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="type_table_body">
              
            </tbody>
          </table>
          
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <!-- Add Type Modal Div -->
 <div class="modal fade" id="add_type_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="add_type_form" name="add_type_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Prodcut Type</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_type">Product Type</label>
                    <input type="text" tabindex="1" class="form-control required" id="type_name" name="type_name" placeholder="Product Type Name">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addType();" >Add</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <!-- Edit Type Modal Div -->
 <div class="modal fade" id="edit_type_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="edit_type_form" name="edit_type_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Prodcut Type</h4>
              </div>
              <div class="modal-body">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_type">Product Type</label>
                    <input type="text" tabindex="1" class="form-control required" id="edit_type_name" name="edit_type_name" placeholder="Product Type Name">
                    <input type="hidden" id="type_id_hidden" name="type_id_hidden">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="editType();" >Save</button>
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
      $('#add_type_form').validate({
        errorClass: "my-error-class"
      });
      $('#edit_type_form').validate({
        errorClass: "my-error-class"
      });

      getTypes();
    });
  </script>
  <?php
    include('../footer.php');
  ?>
