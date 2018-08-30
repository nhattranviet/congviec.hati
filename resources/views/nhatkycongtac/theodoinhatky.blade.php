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

        $(document).on("click", "#quickDuyet", function (event) {
            event.preventDefault();
            $("#wait").css("display", "block");
            var current_form = $(this).parents("form");
            var idresult = current_form.attr("idresult");
            var page = 1;
            // $.ajax({
            //     url: current_form.attr("action") + "?page=" + page,
            //     type: "GET",
            //     data: current_form.serialize(),
            //     contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            //     dataType: "json",
            //     success: function (data) {
            //         $("#wait").css("display", "none");
            //         $("#error-msg").css("display", "none");

            //         if ($.isEmptyObject(data.error)) {
            //             if (idresult) {
            //                 $("#" + idresult).html(data.html);
            //             }

            //             if (data.url) {
            //                 window.location.href = data.url;
            //             }
            //         } else {
            //             printMsg("#error-msg", data.error[0]);
            //         }
            //         window.scrollTo(0, 0);
            //     },
            //     error: function (data) {
            //         $("#wait").css("display", "none");
            //         var errors = $.parseJSON(data.responseText);
            //         $.each(errors, function (key, value) {
            //             console.log(data.responseText);
            //         });
            //     }
            // });
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
</style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <form id="tim-kiem-hoso" action="{{ route('nhat-ky-cong-tac-cb.index') }}" method="GET" role="form"
                idresult="ajax_table">
                <div class="row">
                    <div class="col-xs-12">
                        <a style="margin-bottom: 5px;" href="#demo" class="btn btn-link" data-toggle="collapse"><i style="font-size: 30px;" class="ion-gear-b"></i></a>
                        <a href="{{ route('nhat-ky-cong-tac-cb.create') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Thêm công việc"> <i class="ion-plus"> </i> Thêm công việc</a>
                        <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                            <div class="row">
                                @csrf
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Từ ngày</label>
                                        <input type="text" name="tungay" parsley-trigger="change" placeholder="Nhập từ ngày để lọc"
                                            class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($tungay) ) }}">
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
                                        <select id="nhatky_status" name="nhatky_status" class="form-control app_select2">
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
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip"
                                        data-placement="top" title="Lọc nhật ký cán bộ"> <i class="fa fa-search"></i>
                                        Tìm</button>
                                </div>
                            </div>

                        </div>
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
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card-box table-responsive">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h5>Nhật ký công tác đội</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12 loading" id="ajax_table" style="position: relative;">
                                    <table class="table table-bordered table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th class="center"><input id="checkAll_nhatkytuan" current="nhatkytuan"
                                                        class="checkAllCls" type="checkbox"></th>
                                                <th class="center" width="70px;">STT</th>
                                                <th class="center" width="100px;">Tuần</th>
                                                <th class="center" width="450px;">Nội dung dự kiến</th>
                                                <th class="center" width="250px;">Kết quả thực hiện</th>
                                                <th class="center">Ghi chú duyệt</th>
                                                <th class="center" width="70px;">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach ($list_nhatkydoi as $nhatky)
                                            <tr>
                                                <td class="center"><input name="nhatkyngay" value="{{ $nhatky->id }}"
                                                        class="nhatky_nhatkytuan" type="checkbox"></td>
                                                <td class="center">{{ $i }}</td>
                                                <td>{{ date('d-m-Y', strtotime($nhatky->ngaydautuan)) .' -> '.
                                                    date('d-m-Y', strtotime($nhatky->ngaycuoituan)) }}</td>
                                                <td>{!! $nhatky->noidungdukien !!}</td>
                                                <td>{!! $nhatky->ketquathuchien !!}</td>
                                                <td>{!! $nhatky->ghichuduyet !!}</td>
                                                <td class="center"> {!! ($nhatky->nhatky_status == 2) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Đã duyệt"></i>' : '<i style="color:crimson" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Chưa duyệt"></i>' !!} </td>
                                            </tr>
                                            @php
                                            $i++;
                                            @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-xs-12 col-sm-12">
                                    <h5>Nhật ký công tác cán bộ</h5>
                                </div>
                                <div class="col-xs-12 col-sm-12">
                                    <div class="panel-group" id="accordion">
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach ($list_canbo_nhatky as $hoten => $canbo_nhatky)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}"> <i class="fa fa-user"></i> {{ $hoten }}</a> </h5>
                                            </div>
                                            <div id="collapse_{{ $i }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="center"><input id="checkAll_{{ $i }}" current="{{ $i }}" class="checkAllCls" type="checkbox"></th>
                                                                        <th class="center">Ngày</th>
                                                                        <th class="center">Nội dung dự kiến</th>
                                                                        <th class="center">Kết quả thực hiện</th>
                                                                        <th class="center">Ghi chú của Lãnh đạo</th>
                                                                        <th class="center" style="width: 100px;">Trạng thái</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($canbo_nhatky as $nhatky)
                                                                    <tr>
                                                                        <td class="center"><input name="nhatkyngay" value="{{ $nhatky->id }}" class="nhatky_{{ $i }}" type="checkbox"></td>
                                                                        <td>{{ date('d-m-Y', strtotime($nhatky->ngay)) }}</td>
                                                                        <td>{!! $nhatky->noidungdukien !!}</td>
                                                                        <td>{!! $nhatky->ketquathuchien !!}</td>
                                                                        <td>{!! $nhatky->ghichuduyet !!}</td>
                                                                        <td class="center"> {!! ($nhatky->nhatky_status == 2) ? '<i style="color:darkgreen" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Đã duyệt"></i>' : '<i style="color:crimson" class="zmdi zmdi-badge-check" data-toggle="tooltip" data-placement="top" title="Chưa duyệt"></i>' !!} </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <fieldset class="form-group">
                                                                <select id="nhatky_status" name="nhatky_status" class="form-control app_select2">
                                                                    <option value="">Lựa chọn</option>
                                                                    <option value="1">Duyệt</option>
                                                                    <option value="2">Hủy duyệt</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-danger"> <i class="fa fa-rocket"></i> Thực hiện</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
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