@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/nhatkycongtac.js') }}"></script>
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
                    <h4 class="page-title">{{ (isset($page_name)) ? $page_name : '' }}</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a style="margin-bottom: 5px;" href="#demo" class="btn btn-link" data-toggle="collapse"><i style="font-size: 30px;" class="ion-gear-b"></i></a>
                <a href="{{ route('lich-cong-tac.index') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Thêm công việc"> <i class="fa fa-calendar"> </i> Lịch công tác</a>
                <a href="{{ route('lich-cong-tac.create_lanhdaotructuan') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Quản lý nhật ký đội" style="margin: 0 5px;"> <i class="fa fa-user-plus"> </i> Thêm lãnh đạo trực</a>
                <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                        <form id="tim-kiem-hoso" action="{{ route('lich-cong-tac.index_lanhdaotructuan') }}" method="GET" role="form" idresult="ajax_table" autocomplete="off">
                            <div class="row">
                                @csrf

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Từ ngày</label>
                                        <input type="text" name="tungay" parsley-trigger="change" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Đến ngày</label>
                                        <input type="text" name="denngay" parsley-trigger="change" class="form-control datepicker-autoclose" placeholder="dd-mm-yyyy" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                    <fieldset class="form-group">
                                        <label for="datepicker">Lãnh đạo trực<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select name="idlanhdaotruc" class="form-control select2" style="width: 100%;">
                                                    <option value=""> Chọn lãnh đạo trực </option>
                                                    @foreach ($list_lanhdao as $lanhdao)
                                                        <option value="{{ $lanhdao->id }}"> {{ $lanhdao->hoten.' ('.$lanhdao->tenchucvu.')' }} </option>
                                                    @endforeach
                                                </select>
                                            </div><!-- input-group -->
                                    </fieldset>
                                </div>
                                
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2" style="margin-top: 2em;">
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Lọc, tìm kiếm"> <i style="font-size: 1.2em;" class="fa fa-filter"></i></button>
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
                            @include('cahtcore.lichcongtac.lanhdaotructuan_table')
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

{{-- @include('nhatkycongtac.nhatkycanbo_modal'); --}}
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