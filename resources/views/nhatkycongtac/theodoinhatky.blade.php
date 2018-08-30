@extends('layouts.masterPage')

@section('js')
<script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".checkAllCls", function () {
            var current = $(this).attr("current");
            $('.nhatky_' + current).prop('checked', this.checked);
        });

        $(document).on("click", "#multiDuyet", function (event) {
            event.preventDefault();
            $("#wait").css("display", "block");
            var current_form = $(this).parents("form");
            var idresult = current_form.attr("idresult");
            console.log(current_form.serialize());
            $.ajax({
                url: "{{ route('nhat-ky-cong-tac.multi-Duyet-Nhat-ky') }}",
                type: "POST",
                data: current_form.serialize(),
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                dataType: "json",
                success: function (data) {
                    $("#wait").css("display", "none");
                    $("#error-msg").css("display", "none");

                    if ($.isEmptyObject(data.error)) {
                        if (idresult) {
                            $("#" + idresult).html(data.html);
                        }

                        if (data.url) {
                            window.location.href = data.url;
                        }
                    } else {
                        printMsg("#error-msg", data.error[0]);
                    }
                    window.scrollTo(0, 0);
                },
                error: function (data) {
                    $("#wait").css("display", "none");
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        console.log(data.responseText);
                    });
                }
            });
        });

        $('.datatable').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
        });
    })
</script>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

<style type="text/css">
    .button-list a {
        margin: 0px 0px;
        padding: 0.35em;
    }

    .button-list a i {
        font-size: 1.15em;
    }

    .panel-group {
        margin-bottom: 20px;
    }

    .panel-group .panel {
        margin-bottom: 0;
        border-radius: 4px;
    }

    .panel-default {
        border-color: #ddd;
    }

    .panel {
        background-color: #fff;
        border: 1px solid transparent;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }

    .panel-default>.panel-heading {
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
    }

    .panel-heading {
        padding: 10px 15px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

    .panel-body {
        padding: 10px;
    }

    .panel-title a {
        font-size: 16px;
        color: crimson !important;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <form id="tim-kiem-hoso" action="{{ route('nhat-ky-cong-tac-doi.theodoinhatky') }}" method="GET" role="form" idresult="html_return">
                <div class="row">
                    <div class="col-xs-12">
                        <a style="margin-bottom: 5px;" href="#demo" class="btn btn-link" data-toggle="collapse"><i style="font-size: 30px;" class="ion-gear-b"></i></a>
                        <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                            <div class="row">
                                @csrf
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Từ ngày</label>
                                        <input type="text" name="tungay" parsley-trigger="change" placeholder="Nhập từ ngày để lọc" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($tungay) ) }}">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Đến ngày</label>
                                        <input type="text" name="denngay" parsley-trigger="change" placeholder="Nhập đến ngày để lọc"
                                            class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($denngay) ) }}">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                    <fieldset class="form-group">
                                        <label>Lọc theo đội</label>
                                        <select id="id_iddonvi_iddoi" name="id_iddonvi_iddoi" class="form-control app_select2">
                                            @foreach ($list_doicongtac as $doicongtac)
                                            <option value="{{ $doicongtac->id }}">{{ $doicongtac->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label>Lọc theo trạng thái</label>
                                        <select id="nhatky_status" name="nhatky_status" class="form-control app_select2">
                                            <option value="">Tất cả</option>
                                            <option value="1">Chưa duyệt</option>
                                            <option value="2">Đã duyệt</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1" style="margin-top: 2em;">
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Lọc nhật ký cán bộ"> <i class="fa fa-search"></i> Tìm</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-danger" id="error-msg" style="display: none"></div>
                        <div class="alert alert-success" id="success-msg" style="display: none"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" id="html_return">
                        @include('nhatkycongtac.theodoinhatky_content')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <fieldset class="form-group">
                            <select id="id_status" name="id_status" class="form-control app_select2">
                                <option value="">Lựa chọn</option>
                                <option value="1">Duyệt</option>
                                <option value="2">Hủy duyệt</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-md-2">
                        <button id="multiDuyet" type="submit" class="btn btn-danger"> <i class="fa fa-rocket"></i> Thực hiện</button>
                    </div>
                </div>
            </form>
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


@endsection