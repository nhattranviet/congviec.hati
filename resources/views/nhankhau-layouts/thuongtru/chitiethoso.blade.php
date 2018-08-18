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
                <div style="max-width: 1000px; margin: auto;" class="text-xs-center">
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/edit" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-edit m-r-5"></i> <span>Sửa hồ sơ</span> </a>
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/dang-ky-thuong-tru" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-account-add m-r-5"></i> <span>Đăng ký</span> </a>
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/tach-ho-khau" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-collection-item-2 m-r-5"></i> <span>Tách hộ</span> </a>
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-cap-doi-SHK" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-swap m-r-5"></i> <span>Cấp đổi</span> </a>
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-cap-lai-SHK" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-swap-vertical m-r-5"></i> <span>Cấp lại</span> </a>
                   <a style="margin: 0 5px 0 5px;" href="/nhan-khau/{{ $idhoso }}/check-xoa-thuong-tru-HDG" class="btn btn-purple-outline waves-effect waves-light"> <i style="font-size: 18px;" class="zmdi zmdi-delete m-r-5"></i> <span>Xóa thường trú</span> </a>
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
                     <h4 class="m-t-0 header-title"><b>Chi tiết hồ sơ hộ khẩu</b></h4>
                     
                  </div>

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
                           <th style="width: 100px; text-align: center;">Hành động</th>
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
                              <td style="text-align: center;">{!! ($thongtinhokhau->deleted_at != NULL) ? '<span class="label label-danger">Đã xóa</span>'  : '<span class="label label-info">Bình thường</span>' !!}</td>
                              <td>
                                <div class="button-list">
                                    @if ($thongtinhokhau->deleted_at == NULL)
                                        <a href="/nhan-khau/{{$thongtinhokhau->id_in_sohokhau}}/chi-tiet-nhan-khau" alt="Text" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết nhân khẩu"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                                        <a href="/nhan-khau/{{$thongtinhokhau->id_in_sohokhau}}/sua-nhan-khau" class="btn btn-danger btn-link" data-toggle="tooltip" data-placement="top" title="Sửa nhân khẩu"> <i class="zmdi zmdi-edit"></i> </a>
                                        <a href="/nhan-khau/{{$thongtinhokhau->id_in_sohokhau}}/check-xoa-thuong-tru" class="btn btn-primary btn-link" data-toggle="tooltip" data-placement="top" title="Xóa thường trú nhân khẩu"> <i style="color: red;" class="fa fa-remove"></i> </a>
                                    @endif
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