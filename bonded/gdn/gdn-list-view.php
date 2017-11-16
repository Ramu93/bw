<?php
  include('../header.php');
  include('../sidebar.php');
  include('../dbconfig.php');

  $filterFrom = $_GET['filter_from'];
  $filterTo = $_GET['filter_to'];
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
          <form onsubmit="return false;" method="">
            <div class="row">
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
          <table id="gdn_table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>GDN ID</th>
                <th>PDR ID</th>
                <th>Created Date</th>
                <th>Bond Number</th>
                <th>Importer</th>
                <th>CHA</th>
                <th>Transporter</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $select_query = "SELECT gdn.gdn_id, pdr.pdr_id, dv.bond_number, sac.cha_name, pdr.transporter_name, sac.importing_firm_name, gdn.created_date FROM bonded_good_delivery_note gdn, bonded_despatch_request pdr, sac_request sac, bonded_dv_inward dv WHERE gdn.pdr_id=pdr.pdr_id AND pdr.sac_id=sac.sac_id AND pdr.sac_id=dv.sac_id AND gdn.created_date BETWEEN '$filterFrom' AND '$filterTo'";
                $result = mysqli_query($dbc,$select_query);
                $row_counter = 0;
                if(mysqli_num_rows($result) > 0) {
                  $dataTableFlag = true;
                  while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".++$row_counter."</td>";
                    echo "<td>".$row['gdn_id']."</td>";
                    echo "<td>".$row['pdr_id']."</td>";
                    echo "<td>".$row['created_date']."</td>";
                    echo "<td>".$row['bond_number']."</td>";
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
      var filterFrom = $('#filter_from').val();
      var filterTo = $('#filter_to').val();
      var url = 'gdn-list-view.php?';
      url += '&filter_from=' + filterFrom + '&filter_to=' + filterTo;
      this.document.location.href = url;
    }
  </script>
