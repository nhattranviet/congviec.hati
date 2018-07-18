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
         <!-- end row -->

         <div class="row m-b-10">
            <div class="col-xs-12" style="max-width: 800px; margin: auto;">
                <a href="{{ route('tam-tru.create') }}" style="margin: 0 5px 0 5px;" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-accounts-add m-r-5"></i> <span>Thêm sổ (Hộ) </span> </a>
                <a href="{{ route('get-add-so-tam-tru-ca-nhan') }}" style="margin: 0 5px 0 5px;" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-account-add m-r-5"></i> <span>Thêm sổ (Cá nhân)</span> </a>
                <a href="{{ route('thong-ke') }}" style="margin: 0 5px 0 5px;" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-window-restore m-r-5"></i> <span>Báo cáo nhân khẩu</span> </a>
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
                   <form id="tim-kiem-hoso" action="{{ route('cong-viec.index') }}" method="GET" role="form" idresult="ajax_table">
                   
                        <div class="row">
                            @csrf
                            <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2 col-xl-2">
                                <fieldset class="form-group">
                                    <label for="sotailieu">Số/Ký hiệu</label>
                                    <input type="text" name="sotailieu" parsley-trigger="change" placeholder="Nhập Số/Ký hiệu để lọc" class="form-control" id="sotailieu" value="">
                                </fieldset>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                <fieldset class="form-group">
                                    <label for="Trích yếu">Trích yếu</label>
                                    <input type="text" name="trichyeu" parsley-trigger="change" placeholder="Nhập trích yếu để lọc" class="form-control" id="Trích yếu" value="">
                                </fieldset>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                <fieldset class="form-group">
                                    <label for="Trích yếu">Ngày tạo: Từ ngày</label>
                                    <input type="text" name="ngaytao_tungay" parsley-trigger="change" placeholder="Nhập từ ngày để lọc" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                </fieldset>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                <fieldset class="form-group">
                                    <label for="Trích yếu">Ngày tạo: Đến ngày</label>
                                    <input type="text" name="ngaytao_denngay" parsley-trigger="change" placeholder="Nhập đến ngày để lọc" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                </fieldset>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                <fieldset class="form-group">
                                    <label>Trạng thái</label>
                                    <select id="idstatus" name="idstatus" class="form-control app_select2">
                                        <option value="">Tất cả</option>
                                        <option value="1">Đang xử lý</option>
                                        <option value="2">Hoàn thành</option>
                                        {{-- @foreach($list_donvi as $donvi)
                                        <option value="{{ $donvi->id }}">{{ $donvi->name }} ({{ $donvi->kyhieu }})</option>
                                        @endforeach --}}
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1">
                                <button style="margin-top: 2em;" id="submitBtn" class="btn btn-danger" type="submit"> <i class="fa fa-search"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 loading" id="ajax_table" style="position: relative;">
                                @include('congviec.congviec_table')
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