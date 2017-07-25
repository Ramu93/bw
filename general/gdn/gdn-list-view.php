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
        Good Delivery Note - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <table id="gdn_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>GDN ID</th>
                <th>PDR ID</th>
                <th>Importer</th>
                <th>CHA</th>
                <th>Transporter</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT gdn.gdn_id, pdr.pdr_id, par.cha_name, pdr.transporter_name, par.importing_firm_name FROM general_good_delivery_note gdn, general_despatch_request pdr, pre_arrival_request par WHERE gdn.pdr_id=pdr.pdr_id AND pdr.par_id=par.par_id";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['gdn_id']."</td>";
                    echo "<td>".$row['pdr_id']."</td>";
                    echo "<td>".$row['importing_firm_name']."</td>";
                    echo "<td>".$row['cha_name']."</td>";
                    echo "<td>".$row['transporter_name']."</td>";
                    echo "<td><a href='gdn-view.php?gdn_id=".$row['gdn_id']."'>View</a></td>";
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
        $("#gdn_table").DataTable();
      <?php } ?>
    });
  </script>
