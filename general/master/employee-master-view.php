<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee Master - View
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
              <th>Employee Name</th>
              <th>Employee ID</th>
              <th>Login ID</th>
              <th>View</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>Ram</td>
              <td>234</td>
              <td>ram</td>
              <td><a>View</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Ron</td>
              <td>235</td>
              <td>rom</td>
              <td><a>View</a></td>
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
