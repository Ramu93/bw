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
        Document Verification Outward - List View
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="pdr_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>PDR ID</th>
                <th>SAC ID</th>
                <th>CHA Name</th>
                <th>Client Web</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM bonded_despatch_request WHERE document_verified='no' AND igp_created='yes' AND status='approved'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['pdr_id']."</td>";
                    echo "<td>".$row['sac_id']."</td>";
                    echo "<td>".$row['cha_name']."</td>";
                    echo "<td>".$row['client_web']."</td>";
                    echo "<td><a href='dv-out.php?pdr_id=".$row['pdr_id']."'>Verify</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"6\">No PDRs available.</td></tr>";
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
        $("#pdr_table").DataTable();
      <?php } ?>
    });
  </script>
