@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/nhatkycongtac.js') }}"></script>
    <script type="text/javascript">
    var modal = $('#nhatkycanbo-modal');
      $(document).ready(function(){
          
        $(document).on("click", ".editNhatkyCB", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var idnhatky = $(this).attr('nhatky_id');
                var ngay = $("tr[tr_id="+idnhatky+"] td.ngay").text();
                CKEDITOR.instances.noidungdukien.setData( $("tr[tr_id="+idnhatky+"] td.noidung").html() );
                CKEDITOR.instances.ketquathuchien.setData( $("tr[tr_id="+idnhatky+"] td.ketqua").html() );
                $("#ngay").val(ngay);
                $('h4.modal-title').text('Sửa nhật ký cán bộ');
                $("#idnhatky_hidden").val(idnhatky);
                $("#wait").css("display", "none");
                modal.modal('show');

            });

            $("#submitBtnUpdateCB").on("click", function (event) {
                event.preventDefault();
                $("#wait").css("display", "block");
                var current_form = $(this).parents("form");
                var idnhatky = $("#idnhatky_hidden").val()
                var data_send = {idnhatky:idnhatky, noidungdukien: CKEDITOR.instances.noidungdukien.getData(), ketquathuchien: CKEDITOR.instances.ketquathuchien.getData()};
                $.ajax({
                    url: current_form.attr("action"),
                    type: "GET",
                    data: data_send,
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    dataType: "json",
                    success: function (data) {
                        $("#wait").css("display", "none");
                        $("#error-msg").css("display", "none");
                        
                        if ($.isEmptyObject(data.error)) {
                            $("tr[tr_id="+idnhatky+"] td.noidung").html(data_send.noidungdukien);
                            $("tr[tr_id="+idnhatky+"] td.ketqua").html(data_send.ketquathuchien);
                            modal.modal('hide');
                            Command: toastr["success"](data.success);
                        } else {
                            printMsg("#error-msg", data.error[0]);
                        }
                        
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
                    <h4 class="page-title">{{ $page_name }}</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a style="margin-bottom: 5px;" href="#demo" class="btn btn-link" data-toggle="collapse"><i style="font-size: 30px;" class="ion-gear-b"></i></a>
                <a href="{{ route('nhat-ky-cong-tac-cb.create') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Thêm công việc"> <i class="ion-plus"> </i> Thêm nhật ký</a>
                <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                        <form id="tim-kiem-hoso" action="{{ route('nhat-ky-cong-tac-cb.index') }}" method="GET" role="form" idresult="ajax_table" autocomplete="off">
                            <div class="row">
                                @csrf
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Từ ngày</label>
                                        <input type="text" name="tungay" parsley-trigger="change" placeholder="Nhập từ ngày để lọc" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Đến ngày</label>
                                        <input type="text" name="denngay" parsley-trigger="change" placeholder="Nhập đến ngày để lọc" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Nội dung dự kiến</label>
                                        <input type="text" name="noidungdukien" parsley-trigger="change" placeholder="Nhập nội dung dự kiến để lọc" class="form-control" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Kết quả thực hiện</label>
                                        <input type="text" name="ketquathuchien" parsley-trigger="change" placeholder="Nhập kết quả thực hiện để lọc" class="form-control" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label>Lọc theo trạng thái</label>
                                        <select id="nhatky_status" name="nhatky_status" class="form-control app_select2">
                                            <option value="">Tất cả</option>
                                            <option value="1">Đang xử lý</option>
                                            <option value="2">Hoàn thành</option>
                                        </select>
                                    </fieldset>
                                </div>
                                
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2" style="margin-top: 2em;">
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Lọc theo yêu cầu"> <i style="font-size: 1.2em;" class="fa fa-filter"></i></button>
                                    <button class="btn btn-warning waves-effect exportNhatkyBtn" redirect_type="thongke_nhatkycanbo" ajax_action="{{ route('nhat-ky-cong-tac.report-gate-check') }}" href="#" data-toggle="tooltip" data-placement="top" title="Thống kê nhật ký cán bộ"> <i style="font-size: 1.2em;" class="fa fa-area-chart"></i> </button>
                                    <button class="btn btn-info waves-effect exportNhatkyBtn" redirect_type="report_nhatkycanbo" ajax_action="{{ route('nhat-ky-cong-tac.report-gate-check') }}" href="#" data-toggle="tooltip" data-placement="top" title="Trích xuất nhật ký"> <i style="font-size: 1.2em;" class="fa fa-file-word-o"></i> </button>
                                </div>
                            </div>
                        </form>
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
                        <div class="col-xs-12 col-sm-12 loading" id="ajax_table" style="position: relative;">
                            @include('nhatkycongtac.nhatkycanbo_table')
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>
      <!-- container -->
   </div>
   <!-- content -->
</div>

<form id="" action="{{ route('ajaxUpdateNhatkyCB') }}" method="POST" role="form" autocomplete="off">
    @csrf
    <div class="modal fade" id="nhatkycanbo-modal" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Nhật ký cán bộ</h4>
                </div>
                <div class="modal-body p-20">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="datepicker">Ngày dự kiến<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input disabled="disabled" type="text" id="ngay" name="ngay" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                    </div><!-- input-group -->
                            </fieldset>
                        </div>
                        
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="exampleTextarea">Nội dung dự kiến</label>
                                <textarea id="noidungdukien" class="form-control ckeditor" name="noidungdukien"></textarea>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label for="exampleTextarea">Kết quả thực hiện</label>
                                <textarea id="ketquathuchien" class="form-control ckeditor" name="ketquathuchien"></textarea>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idnhatky" id="idnhatky_hidden" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" id="submitBtnUpdateCB" class="btn btn-primary">Lưu lại</button>
                    {{-- <button type="button" id="saveChange" class="btn btn-primary" data-dismiss="modal">Lưu lại</button> --}}
                </div>
            </div>
        </div>
    </div>
</form>
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