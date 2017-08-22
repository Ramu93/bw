<?php
include('../header.php');
include('../sidebar.php');

$customerPartyId = $_GET['customer_pm_id'];
$chaPartyId = $_GET['cha_pm_id'];

$query = "SELECT * FROM discount_master WHERE customer_pm_id='$customerPartyId' AND cha_pm_id='$chaPartyId'";
$result =  mysqli_query($dbc, $query);
$out = array();
while($row = mysqli_fetch_assoc($result)){
  $out[] = $row;
}

$customerPartyName = getPartyName($customerPartyId);
$chaPartyName = getPartyName($chaPartyId);



function getPartyName($partyId){
  global $dbc;
  $query = "SELECT pm_customerName FROM party_master WHERE pm_id='$partyId'";
  $result = mysqli_query($dbc, $query);
  $out = '';
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $out = $row['pm_customerName'];
  }
  return $out;
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Discount Master
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-body">
        <form  id="discount_tariff_form" name="discount_tariff_form" method="post" class="validator-form1" action="" onsubmit="return false;">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="importing_firm_name">Name of the Importer/Customer</label>
                <input type="text" tabindex="1" class="form-control required autofillparty" id="importing_firm_name" name="importing_firm_name" placeholder="Name of the importing firm" value="<?php echo $customerPartyName; ?>" disabled="disabled">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cha_name_label">Name of the CHA</label>
                <input type="text" tabindex="1" class="form-control required autofillparty" id="cha_name" name="cha_name" placeholder="Name of the CHA" value="<?php echo $chaPartyName; ?>" disabled="disabled">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group" id="customer_details_div">
                <label for="importing_firm_name">Party Master ID:</label>
                <div class="clearfix"></div>
                <label id="customer_id_label"><?php echo $customerPartyId; ?></label>
                <input type="hidden" name="customer_id_hidden" id="customer_id_hidden" value="<?php echo $customerPartyId; ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group" id="cha_details_div">
                <label for="importing_firm_name">Party Master ID:</label>
                <div class="clearfix"></div>
                <label id="cha_id_label"><?php echo $chaPartyId; ?></label>
                <input type="hidden" name="cha_id_hidden" id="cha_id_hidden" value="<?php echo $chaPartyId; ?>">
              </div>
            </div>
          </div>
          <div>
            <table id="pdr_items_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Service Type</th>
                  <th>Unit</th>
                  <th>Price Per Unit</th>
                  <th>Minimum Slab</th>
                  <th>Discount %</th>
                  <th>Discount Rate</th>
                </tr>
              </thead>
              <tbody>

                  <?php
                    $query = "SELECT * FROM tariff_master ORDER BY tariff_master_id";
                    $result = mysqli_query($dbc, $query);
                    if(mysqli_num_rows($result) > 0){
                      $count = 0;
                      while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                                <td>'.++$count.'</td>
                                <td>'.$row['service_type'].'</td>
                                <td>'.$row['unit'].'</td>
                                <td>'.$row['price_per_unit'].'</td>
                                <td>'.$row['minimum_slab'].'</td>
                                <td><input type="text" name="discount_percentage[]" onkeyup="changeDiscountRate('.$row['tariff_master_id'].')" id="'.$row['tariff_master_id'].'_discount_percentage" value="';

                        for($i = 0; $i < count($out); $i++){
                          if($out[$i]['tariff_master_id'] == $row['tariff_master_id']){
                              echo $out[$i]['discount_percentage'];   
                              break;
                          } else {
                              echo '';
                          }
                        }

                        echo '"></td>
                              <td><input type="text" name="'.$row['tariff_master_id'].'_discount_amount" id="'.$row['tariff_master_id'].'_discount_amount" onkeyup="changeDiscountPercentage('.$row['tariff_master_id'].')" >
                                  <input type="hidden" name="'.$row['tariff_master_id'].'_discount_rate" id="'.$row['tariff_master_id'].'_discount_rate" value="'.$row['price_per_unit'].'" >
                                  <input type="hidden" name="tariff_master_id_hidden[]" id="tariff_master_id_hidden" value="'.$row['tariff_master_id'].'" >
                                </td>
                              </tr>';
                        
                      }
                    }
                  ?>
                
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <input type="button" class="btn btn-primary btn-block" onclick="window.location='discount-master-view.php';" value="View Discount Tariffs">
            </div>
            <div class="col-md-4 col-sm-4">
              <input type="button" class="btn btn-primary btn-block" onclick="updateDiscountTariff()" value="Update">
            </div>
            <div class="col-md-4 col-sm-4">
              <span id="updated_message" style="color: red;"></span>
            </div>
          </div>
        </form> 
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
<script type="text/javascript">
$(document).ready(function(){
  $('#discount_tariff_form').validate({
    errorClass: "my-error-class"
  });
});

$('.autofillparty').autocomplete({
  source : "auto-complete-services.php?action=fetch_party_info",
  minLength : 2,
  select : function(event, ui) {
          
          if(ui.item.value == "No customers found"){
            event.preventDefault();
            // $('#customer_name').val('');
          }else{
          }
      },
});

$('#importing_firm_name').on('change', function(){
  getPartyDetails('customer');
});
$('#cha_name').on('change', function(){
  getPartyDetails('cha');
});

//for enter key press
$('#importing_firm_name').keypress(function(event){
  if(event.which == 13){
    getPartyDetails('customer');
  }
});
$('#cha_name').keypress(function(event){
  if(event.which == 13){
    getPartyDetails('cha');
  }
});

</script>
<?php
include('../footer.php');
?>