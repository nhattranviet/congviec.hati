@extends('layouts.masterPage')

@section('css')
<link href="{{asset('/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

    <style type="text/css">
        /* .nhankhautable tr td:first-child{
            text-align: right;
        } */
    </style>
@endsection

@section('content')
<div class="content-page">
<!-- Start content -->
<div class="content">
    <div class="container">
        <!-- end row -->
        <div class="row">
            <div class="col-xs-12">
            <div class="card-box table-responsive">
                <div class="col-xs-12 col-sm-12">
                    <h4 class="m-t-0 header-title"><b>Thông tin chi tiết nhân khẩu</b></h4>
                    <a href="/sua-nhan-khau" class="btn btn-googleplus waves-effect waves-light pull-right"><span class="btn-label"><i class="zmdi zmdi-edit"></i></span>Sửa thông tin</a>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 m-t-10">
                    <table style="margin-bottom: 20px;" class="table table-striped table-bordered nhankhautable">
                        <thead>
                            <tr>
                                <th style="width: 20%; text-align: center;">Trường</th>
                                <th style="text-align: center;">Nội dung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>Họ tên</td>
                            <td>{{ $nhankhau->hoten }}</td>
                            </tr>
                            <tr>
                            <td>Ngày sinh</td>
                            <td>{{ date('d-m-Y', strtotime($nhankhau->ngaysinh)) }}</td>
                            </tr>
                            <tr>
                            <td>Giới tính</td>
                            <td>{{ ($nhankhau->gioitinh == 1) ? 'Nam' : 'Nữ'}}</td>
                            </tr>
                            <tr>
                            <td>Tạm trú</td>
                            <td> {{ $nhankhau->chitiet_tamtru }} - {{ ($nhankhau->idxa_tamtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_tamtru)->value('name') : '' }} - {{ ($nhankhau->idhuyen_tamtru) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_tamtru)->value('name') : '' }} - {{ ($nhankhau->idtinh_tamtru) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_tamtru)->value('name') : '' }}</td>
                            </tr>
                            <tr>
                            <td>Tạm trú từ</td>
                            <td> {{ ($nhankhau->tamtru_tungay != NULL) ? date('d-m-Y', strtotime($nhankhau->tamtru_tungay)) : '' }} </td>
                            </tr>
                            <tr>
                            <td>Tạm trú đến</td>
                            <td> {{ ($nhankhau->tamtru_denngay != NULL) ? date('d-m-Y', strtotime($nhankhau->tamtru_denngay)) : '' }} </td>
                            </tr>
                            <tr>
                            <td>Thường trú</td>
                            <td> {{ $nhankhau->chitiet_thuongtru }} - {{ ($nhankhau->idxa_thuongtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idhuyen_thuongtru) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtru)->value('name') : '' }} - {{ ($nhankhau->idtinh_thuongtru) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtru)->value('name') : '' }}</td>
                            </tr>
                            <tr>
                            <td>Nguyên quán</td>
                            <td> {{ $nhankhau->chitiet_nguyenquan }} - {{ ($nhankhau->idxa_nguyenquan) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idhuyen_nguyenquan) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_nguyenquan)->value('name') : '' }} - {{ ($nhankhau->idtinh_nguyenquan) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_nguyenquan)->value('name') : '' }}</td>
                            </tr>
                            <tr>
                            <td>Nơi làm việc</td>
                            <td> {{ $nhankhau->chitiet_noilamviec }} - {{ ($nhankhau->idxa_noilamviec) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noilamviec)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noilamviec) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noilamviec)->value('name') : '' }} - {{ ($nhankhau->idtinh_noilamviec) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noilamviec)->value('name') : '' }}</td>
                            </tr>
                            <tr>
                            <td>Dân tộc</td>
                            <td>{{ DB::table('tbl_dantoc')->where('id', $nhankhau->iddantoc)->value('name') }}</td>
                            </tr>
                            <tr>
                            <td>Quốc tịch</td>
                            <td>{{ DB::table('tbl_quocgia')->where('id', $nhankhau->idquoctich)->value('name') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <div class="alert alert-danger" id="error-msg" style="display: none">
                    </div>
                    <div class="alert alert-success" id="success-msg" style="display: none"> 
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 m-t-10">
                    <form id="form-nhankhau" action="/tam-tru/{{ $idnhankhau }}/{{ $idsotamtru }}/post-gia-han-tam-tru-nhan-khau" method="POST" role="form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                <fieldset class="form-group {{ ($errors->has('ngaygiahan')) ? 'has-danger' : '' }}">
                                    <label for="datepicker">Ngày gia hạn <span class="text-danger">*</span> </label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="ngaygiahan" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                <fieldset class="form-group {{ ($errors->has('giahan_denngay')) ? 'has-danger' : '' }}">
                                    <label for="datepicker">Gia hạn đến ngày <span class="text-danger">*</span> </label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="giahan_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-8">
                                <fieldset class="form-group {{ ($errors->has('ghichu')) ? 'has-danger' : '' }}">
                                    <label for="ghichu">Ghi chú/Lý do gia hạn <span class="text-danger">*</span> </label>
                                    <input type="text" name="ghichu" parsley-trigger="change" placeholder="Ghi chú/Lý do gia hạn" class="form-control" id="ghichu" value="">
                                </fieldset>
                            </div>
                        </div>
                        <div class="row m-t-10">
                            <div class="col-xs-12 col-sm-12">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route( 'chi-tiet-so-tam-tru',$idsotamtru ) }}" class="btn btn-primary waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
                            </div>
                        </div>
                    </form>
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