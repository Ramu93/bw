<?php
  include('../header.php');
  include('../sidebar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Party Master - Add
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form action="#" onsubmit="return false;" name="add_party_form" class="form" id="add_party_form" method="POST">
            <div class="form-group col-lg-6 col-md-6 col-sm-6">
              <label for="im_type">Party Type </label>
                <div class="checkbox">
                <label><input type="radio" name="partytype" value="customer" checked="checked" onclick="changePartyType('customer');"> Customer</label>
              </div>
              <div class="checkbox">
                <label><input type="radio" name="partytype" value="serviceprovider" onclick="changePartyType('serviceprovider');"> Service Provider</label>
              </div>
              <div id="sp_div" class="col-lg-12 col-md-12 col-sm-12 col-md-offset-1" style="display:none;">
                <div class="checkbox">
                  <label><input type="radio" name="partytype_sp" value="chcagent" checked="checked"> Customs House Clearing Agent</label>
                </div>
                <div class="checkbox">
                  <label><input type="radio" name="partytype_sp" value="generalagent"> General Agent</label>
                </div>
              </div>
              <div class="checkbox">
                <label><input type="radio" name="partytype" value="principalclient" onclick="changePartyType('principalclient');"> Principal Client</label>
              </div>
              <div id="sp_div2" class="col-lg-8 col-md-8 col-sm-6 col-md-offset-1" style="display:none;">
                <div class="checkbox">
                  <label><input type="text" class="form-control required" id="customer_parent" name="customer_parent" placeholder="Parent Customer"></label>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6">
              <label for="pm_customerName">Customer Name </label>
              <input type="text" class="form-control required" id="pm_customerName" name="pm_customerName" placeholder="Enter the Username">
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_address">Company Constitution </label>
              <select name="constitution_type" id="constitution_type" class="form-control">
                <option value="Proprietorship">Proprietorship</option>
                <option value="Partnership">Partnership</option>
                <option value="Private Ltd">Private Ltd</option>
                <option value="Limited">Limited</option>
              </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_address">Address1 </label>
              <input type="text" class="form-control required" id="pm_address1" name="pm_address1" placeholder="Address1">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_address">Address2 </label>
              <input type="text" class="form-control required" id="pm_address2" name="pm_address2" placeholder="Address2">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_cityTown">City </label>
              <input type="text" class="form-control required" id="pm_cityTown" name="pm_cityTown" placeholder="Enter the city/town">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_state">State </label>
              <input type="text" class="form-control required" id="pm_state" name="pm_state" placeholder="Enter the state">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_pin">PIN </label>
              <input type="text" class="form-control required" id="pm_pin" name="pm_pin" placeholder="Enter the pin">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_landline">Landline </label>
              <input type="text" class="form-control" id="pm_landline" name="pm_landline" placeholder="Enter the Landline">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_fax">FAX </label>
              <input type="text" class="form-control" id="pm_fax" name="pm_fax" placeholder="Enter the Fax">
            </div>
            <div class="clearfix"></div><hr>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_primaryContact">Primary Contact (Name &amp; Designation)</label>
              <input type="text" class="form-control" id="pm_primaryContact required" name="pm_primaryContact" placeholder="Primary Contact">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_primaryContactMobile">Primary Contact Mobile</label>
              <input type="text" class="form-control" id="pm_primaryContactMobile required" name="pm_primaryContactMobile" placeholder="Primary Contact Mobile">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_primaryContactEmail">Primary Contact Email</label>
              <input type="text" class="form-control" id="pm_primaryContactEmail required email" name="pm_primaryContactEmail" placeholder="Primary Contact Email">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContact">Secondary Contact (Name &amp; Designation)</label>
              <input type="text" class="form-control" id="pm_secondaryContact" name="pm_secondaryContact" placeholder="Secondary Contact">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContactMobile">Secondary Contact Mobile</label>
              <input type="text" class="form-control" id="pm_secondaryContactMobile" name="pm_secondaryContactMobile" placeholder="Secondary Contact Mobile">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContactEmail">Secondary Contact Email</label>
              <input type="text" class="form-control" id="pm_secondaryContactEmail" name="pm_secondaryContactEmail" placeholder="Secondary Contact Email">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContact">Tertiary Contact (Name &amp; Designation)</label>
              <input type="text" class="form-control" id="pm_tertiaryContact" name="pm_tertiaryContact" placeholder="Tertiary Contact">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContactMobile">Tertiary Contact Mobile</label>
              <input type="text" class="form-control" id="pm_tertiaryContactMobile" name="pm_tertiaryContactMobile" placeholder="Tertiary Contact Mobile">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_secondaryContactEmail">Tertiary Contact Email</label>
              <input type="text" class="form-control" id="pm_tertiaryContactEmail" name="pm_tertiaryContactEmail" placeholder="Tertiary Contact Email">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_tin">TAN  </label>
              <input type="text" class="form-control" id="pm_tan" name="pm_tan" placeholder="TAN Number">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_tin">PAN  </label>
              <input type="text" class="form-control" id="pm_pan" name="pm_pan" placeholder="Enter the licence">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_sales">Sales tax/GST   </label>
              <input type="text" class="form-control" id="pm_sales" name="pm_sales" placeholder="Enter the sales tax">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_servicesTax">Service tax regn  </label>
              <input type="text" class="form-control" id="pm_servicesTax" name="pm_servicesTax" placeholder="Enter the Service tax">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_licence">IE Licence/CHA Number  </label>
              <input type="text" class="form-control" id="pm_licence" name="pm_licence" placeholder="IE Licence">
            </div>

            <!--div class="clearfix"></div-->
          
          <!-- End of Left Container -->

          <!-- Right Container -->
          
          
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_ccd">Credit Days</label>
              <input type="text" class="form-control required number" id="pm_ccd" name="pm_ccd" placeholder="Credit Days">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_ccLimit">Credit Limit</label>
              <input type="text" class="form-control required number" id="pm_ccLimit" name="pm_ccLimit" placeholder="Credit Limit">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_ccBalance">Opening Balance</label>
              <input type="text" class="form-control required" id="pm_ccBalance" name="pm_ccBalance" placeholder="Opening Balance">
            </div>
            
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label for="pm_inactive">Inactive from </label>
              <input type="text" class="form-control" id="pm_inactive" name="pm_inactive" placeholder="Inactive From">
            </div>
          
            <!-- End of Right Container -->
            <div class="clearfix"></div>
              <!--div class="col-ls-4 col-md-4 col-sm-4">
                <input type="button" class="btn btn-primary btn-block margin_bottom" value="Back" onclick="history.go(-1);">
              </div-->
            <div class="col-ls-4 col-md-4 col-sm-4">
              <input type="submit" class="btn btn-primary btn-block" value="Add Party" name="pm_submit" onclick="addParty()">
            </div>
            <div class="col-ls-4 col-md-4 col-sm-4">
              <input type="button" class="btn btn-primary btn-block" value="View Parties" onclick="window.location='party-master-view.php';">
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
      $('#add_party_form').validate({
        errorClass: "my-error-class"
      });
      $('#pm_form').validate();
      $('#pm_inactive').datepicker({dateFormat: 'yy-mm-dd'});
    });
  </script>
  <?php
    include('../footer.php');
  ?>
