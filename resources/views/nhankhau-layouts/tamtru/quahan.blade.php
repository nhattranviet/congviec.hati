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

        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Danh sách nhân khẩu quá hạn tạm trú</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-xs-12">
               <div class="card-box table-responsive">
                  <form id="tim-kiem-hoso" action="{{ route('tam-tru.index') }}" method="GET" role="form" idresult="nhankhautable">
                    @csrf
                    <div class="col-xs-12 col-sm-12 loading" id="nhankhautable" style="position: relative;">
                            <table style="margin-bottom: 20px;" class="datatable table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Họ và tên</th>
                                        <th>Mã sổ tạm trú</th>
                                        <th>Loại sổ</th>
                                        <th>Nơi tạm trú</th>
                                        <th>Tạm trú từ</th>
                                        <th>Tạm trú đến</th>
                                        <th style="width: 220px;">Tác vụ</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($list_nhankhau as $nhankhau)
                                    <tr>
                                        <td>{{ $nhankhau->hoten }}</td>
                                        <td>{{ $nhankhau->sotamtru_so }}</td>
                                        <td> {!! ($nhankhau->type == 'hogiadinh') ? '<span class="label label-primary">Hộ gia đình</span>' : '<span class="label label-warning">Cá nhân</span>' !!} </td>
                                        <td> {{ $nhankhau->chitiet_tamtru }} {{ ($nhankhau->idxa_tamtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_tamtru)->value('name') : '' }} </td>
                                        <td>{{ date('d-m-Y', strtotime($nhankhau->tamtru_tungay)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($nhankhau->tamtru_denngay)) }}</td>
                                        <td>
                                            <div class="button-list" style="max-width: 200px; margin: auto;">
                                                <a href=" {{ route('chi-tiet-so-tam-tru', $nhankhau->idsotamtru) }} " class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết hồ sơ"> <i style="color: #387576;" class="zmdi zmdi-eye"></i> </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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