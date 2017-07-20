
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Despatch Request - Create
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="bond_number">Bond Number</label>
              <input type="text" class="form-control" id="bond_number" name="bond_number" placeholder="Bond Number">
            </div>
            <div class="col-md-3">
              <div class="clearfix">&nbsp;</div>
              <input type="button" tabindex="3" name="view_list_button" value="View List" class="btn btn-primary btn-block pull-left" onclick="getBondOrderList();">
            </div>
            <div class="col-md-3">
              <div class="control-group">
                <div class="clearfix">&nbsp;</div>
                <span id="data_fetch_message"></span>
              </div>
            </div>
          </div>
          <form id="pdr_create_form" action="#" method="post" onsubmit="return false;">
            <div class="row" id="fields">
              <div class="form-group col-md-4">
                <label for="par_id" id="sac_par_table_label"></label>
                <input type="text" class="form-control" id="par_id" name="par_id" readonly="true">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-4">
                <label for="client_web">Client Web</label>
                <select class="form-control" id="client_web" name="client_web" class="client-web" required="">
                  <option value="">Select client web...</option>
                  <option value="Debond">Debond</option>
                  <option value="Inbond Sales">Inbond Sales</option>
                  <option value="Reexport">Reexport</option>
                  <option value="Transfer Bond">Transfer Bond</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="order_number">CHA Name/Exporter</label>
                <input type="text" class="form-control" id="cha_name_exporter" name="cha_name_exporter" placeholder="CHA Name/Exporter">
              </div>
              <div class="form-group col-md-4">
                <label for="order_number">Order Number</label>
                <input type="text" class="form-control" id="order_number" name="order_number" placeholder="Order Number">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="boe_number">BOE Number</label>
                <input type="text" class="form-control" id="boe_number" name="boe_number" placeholder="BOE Number">
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_number">EXBond BE Number</label>
                <input type="text" class="form-control" id="exbond_be_number" name="exbond_be_number" placeholder="EXBond BE Number">
              </div>
              <div class="form-group col-md-3">
                <label for="exbond_be_date">EXBond BE Date</label>
                <input type="text" class="form-control" id="exbond_be_date" name="exbond_be_date" placeholder="EXBond BE Date">
              </div>
              <div class="form-group col-md-3">
                <label for="customs_officer_name">Customer Officer Name</label>
                <input type="text" class="form-control" id="customs_officer_name" name="customs_officer_name" placeholder="Customer Officer Name">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-3">
                <label for="packages_number">Number of Packages</label>
                <input type="text" class="form-control" id="packages_number" name="packages_number" placeholder="Number of Packages">
              </div>
              <div class="form-group col-md-3">
                <label for="assessment_value">Assessment Value</label>
                <input type="text" class="form-control" id="assessment_value" name="assessment_value" placeholder="Assessment Value">
              </div>
              <div class="form-group col-md-3">
                <label for="duty_value">Duty Value</label>
                <input type="text" class="form-control" id="duty_value" name="duty_value" placeholder="Duty Value">
              </div>
              <div class="form-group col-md-3">
                <label for="transporter_name">Transporter Name</label>
                <input type="text" class="form-control" id="transporter_name" name="transporter_name" placeholder="Transporter Name">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <input type="button" name="select_items" value="Select Items" class="btn btn-success btn-block pull-left" onclick="showItemsList()">
              </div>
              <div class="col-md-3 col-sm-3">
                <input type="submit" id="create_pdr_btn" name="submit" value="Create PDR" class="btn btn-primary btn-block pull-left" onclick="createPDR()">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.box -->

      <!--Bond Order Modal Div -->
      <div class="modal fade" id="view_list_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form  id="dataapprovedlist_form" name="dataapprovedlist_form" method="post" class="validator-form1" action="" onsubmit="return false;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="modal_title">Bond Orders</h4>
                </div>
                <div class="modal-body">
                  <div class="responsive">
                      <table id="tariff_master_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Bond Order ID</th>
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

      <!--Items Modal -->
      <div class="modal fade" id="select_items_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form  id="select_items_form" name="dataapprovedlist_form" method="post" class="validator-form1" action="" onsubmit="return false;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="modal_title">Item List</h4>
                </div>
                <div class="modal-body">
                  <div class="responsive">
                    <table id="tariff_master_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Item ID</th>
                                  <th>Item Name</th>
                                  <th>Available Qty.</th>
                                  <th>Despatch Qty.</th>
                              </tr>
                          </thead>
                          <tbody id="item_list_tbody">
                           
                          </tbody>
                      </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" onclick="setDespatchQtyForItems()" class="btn btn-default" data-dismiss="modal">Close</button>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/pdr/js/pdr.js""></script>
  <script type="text/javascript">
    //Date picker
    $('#exbond_be_date').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd"
    });

    $('#pdr_create_form').validate({
      errorClass: "my-error-class"
    });

    $('#fields').hide();
    $('#create_pdr_btn').hide();

  </script>
  <?php
    include('../footer.php');
  ?>
