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
          <table id="party_table" class="table table-bordered table-striped">
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
              <?php 
                $query = "SELECT * FROM party_master WHERE pm_active_status = 'yes'";
                $result = mysqli_query($dbc, $query);
                if(mysqli_num_rows($result) > 0){
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                      echo '<td>'.$row['pm_customerName'].'</td>';
                      echo '<td>'.$row['pm_cityTown'].'</td>';
                      echo '<td>'.$row['pm_state'].'</td>';
                      echo '<td>'.$row['pm_primaryContact'].'</td>';
                      echo '<td>'.$row['pm_primaryContactMobile'].'</td>';
                      echo '<td>'.$row['pm_primaryContactEmail'].'</td>';
                      echo '<td>'.$row['pm_ccd'].'</td>';
                      echo '<td>'.$row['pm_ccLimit'].'</td>';
                      echo '<td>'.$row['pm_ccBalance'].'</td>';
                      echo '<td><a href="party-master-edit.php?pm_id='.$row['pm_id'].'">Edit</a></td>';
                      echo '<td><a onclick="deleteParty('.$row['pm_id'].')">Delete</a></td>';
                    echo '</tr>';
                  }
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
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/master/js/master.js"></script>
  <?php
    include('../footer.php');
  ?>
  
  <script>
    $(function () {
      $("#party_table").DataTable();
    });
  </script>
