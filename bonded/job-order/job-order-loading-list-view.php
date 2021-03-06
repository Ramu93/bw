<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $status = 'created';
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
  if(isset($_GET['filter_from'])){
    $filterFrom = $_GET['filter_from'];
  } else {
    $filterFrom = date("Y-m-d");
  }
  if(isset($_GET['filter_to'])){
    $filterTo = $_GET['filter_to'];
  } else {
    $filterTo = date("Y-m-d");
  }
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
          <form onsubmit="return false;" method="">
            <div class="row">
              <div class="col-md-3">
                <label for="select_by_label">Status</label>
                <select class="form-control" tabindex="1" id="select_by_status" name="select_by_status">
                  <option value="created" <?php echo (($status=='created')?'selected="selected"':''); ?>>Created</option>
                  <option value="completed" <?php echo (($status=='completed')?'selected="selected"':''); ?>>Completed</option>
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
                <th>Job Order ID</th>
                <th>Created Date</th>
                <th>Type of Loading</th>
                <th>Supervisor Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT * FROM bonded_joborder_loading WHERE status='$status' AND created_date BETWEEN '$filterFrom' AND '$filterTo'";
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
                    echo "<td>".$row['created_date']."</td>";
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
      var url = 'job-order-loading-list-view.php?status=';
      switch(status){
        case 'created':
          url += 'created';
        break;
        case 'completed':
          url += 'completed';
        break;
      }
      url += '&filter_from=' + filterFrom + '&filter_to=' + filterTo;
      this.document.location.href = url;
    }
  </script>
