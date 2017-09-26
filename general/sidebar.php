

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="treeview">
          <a href="<?php echo HOMEURL; ?>/dashboard/dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-sitemap"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo HOMEURL; ?>/master/type-master.php"><i class="fa fa-circle-o"></i> Product Type Master</a>
            </li>
            <li>
              <a href="<?php echo HOMEURL; ?>/master/unit-master.php"><i class="fa fa-circle-o"></i> Unit Master</a>
            </li>
            <li>
              <a href="<?php echo HOMEURL; ?>/master/item-master.php"><i class="fa fa-circle-o"></i> Item Master</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Party Master
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo HOMEURL; ?>/master/party-master-create.php"><i class="fa fa-plus"></i> Create</a></li>
                <li><a href="<?php echo HOMEURL; ?>/master/party-master-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
            <!-- <li>
              <a href="#"><i class="fa fa-circle-o"></i> Employee Master</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Role Master</a>
            </li> -->
            <li>
              <a href="<?php echo HOMEURL; ?>/master/tariff-master.php"><i class="fa fa-circle-o"></i> Tarrif Master</a>
            </li>
            <li>
              <a href="<?php echo HOMEURL; ?>/master/discount-master.php"><i class="fa fa-circle-o"></i> Discount Master</a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>PAR</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>/par/par-create.php"><i class="fa fa-plus"></i> Create</a></li>
            <!-- <li><a href="<?php echo HOMEURL; ?>/par/par-view.php"><i class="fa fa-file"></i> View</a></li>
            </li>
            <li><a href="<?php echo HOMEURL; ?>/par/par-approve-reject-view.php"><i class="fa fa-circle-o"></i> Approve/Reject</a></li> -->
            <li><a href="<?php echo HOMEURL; ?>/par/par-approve-reject-view.php"><i class="fa fa-file"></i> View</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Document Verification</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>/dv/dv-in-view.php"><i class="fa fa-circle-o"></i> Inward</a></li>
            <li><a href="<?php echo HOMEURL; ?>/dv/dv-out-view.php"><i class="fa fa-circle-o"></i> Outward</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Gatepass Inward</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> IGP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/igp-unloading-create.php"><i class="fa fa-plus"></i> Create</a></li>
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/igp-unloading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> OGP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/ogp-unloading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i> <span>Job Order</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Unloading
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/job-order/job-order-unloading-create.php"><i class="fa fa-plus"></i> Create</a></li>
                <li><a href="<?php echo HOMEURL; ?>/job-order/job-order-unloading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Loading
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/job-order/job-order-loading-create.php"><i class="fa fa-plus"></i> Create</a></li>
                <li><a href="<?php echo HOMEURL; ?>/job-order/job-order-loading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-support"></i> <span>GRN</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>/grn/grn-create.php"><i class="fa fa-plus"></i> Create</a></li>
            <li><a href="<?php echo HOMEURL; ?>/grn/grn-list-view.php"><i class="fa fa-file"></i> View</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>PDR</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>/pdr/pdr-create.php"><i class="fa fa-plus"></i> Create</a></li>
            <!-- <li><a href="<?php //echo HOMEURL; ?>/pdr/pdr-list-view.php"><i class="fa fa-file"></i> View</a></li> -->
            <!-- <li><a href="<?php //echo HOMEURL; ?>/pdr/pdr-approve-reject-view.php"><i class="fa fa-circle-o"></i> Approve/Reject</a></li> -->
            <li><a href="<?php echo HOMEURL; ?>/pdr/pdr-approve-reject-view.php"><i class="fa fa-file"></i> View</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="<?php echo HOMEURL; ?>/gdn/gdn-list-view.php">
            <i class="fa fa-support"></i> <span>GDN</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Gatepass Outward</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> IGP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/igp-loading-create.php"><i class="fa fa-plus"></i> Create</a></li>
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/igp-loading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> OGP
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <li><a href="<?php echo HOMEURL; ?>/gate-pass/ogp-loading-list-view.php"><i class="fa fa-file"></i> View</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- ===============================================  