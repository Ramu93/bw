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
        Out Gate Pass(Outward) - List
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
          <table id="ogp_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>OGP ID</th>
                <th>Created Date</th>
                <th>Vehicle Number</th>
                <th>Driver Name</th>
                <th>Driving License</th>
                <th>Vehicle Left</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT ol.ogp_lo_id, ol.jl_id, jl.pdr_id, il.vehicle_number, il.driver_name, il.driving_license, ol.status, ol.created_date FROM general_ogp_loading ol, general_joborder_loading jl, general_igp_loading il WHERE ol.jl_id=jl.jl_id AND jl.pdr_id=il.pdr_id AND ol.created_date BETWEEN '$filterFrom' AND '$filterTo' AND ol.status='$status'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    $isVehicleLeft = 'No';
                    if($row['status'] == 'completed'){
                      $isVehicleLeft = 'Yes';
                    }
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['ogp_lo_id']."</td>";
                    echo "<td>".$row['created_date']."</td>";
                    echo "<td>".$row['vehicle_number']."</td>";
                    echo "<td>".$row['driver_name']."</td>";
                    echo "<td>".$row['driving_license']."</td>";
                    echo "<td>".$isVehicleLeft."</td>";
                    echo "<td><a href='ogp-loading-view.php?ogp_lo_id=".$row['ogp_lo_id']."'>View</a></td>";
                    echo "</tr>";
                  }
                } else {
                  $dataTableFlag = false;
                  echo "<tr><td colspan=\"6\">No OGPs available.</td></tr>";
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
        $("#ogp_table").DataTable();
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
      var url = 'ogp-loading-list-view.php?status=';
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
