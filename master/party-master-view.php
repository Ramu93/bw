
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Party Master - List
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
              <th>Customer Name</th>
              <th>City</th>
              <th>State</th>
              <th>Primary Contact</th>
              <th>Primary Mobile</th>
              <th>Primary Email</th>
              <th>Credit Days</th>
              <th>Credit Limit</th>
              <th>Opening Balance</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Ram</td>
              <td>Chennai</td>
              <td>TN</td>
              <td>RR  </td>
              <td>9876543210</td>
              <td>r@r.com</td>
              <td>20</td>
              <td>10000</td>
              <td>10000</td>
              <td><a>Edit</a></td>
              <td><a>Delete</a></td>
            </tr>
            <tr>
              <td>Ron</td>
              <td>Chennai</td>
              <td>TN</td>
              <td>RR  </td>
              <td>9874563210</td>
              <td>r@r.com</td>
              <td>20</td>
              <td>20000</td>
              <td>20000</td>
              <td><a>Edit</a></td>
              <td><a>Delete</a></td>
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
