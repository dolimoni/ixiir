

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
                    <h1 class="m-0 text-dark">Hot topics</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row table-responsive">
                <table id="datatable-reparation" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Visible</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Visible</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($topics as $topic)
                        <tr >
                            <td>{{$topic->id}}</td>
                            <td>{{$topic->tag}}</td>
                            <td>{{Config::get('constants.VISIBLE')[$topic->visible]}}</td>
                            <td>{{$topic->created_at}}</td>
                            <td>
                                <button class="btn btn-danger">Supprimer</button>
                                @if(!$topic->visible)
                                    <a  href="{{route('admin.topic.show',['topicId'=>$topic->id])}}" class="btn btn-success">Montrer</a>
                                @else
                                    <a href="{{route('admin.topic.hide',['topicId'=>$topic->id])}}" class="btn btn-primary">Cacher</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </section>
    <!-- /.content -->
</div>

@include('admin.partials.admin_footer');

<!-- /.content-wrapper -->
<footer class="main-footer hidden">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.2-pre
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>









<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-reparation").length) {
                $("#datatable-reparation").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                    "language": {
                        "url": "{{asset("adminAsset/vendors/datatables.net/French.json")}}"
                    }
                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>






