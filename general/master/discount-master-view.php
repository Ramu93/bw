<?php
include('../header.php');
include('../sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Discount Tariff - View
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-body">
        <br />
        <div style="width: 100%;">
          <table id="tariff_table"  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S. No.</th>
                <th>Customer Name</th>
                <th>CHA Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT customer_pm_id, cha_pm_id FROM general_discount_master GROUP BY customer_pm_id, cha_pm_id";
                $result = mysqli_query($dbc, $query);
                if(mysqli_num_rows($result) > 0){
                  $count = 0;
                  while($row = mysqli_fetch_assoc($result)){
                    $customerPartyName = getPartyName($row['customer_pm_id']);
                    $chaPartyName = getPartyName($row['cha_pm_id']);
                    echo '<tr>
                            <td>'.++$count.'</td>
                            <td>'.$customerPartyName.'</td>
                            <td>'.$chaPartyName.'</td>
                            <td><a href="discount-master-edit.php?customer_pm_id='.$row['customer_pm_id'].'&cha_pm_id='.$row['cha_pm_id'].'">Edit</a></td>
                          </tr>';
                  }
                }

                function getPartyName($partyId){
                  global $dbc;
                  $query = "SELECT pm_customerName FROM general_party_master WHERE pm_id='$partyId'";
                  $result = mysqli_query($dbc, $query);
                  $out = '';
                  if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $out = $row['pm_customerName'];
                  }
                  return $out;
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
?>
<script type="text/javascript" src="<?php echo HOMEURL; ?>/master/js/master.js"></script>

<script type="text/javascript">
$('#tariff_table').DataTable();
</script>
<?php
include('../footer.php');
?>
