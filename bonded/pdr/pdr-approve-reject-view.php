<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $status = 'created';
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
  $filterFrom = $_GET['filter_from'];
  $filterTo = $_GET['filter_to'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Despatch Request - List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form onsubmit="return false;" method="">
            <div class="row">
              <div class="col-md-3">
                <label for="select_by_label">Status</label>
                <select class="form-control" tabindex="1" id="select_by_status" name="select_by_status">
                  <option value="created" <?php echo (($status=='created')?'selected="selected"':''); ?>>Created</option>
                  <option value="approved" <?php echo (($status=='approved')?'selected="selected"':''); ?>>Approved</option>
                  <option value="rejected" <?php echo (($status=='rejected')?'selected="selected"':''); ?>>Rejected</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-3">
                <label for="from_date_label">From date</label>
                <input type="text" tabindex="" class="form-control" id="filter_from" name="filter_from" placeholder="" value="">
              </div>
              <div class="col-md-3 col-sm-3">
                <label for="to_date_label">To date</label>
                <input type="text" tabindex="" class="form-control" id="filter_to" name="filter_to" placeholder="" value="">
              </div>
              <div class="col-md-3 col-sm-3">
                &nbsp;
                <input type="button" name="select_items" value="Go" class="btn btn-primary btn-block pull-left" onclick="loadPage()">
              </div>
            </div>
          </form>
            &nbsp;
          <table id="pdr_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>PDR ID</th>
                <th>SAC</th>
                <th>Created Date</th>
                <th>CHA/Exporter Name</th>
                <th>Client Web</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM bonded_despatch_request WHERE status='$status' AND created_date BETWEEN '$filterFrom' AND '$filterTo'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['pdr_id']."</td>";
                    echo "<td>".$row['sac_id']."</td>";
                    echo "<td>".$row['created_date']."</td>";
                    echo "<td>".$row['cha_name']."</td>";
                    echo "<td>".$row['client_web']."</td>";
                    echo "<td><a href='pdr-approve-reject.php?pdr_id=".$row['pdr_id']."'>View</a></td>";
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
  <script type="text/javascript" src="js/pdr.js"></script>
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

    $(document).ready(function(){
      $('#filter_from').val(getCurrentDate());
      $('#filter_to').val(getCurrentDate());
    });

    $('#filter_from').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });
    $('#filter_to').datepicker({
      autoclose: true,
      dateFormat: "yy-mm-dd",
    });
  </script>
