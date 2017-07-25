<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $out = array();
  $gdnId = $_GET['gdn_id'];
  $select = "SELECT gdn.gdn_id, pdr.pdr_id, dv.bond_number, sac.cha_name, pdr.transporter_name, sac.importing_firm_name, pdr.boe_number FROM bonded_good_delivery_note gdn, bonded_despatch_request pdr, sac_request sac, bonded_dv_inward dv WHERE gdn.pdr_id=pdr.pdr_id AND pdr.sac_id=sac.sac_id AND pdr.sac_id=dv.sac_id AND gdn.gdn_id='$gdnId'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $out = $row;
  }
  // file_put_contents("editlog.log", print_r( $out, true ));
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Goods Delivery Note - View
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="grn_form" name="job_ordgrn_former_unloading_form" action="#" method="post" onsubmit="return false;">
            <input type="hidden" name="par_id" id="par_id" value="">
            <input type="hidden" name="grn_id" id="grn_id" value="">
            <div id="printdiv">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="" id="">GDN ID:</label>
                    <div class="clearfix"></div>
                    <label id="grn_value"><?php echo $gdnId; ?></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <label id="id_label">PDR ID:</label>
                  <div class="clearfix"></div>
                  <label id="id_value"><?php echo $out['pdr_id']; ?></label>
                </div>
                <div class="col-md-3">
                  <label id="customer_name_label">Importer Name:</label>
                  <div class="clearfix"></div>
                  <label id="customer_name_value"><?php echo $out['importing_firm_name']; ?></label>
                </div>
                <div class="col-md-3">
                  <label id="customer_name_label">CHA Name:</label>
                  <div class="clearfix"></div>
                  <label id="customer_name_value"><?php echo $out['cha_name']; ?></label>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="row">
                
              </div>
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-3">
                  <label id="licence_code_label">Bond Number:</label>
                  <div class="clearfix"></div>
                  <label id="licence_code"><?php echo $out['bond_number']; ?></label>
                </div>
                <div class="col-md-3">
                  <label id="bol_awb_number_label">Transporter Name:</label>
                  <div class="clearfix"></div>
                  <label id="bol_awb_number"><?php echo $out['transporter_name']; ?></label>
                </div>
                <div class="col-md-3">
                  <label id="boe_number_label">BOE Number:</label>
                  <div class="clearfix"></div>
                  <label id="boe_number"><?php echo $out['boe_number']; ?></label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <table id="pdr_items_table"  class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S. No.</th>
                        <th>Item Name</th>
                        <th>Container Number</th>
                        <th>Despatch Qty.</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php
                          $query = "SELECT * FROM bonded_pdr_items WHERE pdr_id='".$out['pdr_id']."'";
                          $result = mysqli_query($dbc, $query);
                          if(mysqli_num_rows($result) > 0){
                            $counter = 1;
                            while($itemRow = mysqli_fetch_assoc($result)){
                              echo '<tr>
                                        <td>'.$counter++.'</td>
                                        <td>'.$itemRow['item_name'].'</td>
                                        <td>'.$itemRow['container_number'].'</td>
                                        <td>'.$itemRow['despatch_qty'].'</td>
                                    </tr>';
                            }
                          }
                        ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
              </div>
              <div class="col-md-4 col-sm-4">
                <input type="submit" name="submit" id="create_gdn_button" value="Print GDN" class="btn btn-primary btn-block pull-left" onclick="printGDN('printdiv');">
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/gdn/js/gdn.js"></script>
  <script type="text/javascript">

    $( document ).ready(function() {
      
    });
  
  </script>
  <?php
    include('../footer.php');
  ?>
