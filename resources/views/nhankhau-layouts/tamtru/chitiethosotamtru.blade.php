@extends('layouts.masterPage')

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<style type="text/css">
    .button-list a{
        margin: 0px 0px;
        padding: 0.35em;
    }

    ..button-list a i{
        font-size: 22px;
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
                    <h4 class="page-title">Chi tiết sổ tạm trú</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
         <div class="row m-t-10">
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

                  <div class="col-xs-12 col-sm-12">
                     <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
                      <thead>
                        <tr>
                           <th>Hồ sơ số</th>
                           <th>Họ tên</th>
                           <th>Quan hệ</th>
                           <th>Thường trú</th>
                           <th>Tạm trú</th>
                           <th style="width: 80px;">Từ ngày</th>
                           <th style="width: 80px;">Đến ngày</th>
                           <th style="width: 80px;">Trạng thái</th>
                           <th style="width: 100px; text-align: center;">Hành động</th>
                        </tr>
                     </thead>
                      <tbody>
                        @foreach($list_thongtinsotamtru as $thongtinsotamtru)
                           <tr>
                                <td>{{ $thongtinsotamtru->sotamtru_so }}</td>
                                <td>{{ $thongtinsotamtru->hoten }}</td>
                                <td>{{ ($thongtinsotamtru->idquanhechuho) ? DB::table('tbl_moiquanhe')->where('id', $thongtinsotamtru->idquanhechuho)->value('name') : '' }}</td>
                                <td>{{ $thongtinsotamtru->chitiet_thuongtru }} - {{ ($thongtinsotamtru->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $thongtinsotamtru->idxa_thuongtru)->value('name') : '' }} - {{ ($thongtinsotamtru->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $thongtinsotamtru->idhuyen_thuongtru)->value('name') : '' }} - {{ ($thongtinsotamtru->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $thongtinsotamtru->idtinh_thuongtru)->value('name') : '' }}</td>
                                <td>{{ $thongtinsotamtru->chitiet_tamtru }} - {{ ($thongtinsotamtru->idxa_tamtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $thongtinsotamtru->idxa_tamtru)->value('name') : '' }}</td>
                                <td>{{ ($thongtinsotamtru->tamtru_tungay != NULL) ? date('d-m-Y', strtotime($thongtinsotamtru->tamtru_tungay)) : '' }}</td>
                                <td>{{ ($thongtinsotamtru->tamtru_denngay != NULL) ? date('d-m-Y', strtotime($thongtinsotamtru->tamtru_denngay)) : '' }}</td>
                                <td>{!! ($thongtinsotamtru->deleted_at != NULL) ? '<span class="label label-danger">Đã xóa</span>'  : '<span class="label label-success">Đang tạm trú</span>' !!}</td>
                                <td>
                                    <div class="button-list">
                                        <a href="/tam-tru/{{ $thongtinsotamtru->idnhankhau }}/{{ $thongtinsotamtru->idsotamtru }}/chi-tiet-nhan-khau" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết nhân khẩu"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                                        @if ($thongtinsotamtru->deleted_at == NULL)
                                            <a href="/tam-tru/{{ $thongtinsotamtru->idnhankhau }}/{{ $thongtinsotamtru->idsotamtru }}/get-xoa-tam-tru-nhan-khau" class="btn btn-primary btn-link" data-toggle="tooltip" data-placement="top" title="Xóa tạm trú nhân khẩu"> <i style="color: red;" class="fa fa-remove"></i> </a>
                                            <a href="/tam-tru/{{ $thongtinsotamtru->idnhankhau }}/{{ $thongtinsotamtru->idsotamtru }}/sua-nhan-khau" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Sửa nhân khẩu"> <i class="zmdi zmdi-edit"></i> </a>
                                            <a href="/tam-tru/{{ $thongtinsotamtru->idnhankhau }}/{{ $thongtinsotamtru->idsotamtru }}/get-gia-han-tam-tru-nhan-khau" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Gia hạn tạm trú"> <i class="zmdi zmdi-time-restore"></i> </a>
                                        @endif
                                    </div>
                                </td>
                           </tr>
                        @endforeach
                      </tbody>
                  </table>
                  <div class="clearfix"></div>
                  <span class="m-t-10">
                      <a href="{{ route('tam-tru.index') }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
                  </span>
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