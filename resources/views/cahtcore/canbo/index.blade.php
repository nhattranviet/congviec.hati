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
    .center{
        text-align: center;
    }

    .button-list a {
        margin: 0px 0px;
        padding: 0;
    }
</style>
@endsection

@section('content')
<div class="content-page">
<!-- Start content -->
<div class="content">
    <div class="container">
        <!-- end row -->

        <div class="row">
            <div class="col-xs-12">
            <div class="alert alert-danger" id="error-msg" style="display: none">
            </div>
            <div class="alert alert-success" id="success-msg" style="display: none">
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="card-box table-responsive">
                <form id="tim-kiem-hoso" action="{{ route('can-bo.index') }}" method="GET" role="form" idresult="ajax_table">
                    <div class="row">
                        @csrf
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                            <fieldset class="form-group">
                                <label for="hoten">Họ tên</label>
                                <input type="text" name="hoten" parsley-trigger="change" placeholder="Nhập họ tên để tìm kiếm" class="form-control" id="hoten" value="">
                            </fieldset>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                            <fieldset class="form-group">
                                <label for="hoten">Email</label>
                                <input type="text" name="email" parsley-trigger="change" placeholder="Nhập email để tìm kiếm" class="form-control" id="email" value="">
                            </fieldset>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                            <fieldset class="form-group">
                                <label>Đơn vị</label>
                                <select id="donvi" name="iddonvi" class="form-control select2">
                                    <option value="all">Tất cả</option>
                                    @foreach($list_donvi as $donvi)
                                    <option value="{{ $donvi->id }}">{{ $donvi->name }} ({{ $donvi->kyhieu }})</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                            <fieldset class="form-group">
                                <label>Đội công tác</label>
                                <select name="iddonvi" class="form-control select2 doicongtac">
                                    <option value="all">Tất cả</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1">
                            <button style="margin-top: 2em;" id="submitBtn" class="btn btn-default" type="submit"> <i class="fa fa-search"></i></button>
                        </div>

                        <div class="col-xs-12 col-sm-12 loading" id="ajax_table" style="position: relative;">
                            @include('cahtcore.canbo.canbo_table')
                        </div>
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