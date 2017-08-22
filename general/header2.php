<?php
  //session_start();
  include('dbconfig.php');

  //if(!$_SESSION['login']){
    //echo "<script>window.location.href=\"".HOMEURL."/login.php\"</script>";
  
  //}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bonded Warehouse</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/plugins/datepicker/datepicker.css">
  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/plugins/datepicker/bootstrap-datepicker.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/plugins/datatables/dataTables.bootstrap.css">

  <link rel="stylesheet" href="<?php echo LIBRARYURL; ?>/plugins/jQueryUI/jquery-ui.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .my-error-class {
      color:#FF0000;  /* red */
    }
  </style>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"> </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b> Bonded Warehouse </b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-x"></i>
              </a>
              <!-- dropdown user-->
              <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i>Welcome <?php //echo ucfirst($_SESSION['loginname']); ?></a>
                </li>
                <!--li><a href="#"><i class="fa fa-gear fa-fw"></i>Settings</a>
                </li-->
                <li class="divider"></li>
                <li><a href="<?php echo HOMEURL; ?>logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                </li>
              </ul>
              <!-- end dropdown-user -->
          </li>
          <!-- settings  -->
            <!-- <a href="<?php //echo LIBRARYURL; ?>/modules/settings.php" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
