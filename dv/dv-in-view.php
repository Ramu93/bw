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
        Document Verification Inward - List View
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
                <th>ID</th>
                <th>Importing Firm Name</th>
                <th>Licence Code</th>
                <th>BOL/AWB No.</th>
                <th>BOE No.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT sac_id as 'id', 'SAC' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number FROM sac_request WHERE document_verified='no' UNION SELECT par_id as 'id', 'PAR' as 'table_name', importing_firm_name, licence_code, bol_awb_number, boe_number FROM pre_arrival_request WHERE document_verified='no'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['table_name'] . ' ID: ' . $row['id']."</td>";
                    echo "<td>".$row['importing_firm_name']."</td>";
                    echo "<td>".$row['licence_code']."</td>";
                    echo "<td>".$row['bol_awb_number']."</td>";
                    echo "<td>".$row['boe_number']."</td>";
                    echo "<td><a href='dv-in.php?id=".$row['id']."&table=".$row['table_name']. "'>Verify</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"7\">No Data available.</td></tr>";
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
