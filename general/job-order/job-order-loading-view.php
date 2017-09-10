<?php
  include('../header.php');
  include('../sidebar.php');
  require('../dbconfig.php'); 

  $out = array();
  $jlId = $_GET['jl_id'];
  $select = "SELECT * FROM general_joborder_loading WHERE jl_id='$jlId'";
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
        Job Order Loading - View
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="joborder-loading-form" name="joborder-loading-form" action="#" method="post" onsubmit="return false;">
          <div id="printdiv">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="igp_unloading_id">Job Order Loading ID:</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['jl_id']; ?></label>
                </div>
              </div>
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Date:</label>
                  <div class="clearfix"></div>
                  <label><?php //echo $out['date']; ?></label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date" id="time">Time:</label>
                  <div class="clearfix"></div>
                  <label><?php ?></label>
                </div>
              </div> -->
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="weight">Weight:</label>
                  <div class="clearfix"></div>
                  <label><?php ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_of_packages">No. of Packages:</label>
                  <div class="clearfix"></div>
                  <label><?php  ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <label for="description">Description:</label>
                <div class="clearfix"></div>
                  <label><?php ?></label>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-3">
                <label for="supervisor_name">Supervisor Name:</label>
                <div class="clearfix"></div>
                  <label><?php echo $out['supervisor_name']; ?></label>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="container_number">Type of Loading:</label>
                  <div class="clearfix"></div>
                  <label>
                    <?php 
                        switch($out['loading_type']){
                          case 1:
                            echo 'Manual 100%';
                          break;
                          case 2:
                            echo '75% Manual + 25% Mechanical';
                          break;
                          case 3:
                            echo '50% Manual + 50% Mechanical';
                          break;
                          case 4:
                            echo '25% Manual + 75% Mechanical';
                          break;
                          case 5:
                            echo '100% Mechanical';
                          break;
                          case 6:
                            echo 'Crane + Manual';
                          break;
                          case 7:
                            echo 'Crane + Mechanical + Manual';
                          break;
                          case 8:
                            echo 'Special Equipments';
                          break;
                          case 9:
                            echo 'Others';
                          break;
                        }
                    ?> 
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <?php if($out['equipment_ref_number'] != '') { ?>
                  <label for="equipment_ref_number">Equipment Reference Number:</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['equipment_ref_number']; ?></label>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="container_condition">Number of Labors:</label>
                  <div class="form-group">
                    <div class="clearfix"></div>
                    <label><?php echo $out['no_of_labors']; ?></label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label for="">Loading Time:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['loading_time']; ?></label>
              </div>
              <!-- <div class="col-md-3">
                <label for="transporter_name">Dimension per Unit and Weight:</label>
                <div class="clearfix"></div>
                <label><?php //echo $out['dimension']; ?></label>
              </div> -->
            </div>
            <div class="row">
              <table id="view_items_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S. No.</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Despatch Qty.</th>
                  </tr>
                </thead>
                <tbody id="item_list_tbody">
                 <?php
                  $pdrId = $out['pdr_id'];
                    $query = "SELECT * FROM general_pdr_items WHERE pdr_id='$pdrId'";
                    $itemsResult = mysqli_query($dbc, $query);
                    if(mysqli_num_rows($itemsResult) > 0){
                      $counter = 1;
                      while ($itemsRow = mysqli_fetch_assoc($itemsResult)){
                        echo '<tr>';
                          echo '<td>';
                            echo $counter++;
                          echo '</td>';
                          echo '<td>';
                            echo $itemsRow['pdr_item_id'];
                          echo '</td>';
                          echo '<td>';
                            echo $itemsRow['item_name'];
                          echo '</td>';
                          echo '<td>';
                            echo $itemsRow['despatch_qty'];
                          echo '</td>';
                        echo '</tr>';
                      }
                    }
                 ?>
                </tbody>
              </table>
            </div>
            <!-- printDiv close -->
            </div> 
            
            <div class="row">
              <div class="col-md-12 col-sm-12 margin_bottom_40">
              <div class="col-md-2 col-sm-2"></div>
              <div class="col-md-8 col-sm-8">
                <?php if($out['status'] == 'created'){ ?>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="completeJobOrder(<?php echo $jlId; ?>);" value="Complete Joborder">
                </div>
                <?php } else if($out['status'] == 'completed'){ ?>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="printJobOrder('printdiv');" value="Print Job Order">
                </div>
                <?php } ?>
              </div>
              <div class="col-md-2 col-sm-2"></div>
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
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/job-order/js/job-order-loading.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#igp-loading-form').validate({
        errorClass: "my-error-class"
      });

     
      //change label name according to selected value
      $('#select_by_type').on('change', function() {
        $('#data_item').val('');
        changeLabelText();
      })

    });
    
  </script>
  <?php
    include('../footer.php');
  ?>
