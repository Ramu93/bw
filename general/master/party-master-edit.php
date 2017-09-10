<?php
  include('../header.php');
  include('../sidebar.php');

  $message ="";
  $pmId = $_GET['pm_id'];
  $select = "SELECT * FROM general_party_master WHERE pm_id = '$pmId'";
  $query = mysqli_query($dbc,$select);
  if(mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
  }
  else {
    //echo "<script type='text/javascript'>window.location.href='party-master-view.php'</script>";
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Party Master - Edit
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form action="#" name="edit_party_master" onsubmit="return false;" class="form" id="edit_party_master"> 
            <!-- Left container -->
            <input type="hidden" value="<?php echo $row['pm_uuid']; ?>" name="pm_uuid"></input>

            
            <!-- End of Right Container -->
            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                <label for="im_type">Party Type : </label>
                  <div class="checkbox">
                  <label><input type="radio" name="partytype" value="customer" checked="checked"> Customer</label>
                </div>
                <div class="checkbox">
                  <label><input type="radio" name="partytype" value="customer"> CHA</label>
                </div>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6">
                  <label for="pm_customerName">Customer Name : </label>
                  <input type="text" class="form-control required" id="pm_customerName" name="pm_customerName" placeholder="Enter the Username" value="<?php echo $row['pm_customerName']; ?>">
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_address">Company Constitution : </label>
                  <select name="constitution_type" id="constitution_type" class="form-control">
                    <option value="Proprietorship">Proprietorship</option>
                    <option value="Partnership">Partnership</option>
                    <option value="Private Ltd">Private Ltd</option>
                    <option value="Limited">Limited</option>
                  </select>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_address">Address1 : </label>
                  <input type="text" class="form-control required" id="pm_address1" name="pm_address1" placeholder="Address1" value="<?php echo $row['pm_address1']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_address">Address2 : </label>
                  <input type="text" class="form-control required" id="pm_address2" name="pm_address2" placeholder="Address2" value="<?php echo $row['pm_address2']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_cityTown">City : </label>
                  <input type="text" class="form-control required" id="pm_cityTown" name="pm_cityTown" placeholder="Enter the city/town" value="<?php echo $row['pm_cityTown']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_state">State : </label>
                  <input type="text" class="form-control required" id="pm_state" name="pm_state" placeholder="Enter the state" value="<?php echo $row['pm_state']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_pin">PIN : </label>
                  <input type="text" class="form-control required" id="pm_pin" name="pm_pin" placeholder="Enter the pin" value="<?php echo $row['pm_pin']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_landline">Landline : </label>
                  <input type="text" class="form-control" id="pm_landline" name="pm_landline" placeholder="Enter the Landline" value="<?php echo $row['pm_landline']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_fax">FAX : </label>
                  <input type="text" class="form-control" id="pm_fax" name="pm_fax" placeholder="Enter the Fax" value="<?php echo $row['pm_fax']; ?>">
                </div>
                <div class="clearfix"></div><hr>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_primaryContact">Primary Contact (Name & Designation)</label>
                  <input type="text" class="form-control required" id="pm_primaryContact" name="pm_primaryContact" placeholder="Primary Contact" value="<?php echo $row['pm_primaryContact']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_primaryContactMobile">Primary Contact Mobile</label>
                  <input type="text" class="form-control required" id="pm_primaryContactMobile" name="pm_primaryContactMobile" placeholder="Primary Contact Mobile" value="<?php echo $row['pm_primaryContactMobile']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_primaryContactEmail">Primary Contact Email</label>
                  <input type="text" class="form-control required" id="pm_primaryContactEmail" name="pm_primaryContactEmail" placeholder="Primary Contact Email" value="<?php echo $row['pm_primaryContactEmail']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContact">Secondary Contact (Name & Designation)</label>
                  <input type="text" class="form-control" id="pm_secondaryContact" name="pm_secondaryContact" placeholder="Secondary Contact" value="<?php echo $row['pm_secondaryContact']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContactMobile">Secondary Contact Mobile</label>
                  <input type="text" class="form-control" id="pm_secondaryContactMobile" name="pm_secondaryContactMobile" placeholder="Secondary Contact Mobile" value="<?php echo $row['pm_secondaryContactMobile']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContactEmail">Secondary Contact Email</label>
                  <input type="text" class="form-control" id="pm_secondaryContactEmail" name="pm_secondaryContactEmail" placeholder="Secondary Contact Email" value="<?php echo $row['pm_secondaryContactEmail']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContact">Tertiary Contact (Name & Designation)</label>
                  <input type="text" class="form-control" id="pm_tertiaryContact" name="pm_tertiaryContact" placeholder="Tertiary Contact" value="<?php echo $row['pm_tertiaryContact']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContactMobile">Tertiary Contact Mobile</label>
                  <input type="text" class="form-control" id="pm_tertiaryContactMobile" name="pm_tertiaryContactMobile" placeholder="Tertiary Contact Mobile" value="<?php echo $row['pm_tertiaryContactMobile']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_secondaryContactEmail">Tertiary Contact Email</label>
                  <input type="text" class="form-control" id="pm_tertiaryContactEmail" name="pm_tertiaryContactEmail" placeholder="Tertiary Contact Email" value="<?php echo $row['pm_tertiaryContactEmail']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_tin">TAN  </label>
                  <input type="text" class="form-control" id="pm_tan" name="pm_tan" placeholder="TAN Number" value="<?php echo $row['pm_tan']; ?>">
                </div><div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_tin">PAN  </label>
                  <input type="text" class="form-control" id="pm_pan" name="pm_pan" placeholder="Enter the PAN" value="<?php echo $row['pm_pan']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_sales">Sales tax/GST  </label>
                  <input type="text" class="form-control" id="pm_sales" name="pm_sales" placeholder="Enter the sales tax" value="<?php echo $row['pm_sales']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_servicesTax">Service tax regn  </label>
                  <input type="text" class="form-control" id="pm_servicesTax" name="pm_servicesTax" placeholder="Enter the Service tax" value="<?php echo $row['pm_servicesTax']; ?>">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_licence">IE Licence/CHA Number  </label>
                  <input type="text" class="form-control" id="pm_licence" name="pm_licence" placeholder="IE Licence" value="<?php echo $row['pm_licence']; ?>">
                </div>
                
                <!--div class="clearfix"></div-->
              
              <!-- End of Left Container -->

              <!-- Right Container -->
              
              
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_ccd">Credit Days</label>
                  <input type="text" class="form-control required number" id="pm_ccd" name="pm_ccd" placeholder="Credit Days" value="<?php echo $row['pm_ccd']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_ccLimit">Credit Limit</label>
                  <input type="text" class="form-control required number" id="pm_ccLimit" name="pm_ccLimit" placeholder="Credit Limit" value="<?php echo $row['pm_ccLimit']; ?>">
                </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_ccBalance">Opening Balance</label>
                  <input type="text" class="form-control required" id="pm_ccBalance" name="pm_ccBalance" placeholder="Opening Balance" value="<?php echo $row['pm_ccBalance']; ?>">
                </div>
                
                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                  <label for="pm_inactive">Inactive from : </label>
                  <input type="text" class="form-control" id="pm_inactive" name="pm_inactive" placeholder="Inactive From" value="<?php echo $row['pm_inactive']; ?>">
                </div>
              
            <div class="clearfix"></div>
              <div class="col-ls-4 col-md-4 col-sm-4">
                <input type="button" class="btn btn-primary btn-block margin_bottom" value="Back" onclick="history.go(-1);">
              </div>
              <div class="col-ls-4 col-md-4 col-sm-4">
                <input type="submit" class="btn btn-primary btn-block" onclick="editParty(<?php echo $pmId; ?>)" value="Save" name="pm_submit">
              </div>
              <div class="col-ls-4 col-md-4 col-sm-4">
                <input type="button" class="btn btn-primary btn-block" onclick="deleteParty(<?php echo $pmId; ?>)" value="Delete (Archive)">
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
      $('#edit_party_master').validate({
        errorClass: "my-error-class"
      });
      $('#pm_inactive').datepicker({dateFormat: 'yy-mm-dd'});

      $('#pm_cityTown').rules("add", { regex: "^[a-zA-Z ]+$" });
      $('#pm_state').rules("add", { regex: "^[a-zA-Z ]+$" });
      $('#pm_pin').rules("add", { regex: "^[0-9]{6}$" });
      $('#pm_landline').rules("add", { regex: "^[0-9]*$" });
      $('#pm_fax').rules("add", { regex: "^[0-9]*$" });
      $('#pm_primaryContactMobile').rules("add", { regex: "^[0-9]*$" });
      $('#pm_secondaryContactMobile').rules("add", { regex: "^[0-9]*$" });
      $('#pm_tertiaryContactMobile').rules("add", { regex: "^[0-9]*$" });
      $('#pm_tan').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_pan').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_sales').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_servicesTax').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_ccd').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_ccLimit').rules("add", { regex: "^[0-9a-zA-Z ]+$" });
      $('#pm_inactive').rules("add", { regex: "^[0-9]{4}[-][0-9]{2}[-][0-9]{2}$" });
    });
  </script>
  <?php
    include('../footer.php');
  ?>
