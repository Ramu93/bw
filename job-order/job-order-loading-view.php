
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Job Order Loading - List
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
              <th>Job Order Loading ID</th>
              <th>PAR ID</th>
              <th>IGP Outward ID</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>jo_ul_ZX14718Wj50419</td>
              <td>par_EL14718sI50231</td>
              <td>igp_outward_uB14718Mg50375</td>
              <td><a href="#">View</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>jo_ul_ZX14718Wj50417</td>
              <td>par_EL14718sI50654</td>
              <td>igp_outward_uB14718Mg55695</td>
              <td><a href="#">View</a></td>
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
