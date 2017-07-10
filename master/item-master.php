
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Master
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
                <input type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_item_modal" value="Add Item">
              </div>
            </div>
          </form>
          <br />

          <div style="width: 50%;">
            <table id="item_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Item Name</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="item_table_body">
                
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

 <!-- Add Type Modal Div -->
 <div class="modal fade" id="add_item_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="add_item_form" name="add_item_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Item</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="item_name">Item Name</label>
                      <input type="text" tabindex="1" class="form-control required" id="item_name" name="item_name" placeholder="Item  Name">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select id="item_type" name="item_type" class="form-control required">
                        <option value="" selected="selected" >Select type...</option>
                        <?php
                          $query = "SELECT * FROM type_master";
                          $result = mysqli_query($dbc, $query);
                          if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo '<option value="'.$row['type_id'].'">'.$row['type_name'].'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addItem();" >Add</button>
                  <button type="button" data-dismiss="modal" class="btn btn-default" >Close</button>
              </div>
            </form>
        </div>
    </div>
  </div>

  <!-- Edit Type Modal Div -->
 <div class="modal fade" id="edit_item_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="edit_item_form" name="edit_item_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Prodcut Type</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="item_name">Item Name</label>
                      <input type="text" tabindex="1" class="form-control required" id="edit_item_name" name="edit_item_name" placeholder="Item  Name">
                      <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select id="edit_item_type" name="edit_item_type" class="form-control required">
                        <option value="">Select type...</option>
                        <?php
                          $query = "SELECT * FROM type_master";
                          $result = mysqli_query($dbc, $query);
                          if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo '<option value="'.$row['type_id'].'">'.$row['type_name'].'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="editItem();" >Save</button>
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


      getItems();
    });
  </script>
  <?php
    include('../footer.php');
  ?>
