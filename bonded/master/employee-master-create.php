
  <?php
    include('../header.php');
    include('../sidebar.php');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee Master - Create
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form  id="addemployee_form" name="addemployee_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Create Employee</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <div class="row margin_bottom_40">
                  <div class="col-lg-6">
                      <label class="control-label">Employee name</label>
                      <input type="text" class="form-control required" name="employee_name" id="employee_name" placeholder="Employee Name" />
                  </div>
                  <div class="col-lg-6">
                      <label class="control-label">Employee ID</label>
                      <input type="text" class="form-control required" name="employee_id" id="employee_id" placeholder="Employee ID" />
                  </div>
                </div><div class="clearfix"></div>
                <div class="row margin_bottom_40">
                  <div class="col-lg-6">
                      <label class="control-label">Login ID</label>
                      <input type="text" class="form-control required" name="loginid" id="loginid" placeholder="Username for login" />
                  </div>
                  <div class="col-lg-6">
                      <label class="control-label">Password</label>
                      <input type="password" class="form-control required" name="password" id="password" placeholder="Password" />
                  </div>
                </div><div class="clearfix"></div>
                <div class="row margin_bottom_40">
                  <div class="col-lg-6">
                      <label class="control-label">Employee Role</label>
                      <select class="form-control required" name="role_name" id="role_name">
                        <option>MASTER</option>
                        <option>PAR</option>
                      </select>
                  </div>
                  <div class="col-lg-6">
                  </div>
                </div><div class="clearfix"></div>
                <input type="hidden" name="action" id="action" value="add_employee"/>
              </div>
            </div>
            <div class="modal-footer">
              <div class="col-lg-6">
                  <button type="button" class="btn btn-primary" onclick="add_employee_details();">Add Employee</button>
              </div>
              <div class="col-lg-6 text-left">
                  <button type="button" class="btn btn-warning" onclick="window.location='employee-master-view.php';">View Employees</button>
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
    include('../footer.php');
  ?>
