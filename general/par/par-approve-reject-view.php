
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
        Pre Arrival Request - List
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
                <th>PAR ID</th>
                <th>Importing Firm Name</th>
                <th>Assessable Value</th>
                <th>Quantity in Units</th>
                <th>Space Requirement</th>
                <th>Expected Date of Warehousing</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM pre_arrival_request WHERE status<>'approved' AND status<>'rejected'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['par_id']."</td>";
                    echo "<td>".$row['importing_firm_name']."</td>";
                    echo "<td>".$row['assessable_value']."</td>";
                    echo "<td>".$row['expected_date']."</td>";
                    echo "<td>".$row['space_requirement']."</td>";
                    echo "<td>".$row['qty_units']."</td>";
                    echo "<td><a href='par-approve-reject.php?par_id=".$row['par_id']."'>Approve/Reject</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"8\">No PARs available.</td></tr>";
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
