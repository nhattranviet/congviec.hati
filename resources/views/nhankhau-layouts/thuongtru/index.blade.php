    @extends('layouts.masterPage')

    @section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            
        })
    </script>
    @endsection

    @section('css')
    <link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <style type="text/css">
        .button-list a{
            margin: 0px 0px;
            padding: 0.35em;
        }

        .button-list a i {
            font-size: 1.15em;
        }
    </style>
    @endsection

    @section('content')
    <div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Quản lý hộ khẩu</h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="max-width: 600px; margin: auto;">
                    <a href="{{ route('nhan-khau.create') }}" style="margin: 0 5px 0 5px;" class="btn btn-warning-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-accounts-add m-r-5"></i> <span>Thêm mới hồ sơ</span> </a>
                    <a href="{{ URL::to('bao-cao-nhan-khau') }}" style="margin: 0 5px 0 5px;" class="btn btn-warning-outline waves-effect waves-light"> <i style="font-size: 18px;" class="fa fa-file-word-o m-r-5"></i> <span>Lọc hồ sơ</span> </a>
                    <a href="{{ route('thong-ke') }}" style="margin: 0 5px 0 5px;" class="btn btn-warning-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-window-restore m-r-5"></i> <span>Báo cáo nhân khẩu</span> </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                <div class="alert alert-danger" id="error-msg" style="display: none">
                </div>
                <div class="alert alert-success" id="success-msg" style="display: none">
                </div>
                </div>
            </div>

            <div class="row m-t-10">
                <div class="col-xs-12">
                    <div class="card-box table-responsive">
                        <form id="tim-kiem-hoso" action="{{ URL::to('nhan-khau') }}" method="GET" role="form" idresult="nhankhautable">
                            @csrf
                            <div class="col-xs-12 col-sm-12">
                                <div class="input-group m-b-30">
                                <input name="keyword" type="text" class="form-control" placeholder="Nhập mã hồ sơ số, hộ khẩu số hoặc họ tên chủ hộ">
                                <div class="input-group-append">
                                    <button id="submitBtn" class="btn btn-default" type="submit"> <i class="fa fa-search"></i> Tìm kiếm</button>
                                </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 loading" id="nhankhautable" style="position: relative;">
                                @include('nhankhau-layouts.ajax_component.nhankhautable')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
    </div>
    @endsection

    @section('js')
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable({
                "paging":   false,
                "ordering": false,
                "info": false,
                "searching": true,
            });
        });
    </script>
    @endsection