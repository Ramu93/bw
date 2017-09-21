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
        Out Gate Pass(Outward) - List
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
                <th>Vehicle Left</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT ol.ogp_lo_id, ol.jl_id, jl.pdr_id, il.vehicle_number, il.driver_name, il.driving_license, ol.status FROM bonded_ogp_loading ol, bonded_joborder_loading jl, bonded_igp_loading il WHERE ol.jl_id=jl.jl_id AND jl.pdr_id=il.pdr_id";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    $isVehicleLeft = 'No';
                    if($row['status'] == 'completed'){
                      $isVehicleLeft = 'Yes';
                    }
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['ogp_lo_id']."</td>";
                    echo "<td>".$row['vehicle_number']."</td>";
                    echo "<td>".$row['driver_name']."</td>";
                    echo "<td>".$row['driving_license']."</td>";
                    echo "<td>".$isVehicleLeft."</td>";
                    echo "<td><a href='ogp-loading-view.php?ogp_lo_id=".$row['ogp_lo_id']."'>View</a></td>";
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
