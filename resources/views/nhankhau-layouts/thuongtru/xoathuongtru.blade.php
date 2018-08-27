@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Xóa thường trú</h4>
                        <div class="clearfix"></div>
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

                        <div class="col-xs-12 col-sm-12 m-t-50">
                            <table style="margin-bottom: 20px;" class="table table-striped table-bordered">
                                <tr>
                                    <td>Họ tên</td>
                                    <td>{{ $nhankhau->hoten }}</td>
                                </tr>
                                <tr>
                                    <td>Ngày sinh</td>
                                    <td>{{ date('d-m-Y', strtotime($nhankhau->ngaysinh)) }}</td>
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
                                    <td>Nơi sinh</td>
                                    <td> {{ $nhankhau->chitiet_noisinh }} - {{ ($nhankhau->idxa_noisinh) ? DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noisinh)->value('name') : '' }} - {{ ($nhankhau->idhuyen_noisinh) ? DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noisinh)->value('name') : '' }} - {{ ($nhankhau->idtinh_noisinh) ? DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noisinh)->value('name') : '' }}</td>
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
                                    <td>Tôn giáo</td>
                                    <td>{{ DB::table('tbl_tongiao')->where('id', $nhankhau->idtongiao)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <td>Quốc tịch</td>
                                    <td>{{ DB::table('tbl_quocgia')->where('id', $nhankhau->idquoctich)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <td>CMND/Hộ chiếu số</td>
                                    <td>{{ ($nhankhau->cmnd_so)}}</td>
                                </tr>
                                <tr>
                                    <td>Trình độ học vấn</td>
                                    <td>{{ DB::table('tbl_trinhdohocvan')->where('id', $nhankhau->idtrinhdohocvan)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <td>Trình độ chuyên môn</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Biết tiếng dân tộc</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Nghề nghiệp</td>
                                    <td>{{ DB::table('tbl_nghenghiep')->where('id', $nhankhau->idnghenghiep)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <td>Tóm tắt bản thân</td>
                                    <td>{!! $nhankhau->tomtatbanthan !!}</td>
                                </tr>
                                <tr>
                                    <td>Tóm tắt gia đình</td>
                                    <td>{!! $nhankhau->tomtatgiadinh !!}</td>
                                </tr>
                                <tr>
                                    <td>Tiền án - Tiền sự</td>
                                    <td>{{ $nhankhau->tienan_tiensu }}</td>
                                </tr>
                            </table>
                        </div>

                        @if ($errors->any())
                        <p>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                @foreach ($errors->all() as $error)
                                <p> {{ $error }} </p>
                                @endforeach

                            </div>
                        </p>
                        @endif
                        <form id="form-nhankhau" action="{{ route('xoa-thuong-tru', $nhankhau->id_in_sohokhau) }}" method="POST" role="form">
                            @csrf
                            <input type="hidden" name="idhoso" value="{{ $nhankhau->idhoso }}">
                            <input type="hidden" name="idnhankhau" value="{{ $nhankhau->id }}">
                            <div style="padding: 0.7rem;" class="row">
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row hokhau-code">
                                        <div class="col-xs-12 col-sm-12 tab-header">
                                            <h4 class="header-title m-t-0 m-b-10">THÔNG TIN HỒ SƠ</h4>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label>Trường hợp xóa <span class="text-danger">*</span></label>
                                                <div>
                                                    @foreach($list_truonghopxoa as $truonghopxoa)
                                                        <div class="radio gender-radio">
                                                            <input type="radio" name="idtruonghopxoa" value="{{ $truonghopxoa->id }}" id="radio" >
                                                            <label for="radio1">{{ $truonghopxoa->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày xóa <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input value="{{ old('ngayxoathuongtru') }}" type="text" name="ngayxoathuongtru" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-10">
                                            <fieldset class="form-group" id="addressPickerGroup">
                                                <label for="thuongtrumoi_view">Nơi chuyển đến<span class="text-danger">*</span></label>
                                                <input type="text" name="thuongtrumoi_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ thường trú" class="form-control" id="thuongtrumoi_view">
                                                <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_thuongtrumoi" class="form-control" id="idquocgia_thuongtrumoi" value="">
                                                <input type="hidden" data-addr="" hidden="hidden" name="idtinh_thuongtrumoi" class="form-control" id="idtinh_thuongtrumoi" value="">
                                                <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_thuongtrumoi" class="form-control" id="idhuyen_thuongtrumoi" value="">
                                                <input type="hidden" data-addr="" hidden="hidden" name="idxa_thuongtrumoi" class="form-control" id="idxa_thuongtrumoi" value="">
                                                <input type="hidden" data-addr="" hidden="hidden" name="chitiet_thuongtrumoi" class="form-control" id="chitiet_thuongtrumoi" value="">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button onclick="return confirm('Bạn có muốn xóa không?');" class="pull-left btn btn-danger"><i class="fa fa-trash"></i> Xóa thường trú</button>
                                    <a class="pull-right btn btn-primary" href="{{ URL::to('nhan-khau') }}">Quay lại</a>
                                </div>
                            </div>
                        </form>

                        <div class="col-xs-12 col-sm-12">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>

<div class="modal fade" id="address-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body p-20">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Quốc gia</label>
                            <select id="country" class="form-control select2">
                                <option  value="">Chọn Quốc gia</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Tỉnh TP</label>
                            <select id="province" class="form-control select2">
                                <option value="">Chọn Tỉnh hoặc Thành Phố</option>
                            </select>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Huyện</label>
                            <select id="district" class="form-control select2">
                                <option  value="">Chọn Huyện</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label class="control-label">Xã</label>
                            <select id="ward" class="form-control select2">
                                <option value="">Chọn Xã</option>
                            </select>
                        </fieldset>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <fieldset class="form-group">
                            <label class="control-label">Chi tiết địa chỉ</label>
                            <textarea class="form-control" id="addressDetail" placeholder="Nhập chi tiét địa " rows="3"></textarea>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="saveChange" class="btn btn-primary" data-dismiss="modal">Chọn</button>
            </div>
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

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection