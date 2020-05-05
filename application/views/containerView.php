<?php 

$level = $this->session->userdata('level') != null ? $this->session->userdata('level') : false;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- datatable -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('public/') ?>plugins/datatable/jquery.dataTables.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url('public/') ?>dist/css/fontawesome-iconpicker.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>dist/css/skins/_all-skins.min.css">
  <!-- pace -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>plugins/pace/pace.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url('public/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


<!-- jQuery 3 -->
<script src="<?= base_url('public/') ?>bower_components/jquery/dist/jquery.min.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?= base_url('/') ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>I</b>E</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Inven</b>tory</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">0</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 0 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> contoh notifikasi
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?= base_url('public/') ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?= $this->session->userdata['fullname'] ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?= base_url('public/') ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                  <p>
                    Login sebagai <b><?= $this->session->userdata['username'] ?></b>
                    <small>Bergabung dari <?= date('M Y', strtotime($this->session->userdata['created_date'])) ?></small>
                  </p>
                </li>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= base_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url('public/') ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $this->session->userdata['username'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <?php if($level  == 'admin'){ ?>
          <li>
            <a href="<?= base_url('/admin') ?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('/admin/pengguna') ?>">
              <i class="fa fa-users"></i> <span>Pengguna</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('/admin/satuan') ?>">
              <i class="fa fa-archive"></i> <span>Satuan Barang</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('/admin/barang') ?>">
              <i class="fa fa-archive"></i> <span>Barang</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('/admin/supplier') ?>">
              <i class="fa fa-archive"></i> <span>Supplier</span>
            </a>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-list"></i>
              <span>Daftar Transaksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('/admin/transaksi/list/masuk') ?>"><i class="fa fa-circle"></i> Barang Masuk</a></li>
              <li><a href="<?= base_url('/admin/transaksi/list/keluar') ?>"><i class="fa fa-circle"></i> Barang Keluar</a></li>
            </ul>
          </li>
          <!-- ini untuk staff -->
        <?php }elseif($level == 'staff'){ ?>
         <li>
          <a href="<?= base_url('/staff') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('/staff/satuan') ?>">
            <i class="fa fa-archive"></i> <span>Satuan Barang</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('/staff/barang') ?>">
            <i class="fa fa-archive"></i> <span>Barang</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('/staff/supplier') ?>">
            <i class="fa fa-archive"></i> <span>Supplier</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dollar"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Daftar Transaksi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= base_url('/staff/transaksi/list/masuk') ?>"><i class="fa fa-circle"></i> Barang Masuk</a></li>
                <li><a href="<?= base_url('/staff/transaksi/list/keluar') ?>"><i class="fa fa-circle"></i> Barang Keluar</a></li>
              </ul>
            </li>
            <li><a href="<?= base_url('/staff/transaksi/masuk') ?>"><i class="fa fa-circle-o"></i> Barang Masuk</a></li>
            <li><a href="<?= base_url('/staff/transaksi/keluar') ?>"><i class="fa fa-circle-o"></i> Barang Keluar</a></li>
          </ul>
        </li>
      <?php }elseif($level == 'manager'){ ?>
       <li>
        <a href="<?= base_url('/manager') ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="<?= base_url('/manager/pengguna') ?>">
          <i class="fa fa-archive"></i> <span>Pengguna</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-list"></i>
          <span>Daftar Transaksi</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?= base_url('/manager/transaksi/list/masuk') ?>"><i class="fa fa-circle"></i> Barang Masuk</a></li>
          <li><a href="<?= base_url('/manager/transaksi/list/keluar') ?>"><i class="fa fa-circle"></i> Barang Keluar</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-pdf-o"></i>
          <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle"></i> Barang Masuk</a></li>
          <li><a href="#"><i class="fa fa-circle"></i> Barang Keluar</a></li>
          <li><a href="#"><i class="fa fa-circle"></i> Stock Barang</a></li>
        </ul>
      </li>
    <?php }else{ ?>
      <li>
        <a href="<?= base_url('/pages/user') ?>">
          <i class="fa fa-users"></i> <span>Users</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-sticky-note-o"></i>
          <span>Halaman</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?= base_url('/pages/header') ?>"><i class="fa fa-circle-o"></i> Header</a></li>
          <li><a href="<?= base_url('/pages/project') ?>"><i class="fa fa-circle-o"></i> Project</a></li>
          <li><a href="<?= base_url('/pages/service') ?>"><i class="fa fa-circle-o"></i> Service</a></li>
          <li><a href="<?= base_url('/pages/testimoni') ?>"><i class="fa fa-circle-o"></i> Testimoni</a></li>
        </ul>
      </li>
    <?php } ?>
  </ul>
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php $this->load->view($content) ?>
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.18
  </div>
  <strong>Copyright &copy; 2020 <a href="https://adminlte.io">Inventory</a>.</strong> All rights
  reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark" style="display: none;">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab">
      <h3 class="control-sidebar-heading">Recent Activity</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

              <p>Will be 23 on April 24th</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-user bg-yellow"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

              <p>New phone +1(800)555-1234</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

              <p>nora@example.com</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-file-code-o bg-green"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

              <p>Execution time 5 seconds</p>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

      <h3 class="control-sidebar-heading">Tasks Progress</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Custom Template Design
              <span class="label label-danger pull-right">70%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Update Resume
              <span class="label label-success pull-right">95%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-success" style="width: 95%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Laravel Integration
              <span class="label label-warning pull-right">50%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Back End Framework
              <span class="label label-primary pull-right">68%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->
    <!-- Stats tab content -->
    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
    <!-- /.tab-pane -->
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Report panel usage
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Some information about this general settings option
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Allow mail redirect
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Other sets of options are available
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Expose author name in posts
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Allow the user to show his name in blog posts
          </p>
        </div>
        <!-- /.form-group -->

        <h3 class="control-sidebar-heading">Chat Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Show me as online
            <input type="checkbox" class="pull-right" checked>
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Turn off notifications
            <input type="checkbox" class="pull-right">
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Delete chat history
            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
          </label>
        </div>
        <!-- /.form-group -->
      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('public/') ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>

  $(document).ready(function(){
    $(document).ajaxStart(function() { Pace.restart(); });

    $.widget.bridge('uibutton', $.ui.button);

    var url = window.location;
    $('ul.sidebar-menu li a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');



    $('ul.treeview-menu li a').filter(function() {

      return this.href == url;

    }).parentsUntil( $( "ul.level-1" ) ).addClass('active');

    $.ajaxSetup({

      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

      }

    });

    var title = '<?= $this->session->flashdata('title') ?>';
    var text = '<?= $this->session->flashdata('text'); ?>';
    var icon = '<?= $this->session->flashdata('icon'); ?>';

    if(title){
      swal({
        title: title,
        text: text,
        icon: icon,
      });
    }


  })

</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('public/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- icon picker -->
<script src="<?= base_url('public/') ?>dist/js/fontawesome-iconpicker.min.js"></script>
<!-- sweetalert -->
<script src="<?= base_url('public/') ?>plugins/sweetalert/sweetalert.min.js"></script>
<!-- PACE -->
<script src="<?= base_url('public/') ?>bower_components/PACE/pace.min.js"></script>
<!-- datatablse -->
<script type="text/javascript" charset="utf8" src="<?= base_url('public/') ?>plugins/datatable/datatable.js"></script>
<!-- Morris.js charts -->
<script src="<?= base_url('public/') ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url('public/') ?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url('public/') ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url('public/') ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url('public/') ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('public/') ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url('public/') ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url('public/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url('public/') ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('public/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url('public/') ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url('public/') ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('public/') ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('public/') ?>dist/js/demo.js"></script>
</body>
</html>
