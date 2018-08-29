@extends('layouts.masterPage')

@section('js')
   <script type="text/javascript">
      $(document).ready(function(){
        $(document).on("click", "#checkAll", function(){
            $('.nhatky').prop('checked', this.checked);
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
                <a style="margin-bottom: 5px;" href="#demo" class="btn btn-link" data-toggle="collapse"><i style="font-size: 30px;" class="ion-gear-b"></i></a>
                <a href="{{ route('nhat-ky-cong-tac-cb.create') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Thêm công việc"> <i class="ion-plus"> </i> Thêm công việc</a>
                <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                        <form id="tim-kiem-hoso" action="{{ route('nhat-ky-cong-tac-cb.index') }}" method="GET" role="form" idresult="ajax_table">
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

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Nội dung dự kiến</label>
                                        <input type="text" name="noidungdukien" parsley-trigger="change" placeholder="Nhập Nội dung dự kiến để lọc" class="form-control" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Kết quả thực hiện</label>
                                        <input type="text" name="ketquathuchien" parsley-trigger="change" placeholder="Nhập Nội dung dự kiến để lọc" class="form-control" value="">
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

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1" style="margin-top: 2em;">
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Lọc nhật ký cán bộ"> <i class="fa fa-search"></i> Tìm</button>
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