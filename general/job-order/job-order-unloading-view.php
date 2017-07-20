
  <?php
    include('../header.php');
    include('../sidebar.php');
    require('../dbconfig.php'); 

    $out = array();
    $juId = $_GET['ju_id'];
    $select = "SELECT * FROM general_joborder_unloading WHERE ju_id='$juId'";
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
        Job Order Unloading - View
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form id="igp-unloading-form" name="igp-unloading-form" action="#" method="post" onsubmit="return false;">
          <div id="printdiv">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="igp_unloading_id">Job Order Unloading ID:</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['ju_id']; ?></label>
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
                  <label><?php //echo $out['time_in']; ?></label>
                </div>
              </div> -->
            </div>
            <div class="row">
              
              <div class="col-md-4">
                <div class="form-group">
                  <label for="weight">Weight:</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['weight']; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="no_of_packages">No. of Packages:</label>
                  <div class="clearfix"></div>
                  <label><?php echo $out['no_of_packages']; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <label for="description">Description:</label>
                <div class="clearfix"></div>
                  <label><?php echo $out['description']; ?></label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label for="supervisor_name">Supervisor Name:</label>
                <div class="clearfix"></div>
                  <label><?php echo $out['supervisor_name']; ?></label>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="container_number">Type of Unloading:</label>
                  <div class="clearfix"></div>
                  <label>
                    <?php 
                        switch($out['unloading_type']){
                          case 1:
                            echo 'Manual 100%';
                          break;
                          case 2:
                            echo '75% Manual + 25% FLT';
                          break;
                          case 3:
                            echo '50% Manual + 50% FLT 25%-';
                          break;
                          case 4:
                            echo 'Manual 75% + FLT FLT100%-';
                          break;
                          case 5:
                            echo 'Crane + Manual Spl';
                          break;
                          case 6:
                            echo 'Equipments + Manual';
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
                <label for="vehicle_type">Unloading Time:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['unloading_time']; ?></label>
              </div>
              <div class="col-md-3">
                <label for="transporter_name">Dimension per Unit and Weight:</label>
                <div class="clearfix"></div>
                <label><?php echo $out['dimension']; ?></label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 margin_bottom_40">
              <div class="col-md-2 col-sm-2"></div>
              <div class="col-md-8 col-sm-8">
                <?php if($out['status'] == 'created' || $out['status'] == 'exceptioncomplete'){ ?>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="completeJobOrder(<?php echo $juId; ?>);" value="Complete Joborder">
                </div>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="showRaiseException();" value="Raise Exception">
                </div>
                <?php }elseif($out['status'] == 'exception'){ ?>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="showCloseException();" value="Close Exception">
                </div>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="rejectJobOrder(<?php echo $juId; ?>);" value="Reject Joborder">
                </div>
                <?php }elseif($out['status'] == 'completed'){ ?>
                <div class="col-md-6 col-md-6">
                  <input type="button" class="btn btn-primary btn-block" onclick="printJobOrder('printdiv');" value="Print Job Order">
                </div>
                <?php } ?>
              </div>
              <div class="col-md-2 col-sm-2"></div>
            </div>
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

  <!--Modal Div -->
  <div class="modal fade" id="raiseexception_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
          <div class="modal-content">
              <form  id="exception_form" name="exception_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
                <input type="hidden" name="ju_id" id="ju_id" value="<?php echo $out['ju_id']; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Exception Details</h4>
                </div>
                <div class="modal-body">
                  <div class="col-md-4">
                    <label>Exception Type</label>
                    <select class="form-control" name="exception_subtype" id="exception_subtype">
                      <option value="damage">Damage</option>
                      <option value="excess">Excess</option>
                      <option value="shortage">Shortage</option>
                    </select>
                    </div>
                    <div class="col-md-8">
                      <label>Exception Remarks</label>
                      <input type="text" class="form-control" name="exception_remarks" id="exception_remarks" placeholder="Exception Remarks">
                    </div>
                    <input type="hidden" name="action" id="action" value="joborder_raise_exception"/>
                    
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="raiseException();">Raise Exception</button>
                </div>
              </form>
          </div>
      </div>
  </div>
  <!--/ Raise Exception Div -->
  <!--Close Exception Div -->
  <div class="modal fade" id="closeexception_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
          <div class="modal-content">
              <form  id="close_exception_form" name="close_exception_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
                <input type="hidden" name="ju_id" id="ju_id" value="<?php echo $out['ju_id']; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Exception Details</h4>
                </div>
                <div class="modal-body">
                  <div class="col-md-8">
                      <label>Exception Closing Remarks</label>
                      <input type="text" class="form-control" name="exception_closingremarks" id="exception_closingremarks" placeholder="Exception Closing Remarks">
                    </div>
                    <input type="hidden" name="action" id="action" value="joborder_close_exception"/>                   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="closException(<?php echo $out['exception_id']; ?>);">Close Exception</button>
                </div>
              </form>
          </div>
      </div>
  </div>
  <!--/ Modal Div -->


  <?php
    include('../footer_imports.php');
  ?>
  <script type="text/javascript" src="<?php echo HOMEURL; ?>/job-order/js/job-order-unloading.js"></script>
  <script type="text/javascript">

    $(document).ready(function(){
      $('#igp-unloading-form').validate({
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
