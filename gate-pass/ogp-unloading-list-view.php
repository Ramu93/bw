
  <?php
    include('../header.php');
    include('../sidebar.php');
    include('../dbconfig.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Out Gate Pass(Inward) - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="ogp_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>OGP ID</th>
                <th>Vehicle Number</th>
                <th>Driver Name</th>
                <th>Driving License</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT ou.ogp_un_id, ju.ju_id, ju.sac_par_table, ju.sac_par_id, iu.vehicle_number, iu.driver_name, iu.driving_license FROM ogp_unloading ou, joborder_unloading ju, igp_unloading iu WHERE ou.ju_id=ju.ju_id AND ju.sac_par_table=iu.sac_par_table AND ju.sac_par_id=iu.sac_par_id AND ou.status='created'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['ogp_un_id']."</td>";
                    echo "<td>".$row['vehicle_number']."</td>";
                    echo "<td>".$row['driver_name']."</td>";
                    echo "<td>".$row['driving_license']."</td>";
                    echo "<td><a href='ogp-unloading-view.php?ogp_un_id=".$row['ogp_un_id']."'>View</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"6\">No OGPs available.</td></tr>";
                }
              ?>
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
  <?php
    include('../footer_imports.php');
    include('../footer.php');
  ?>
  
  <script>
    $(function () {
      <?php if($dataTableFlag) { ?>
        $("#ogp_table").DataTable();
      <?php } ?>
    });
  </script>
