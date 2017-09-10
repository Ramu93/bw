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
                $select_query = "SELECT * FROM bonded_joborder_loading";
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
                            $loadingType =  '75% Manual + 25% Mechanical';
                          break;
                          case 3:
                            $loadingType =  '50% Manual + 50% Mechanical';
                          break;
                          case 4:
                            $loadingType =  '25% Manual + 75% Mechanical';
                          break;
                          case 5:
                            $loadingType =  '100% Mechanical';
                          break;
                          case 6:
                            $loadingType =  'Crane + Manual';
                          break;
                          case 7:
                            $loadingType =  'Crane + Mechanical + Manual';
                          break;
                          case 8:
                            $loadingType =  'Special Equipments';
                          break;
                          case 9:
                            $loadingType =  'Others';
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
