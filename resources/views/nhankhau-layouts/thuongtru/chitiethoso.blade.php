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
                    <h4 class="page-title">Chi tiết hồ sơ hộ khẩu</h4>
                    <div style="max-width: 1000px; float:right;" class="text-xs-center">
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/edit" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-edit m-r-5"></i> <span>Sửa hồ sơ</span> </a>
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/dang-ky-thuong-tru" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-account-add m-r-5"></i> <span>Đăng ký thường trú</span> </a>
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/tach-ho-khau" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-collection-item-2 m-r-5"></i> <span>Tách hộ</span> </a>
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-cap-doi-SHK" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-swap m-r-5"></i> <span>Cấp đổi</span> </a>
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-cap-lai-SHK" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-swap-vertical m-r-5"></i> <span>Cấp lại</span> </a>
                        <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-xoa-thuong-tru-HDG" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-delete m-r-5"></i> <span>Xóa thường trú</span> </a>
                    </div>
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
                           <th>STT</th>
                           <th>Hồ sơ số</th>
                           <th>Sổ hộ khẩu số</th>
                           <th>Họ tên</th>
                            <th>Quan hệ với chủ hộ</th>
                           <th>Thường trú</th>
                           <th>Trạng thái</th>
                           <th style="width: 200px; text-align: center;">Hành động</th>
                        </tr>
                     </thead>


                      <tbody>
                        <?php $i = 1; ?>
                        @foreach($list_thongtinhokhau as $thongtinhokhau)
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $thongtinhokhau->hosohokhau_so }}</td>
                              <td>{{ $thongtinhokhau->hokhau_so }}</td>
                              <td>{{ $thongtinhokhau->hoten }}</td>
                              <td>{{ ($thongtinhokhau->idquanhechuho) ? DB::table('tbl_moiquanhe')->where('id', $thongtinhokhau->idquanhechuho)->value('name') : '' }}</td>
                              <td> {{ $thongtinhokhau->chitiet_thuongtru }} - {{ ($thongtinhokhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $thongtinhokhau->idxa_thuongtru)->value('name') : '' }} - {{ ($thongtinhokhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $thongtinhokhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($thongtinhokhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $thongtinhokhau->idtinh_thuongtru)->value('name') : '' }}</td>
                              <td style="text-align: center;">{!! ($thongtinhokhau->deleted_at != NULL) ? '<span class="label label-danger">Đã xóa</span>'  : '<span class="label label-info">Đang cư trú</span>' !!}</td>
                              <td class="center">
                                <div class="btn-group" style="max-width: 200px; margin: auto;">
                                    <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Lựa chọn <span class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        
                                        @if ($thongtinhokhau->deleted_at == NULL)
                                            
                                            <a class="dropdown-item" href="{{ route('chi-tiet-nhan-khau-thuong-tru', $thongtinhokhau->id_in_sohokhau) }}"><i style="color: #387576;" class="zmdi zmdi-eye"></i> Xem chi tiết</a>
                                            <a class="dropdown-item" href="{{ route('get-sua-nhan-khau-thuong-tru', $thongtinhokhau->id_in_sohokhau) }}"><i style="color: #D85C0C;" class="zmdi zmdi-edit"></i> Sửa nhân khẩu</a>
                                            <a class="dropdown-item" href="{{ route('check-xoa-thuong-tru-NK', $thongtinhokhau->id_in_sohokhau) }}"><i style="color: red;" class="zmdi zmdi-delete"></i> Xóa thường trú NK</a>
                                            <a class="dropdown-item" href="{{ route('get-hk-01', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-file-word-o"></i>  Trích xuất HK01</a>
                                            <a class="dropdown-item" href="{{ route('get-hk-03', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-file-word-o"></i>  Trích xuất HK03</a>
                                            <a class="dropdown-item" href="{{ route('get-hk-04', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-file-word-o"></i>  Trích xuất HK04</a>
                                        @else 
                                            <a class="dropdown-item" href="{{ route('chi-tiet-nhan-khau-thuong-tru', $thongtinhokhau->id_in_sohokhau) }}"><i style="color: #387576;" class="zmdi zmdi-eye"></i> Xem chi tiết</a>
                                            <a class="dropdown-item" href="{{ route('get-hk-01', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-file-word-o"></i>  Trích xuất HK01</a>
                                            <a class="dropdown-item" href="{{ route('get-hk-07-from-history', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-file-word-o"></i>  Trích xuất HK07</a> 
                                            <a class="dropdown-item" href="{{ route('get-dang-ky-lai-thuong-tru', $thongtinhokhau->id_in_sohokhau) }}"> <i style="color: blue;" class="fa fa-refresh"></i>  Đăng ký về lại</a> 
                                        @endif
                                    </div>
                                </div>
                            </td>
                           </tr>
                           <?php $i++; ?>
                        @endforeach
                      </tbody>
                  </table>
                  <div class="clearfix"></div>
                  <span class="m-t-10">
                      <a href="{{ route('nhan-khau.index') }}" class="btn btn-primary waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Về trang chủ</a>
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