
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Despatch Request - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>S. No.</th>
              <th>PDR ID</th>
              <th>PDR Type</th>
              <th>Created Date and Time</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>001</td>
              <td>CUSTOMER-8</td>
              <td>2016-08-30 15:46:50</td>
              <td><a href="#">Edit</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>005</td>
              <td>CUSTOMER-9</td>
              <td>2016-09-07 09:59:39</td>
              <td><a href="#">Edit</a></td>
            </tr>
          </table>
        </div>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    include('../footer_imports.php');
    include('../footer.php');
  ?>
  
  <script>
    $(function () {
      $("#example1").DataTable();
    });
  </script>
