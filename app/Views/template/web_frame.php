<?php $session = session();
$uri = service('uri');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo $title; ?> </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/dist/css/adminlte.min.css">
    <!-- JQuery -->
    <!-- Toastr modals -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- DataTables -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/r-2.2.9/sc-2.0.5/sb-1.3.0/sp-1.4.0/datatables.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/fc-4.0.1/r-2.2.9/sc-2.0.5/sp-1.4.0/datatables.min.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/fc-4.0.1/r-2.2.9/sc-2.0.5/sp-1.4.0/datatables.min.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/sc-2.0.5/datatables.min.css" /> -->

    <!-- <link rel="stylesheet" href="<?= base_url(); ?>/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <!-- <ul class="navbar-nav ml-auto"> -->
            <!-- Navbar Search -->

            <!-- Profile Icon -->
            <!-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        <i class="right fas fa-angle-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> -->
            <!-- <div class="dropdown-divider"></div> -->
            <!-- <a href="#" class="dropdown-item dropdown-footer">Log Out</a>

                    </div>
                </li> -->
            <!-- Notifications Dropdown Menu -->

            <!-- </ul> -->

            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <?php if ($session->masuk == FALSE) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() . '/Auth'; ?>"> Login </a>
                    </li>
                <?php } elseif ($session->masuk == TRUE) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() . '/Auth/logout'; ?>"> Logout </a>
                    </li>
                <?php } ?>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?= base_url(); ?>" class="brand-link" style="text-align:center;">
                <!-- <img src="dist/img/logo.png" alt="ClustInv" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <img src="<?= base_url(); ?>/dist/img/logo.png" alt="ClustInv">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="pb-1 d-flex">

                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>" class="nav-link <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">

                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Home
                                </p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() . "/Manage_data/"; ?>" class="nav-link <?= ($uri->getSegment(1) == 'Manage_data' ?
                                                                                                'active' : null);
                                                                                            ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Insert Data
                                </p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() . "/Rekap_data/"; ?>" class="nav-link <?= ($uri->getSegment(1) == 'Rekap_data' ?
                                                                                                'active' : null);
                                                                                            ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Rekapitulasi
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-lg">
                            <h1 class="m-0"><?= $heading; ?></h1>
                        </div>
                        <!-- <div class="col-sm-6"> -->

                        <!-- </div> -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- /.col-md-6 -->
                        <div class="col-lg">


                            <?= $this->renderSection('content') ?>


                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/public/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="<?php echo base_url(); ?>/public/dist/js/adminlte.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/r-2.2.9/sc-2.0.5/sb-1.3.0/sp-1.4.0/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/fc-4.0.1/r-2.2.9/sc-2.0.5/sp-1.4.0/datatables.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/fc-4.0.1/r-2.2.9/sc-2.0.5/sp-1.4.0/datatables.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/sc-2.0.5/datatables.min.js"></script> -->
    <script src="<?php echo base_url(); ?>/public/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="<?php echo base_url(); ?>/public/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>/public/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo base_url(); ?>/public/dist/js/pages/dashboard3.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url(); ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jquery -->
    <script>
        $(function() {
            // $('#resp_table').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            // });
            $(document).ready(function() {
                $('#resp_table').DataTable({
                        "scrollY": "100vh",
                        "scrollCollapse": true,

                        "paging": true,
                        // "paging": false,

                        // "scrollX": true,

                        "lengthMenu": [
                            [25, 50, 100, -1],
                            [25, 50, 100, "All"]
                        ],

                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    }),
                    $('#resp_table1').DataTable({
                        "scrollY": "100vh",
                        "scrollCollapse": true,

                        "paging": true,
                        // "paging": false,

                        // "scrollX": true,
                        "lengthMenu": [
                            [25, 50, 100, -1],
                            [25, 50, 100, "All"]
                        ],


                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    }),
                    $('#resp_table2').DataTable({
                        "scrollY": "100vh",
                        "scrollCollapse": true,

                        "paging": true,
                        // "paging": false,

                        // "scrollX": true,
                        "lengthMenu": [
                            [25, 50, 100, -1],
                            [25, 50, 100, "All"]
                        ],


                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    }),
                    $('#resp_table3').DataTable({
                        "scrollY": "100vh",
                        "scrollCollapse": true,

                        "paging": true,
                        // "paging": false,


                        // "scrollX": true,
                        "lengthMenu": [
                            [25, 50, 100, -1],
                            [25, 50, 100, "All"]
                        ],


                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    })
            });
            // $(document).ready(function() {
            //     $(".login-form").submit(function(e) {
            //         e.preventDefault(); // don't submit multiple times
            //         this.submit();
            //         toastr.success('Login berhasil.')
            //     });
            // })

            // $('#datepicker1').daterangepicker();
            // $('#datepicker2').daterangepicker();

        });

        // $(document).ready(function() {
        //     bsCustomFileInput.init();
        // });


        // $('#my-card').CardWidget(options)
    </script>
</body>

</html>