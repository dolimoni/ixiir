

@include('admin.partials.admin_header');

<style rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></style>
<style rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></style>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    .bg-gray{
        min-height: 70px;
        text-align: center;
    }
    .bg-gray h4{

        font-size: 29px !important;
        font-weight: bold;
    }
</style>
<!-- Content Wrapper. Contains page content -->


<div   class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h1 class="m-0 text-dark">Statistiques Global</h1>
                </div><!-- /.col -->
                <div class="col-sm-3 text-center">
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

    </section>
    <!-- /.content -->
</div>

@include('admin.partials.admin_footer');

<!-- /.content-wrapper -->
<footer class="main-footer ">
    <strong>Copyright &copy; 2021 <a href="https://ixiir.com">ixiir</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> {{Config::get('constants.VERSION')}}
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>









<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>





