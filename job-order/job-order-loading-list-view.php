
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
        Job Order Loading - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="par_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>Job Order ID</th>
                <!-- <th>No. of Packages</th> -->
                <th>Type of Loading</th>
                <th>Supervisor Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM joborder_loading";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    switch($row['loading_type']){
                      case 1:
                        $loadingType = 'Manual 100%';
                      break;
                      case 2:
                        $loadingType = '75% Manual + 25% FLT';
                      break;
                      case 3:
                        $loadingType = '50% Manual + 50% FLT 25%-';
                      break;
                      case 4:
                        $loadingType = 'Manual 75% + FLT FLT100%-';
                      break;
                      case 5:
                        $loadingType = 'Crane + Manual Spl';
                      break;
                      case 6:
                        $loadingType = 'Equipments + Manual';
                      break;
                    }

                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['jl_id']."</td>";
                    // echo "<td>".$row['no_of_packages']."</td>";
                    echo "<td>".$loadingType."</td>";
                    echo "<td>".$row['supervisor_name']."</td>";
                    echo "<td><a href='job-order-loading-view.php?jl_id=".$row['jl_id']."'>View</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"6\">No Job Orders available.</td></tr>";
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
        $("#par_table").DataTable();
      <?php } ?>
    });
  </script>
