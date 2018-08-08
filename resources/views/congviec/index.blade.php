@extends('layouts.masterPage')

@section('js')
   <script type="text/javascript">
      $(document).ready(function(){
        @if(Session::get('showQuahanModal') == TRUE && count( $list_congviec_quahan ) > 0)
            $('#congviecquahan_modal').modal('show');
        @endif

        $("#destroySessionCheckModal").on("click", function (event) {
                event.preventDefault();
                $.get("{{ route('forgetSessionCheckModal') }}")
                $('#congviecquahan_modal').modal('hide');
                // alert('tsb');
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
                <a href="{{ route('get-create-cong-viec') }}" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Thêm công việc"> <i class="ion-plus"> </i> Thêm công việc</a>
                <div id="demo" class="collapse" style="background-color:#ffffff; margin-bottom: 10px; padding: 1.5em;">
                        <form id="tim-kiem-hoso" action="{{ route('cong-viec.index') }}" method="GET" role="form" idresult="ajax_table">
                            <div class="row">
                                @csrf
                                

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Ngày tạo: Từ ngày</label>
                                        <input type="text" name="ngaytao_tungay" parsley-trigger="change" placeholder="Nhập từ ngày để lọc" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                    <fieldset class="form-group">
                                        <label for="Trích yếu">Ngày tạo: Đến ngày</label>
                                        <input type="text" name="ngaytao_denngay" parsley-trigger="change" placeholder="Nhập đến ngày để lọc" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                    <fieldset class="form-group">
                                        <label>Lọc theo trạng thái</label>
                                        <select id="idstatus" name="idstatus" class="form-control app_select2">
                                            <option value="">Tất cả</option>
                                            <option value="1">Đang xử lý</option>
                                            <option value="2">Hoàn thành</option>
                                            <option value="3">Quá hạn</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                    <fieldset class="form-group" >
                                        <label>Lọc công việc theo đội<span class="text-danger">*</span></label>
                                        <select name="id_iddonvi_iddoi" id="iddoicongtac" class="form-control select2">
                                            <option value="">Tất cả</option>
                                            @foreach($list_doicongtac as $doicongtac)
                                                <option value="{{ $doicongtac->id }}">{{ $doicongtac->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2 col-xl-6">
                                    <fieldset class="form-group">
                                        <label for="sotailieu">Số/Ký hiệu công việc</label>
                                        <input type="text" name="sotailieu" parsley-trigger="change" placeholder="Nhập Số/Ký hiệu công việc để lọc" class="form-control" id="sotailieu" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2 col-xl-6">
                                    <fieldset class="form-group">
                                        <label for="trichyeu">Trích yếu</label>
                                        <input type="text" name="trichyeu" parsley-trigger="change" placeholder="Nhập Số/Ký hiệu hoặc trích yếu để lọc" class="form-control" id="trichyeu" value="">
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1" style="margin-top: 5px;">
                                    <button id="submitBtn" class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Tìm kiếm công việc"> <i class="fa fa-search"></i> Tìm</button>
                                    
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
                            @include('congviec.congviec_table')
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
<div class="modal fade" id="congviecquahan_modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('forgetSessionCheckModal') }}" method="GET" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Công việc quá hạn</h4>
                </div>
                <div class="modal-body p-20">
                    <div class="row">
                        <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 200px;">Số/ký hiệu</th>
                                    <th>Trích yếu</th>
                                    <th>Hạn công việc</th>
                                    <th style="width: 50px;">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_congviec_quahan as $congviec_quahan)
                                    <tr class="text-danger">
                                        <td>{{ $congviec_quahan->sotailieu }}</td>
                                        <td>{{ $congviec_quahan->trichyeu }}</td>
                                        <td>{{ ($congviec_quahan->hancongviec) ? date('d-m-Y', strtotime($congviec_quahan->hancongviec)) : NULL }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('get-show-cong-viec', $congviec_quahan->idcongviec) }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Xem chi tiết công việc"> <i style="color: #387576; font-size: 1.5em" class="zmdi zmdi-eye"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="destroySessionCheckModal" type="button" class="btn btn-danger">Đóng</button>
                </div>
            </form>
        </div>
    </div>
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