
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
          <div class="form-group">
            <label for="bond_orders"></label>
            <select class="form-control" id="bond_orders" name="bond_orders" required="">
              <option value="">Bond Order 1</option>
              <option value="">Bond Order 2</option>
              <option value="">Bond Order 3</option>
            </select>
          </div>
          <form action="#" method="post" onsubmit="return false;">
            <div class="form-group">
              <label for="order_number">Order Number</label>
              <input type="text" class="form-control" id="order_number" name="order_number" placeholder="">
            </div>
            <div class="form-group">
              <label for="boe_number">BOE Number</label>
              <input type="text" class="form-control" id="boe_number" name="boe_number" placeholder="">
            </div>
            <div class="form-group">
              <label for="exbond_be_number">EXBond BE Number</label>
              <input type="text" class="form-control" id="exbond_be_number" name="exbond_be_number" placeholder="EXBond BE Number">
            </div>
            <div class="form-group">
              <label for="exbond_be_date">EXBond BE Date</label>
              <input type="text" class="form-control" id="exbond_be_date" name="exbond_be_date" placeholder="EXBond BE Date">
            </div>
            <div class="form-group">
              <label for="customs_officer_name">Customer Officer Name</label>
              <input type="text" class="form-control" id="customs_officer_name" name="customs_officer_name" placeholder="Customer Officer Name">
            </div>
            <div class="form-group">
              <label for="packages_number">Number of Packages</label>
              <input type="text" class="form-control" id="packages_number" name="packages_number" placeholder="Number of Packages">
            </div>
            <div class="form-group">
              <label for="items_number">Number of Items</label>
              <input type="text" class="form-control" id="items_number" name="items_number" placeholder="Number of Items">
            </div>
            <div class="form-group">
              <label for="transport_details">Transport Details</label>
              <input type="text" class="form-control" id="transport_details" name="transport_details" placeholder="Number of Items">
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <input type="submit" name="submit" value="Create PDR" class="btn btn-primary btn-block pull-left" onclick="">
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
  <script type="text/javascript">
    //Date picker
    $('#expected_date').datepicker({
      autoclose: true
    });
  </script>
  <?php
    include('../footer.php');
  ?>
