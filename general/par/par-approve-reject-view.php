<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $status = 'submitted';
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
        Pre Arrival Request - List
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
                  <option value="submitted" <?php echo (($status=='submitted')?'selected="selected"':''); ?>>Created</option>
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
          <table id="par_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>PAR ID</th>
                <th>Importing Firm Name</th>
                <th>CHA</th>
                <th>Quantity in Units</th>
                <th>Space Requirement</th>
                <th>Expected Date of Warehousing</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM pre_arrival_request WHERE status='$status' AND created_date BETWEEN '$filterFrom' AND '$filterTo'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['par_id']."</td>";
                    echo "<td>".$row['importing_firm_name']."</td>";
                    echo "<td>".$row['cha_name']."</td>";
                    echo "<td>".$row['qty_units']."</td>";
                    echo "<td>".$row['space_requirement']."</td>";
                    echo "<td>".$row['expected_date']."</td>";
                    echo "<td><a href='par-approve-reject.php?par_id=".$row['par_id']."'>View</a></td>";
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

    function getCurrentDate(){
      var today = new Date();
      var yy = today.getFullYear();
      var mm = today.getMonth();
      var dd = today.getDate();
      mm += 1;
      if(dd < 10){
        dd = '0' + dd;
      } 
      if(mm < 10){
        mm = '0' + mm;
      }
      var todayDate = yy + '-' + mm + '-' + dd;
      return todayDate;
    }

    function loadPage(){
      var status = $('#select_by_status').val();
      var filterFrom = $('#filter_from').val();
      var filterTo = $('#filter_to').val();
      var url = 'par-approve-reject-view.php?status=';
      switch(status){
        case 'submitted':
          url += 'submitted';
        break;
        case 'approved':
          url += 'approved';
        break;
        case 'rejected':
          url += 'rejected';
        break;
      }
      url += '&filter_from=' + filterFrom + '&filter_to=' + filterTo;
      this.document.location.href = url;
    }
  </script>
