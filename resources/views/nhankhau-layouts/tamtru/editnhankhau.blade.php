@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var config = {};
            config.entities_latin = false
            $('.ckeditor').ckeditor(config);


        });
    </script>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger" id="error-msg" style="display: none">
                    </div>
                    <div class="alert alert-success" id="success-msg" style="display: none">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <h4 class="header-title m-t-0 pull-left">Sửa thông tin nhân khẩu</h4>
                </div>
                <div class="col-xs-12">
                    <div class="card-box">
                        <form id="form-nhankhau" action="/tam-tru/{{ $nhankhau->idnhankhau }}/{{ $nhankhau->idsotamtru}}/sua-nhan-khau" method="POST" role="form">
                            @csrf
                            <div class="row m-t-20">
                                <div class="col-xs-12 col-sm-12 tab-header">
                                    <h4 class="header-title m-t-0 m-b-10">THÔNG TIN NHÂN KHẨU</h4>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group {{ ($errors->has('sotamtru_so')) ? 'has-danger' : '' }}">
                                        <label for="sotamtru_so">Sổ tạm trú số <span class="text-danger">*</span> </label>
                                        <input type="text" name="sotamtru_so" parsley-trigger="change" placeholder="" class="form-control" id="sotamtru_so" value="{{old('sotamtru_so', $nhankhau->sotamtru_so)}}">
                                    </fieldset>
                                    <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                        <label for="hoten">Họ và tên <span class="text-danger">*</span> </label>
                                        <input type="text" name="hoten" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="{{old('hoten', $nhankhau->hoten)}}">
                                    </fieldset>
                                    <fieldset class="form-group {{ ($errors->has('tenkhac')) ? 'has-danger' : '' }}">
                                        <label for="tenkhac">Tên gọi khác </label>
                                        <input type="text" name="tenkhac" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="{{old('tenkhac', $nhankhau->tenkhac)}}">
                                    </fieldset>
                                    <fieldset class="form-group {{ ($errors->has('ngaydangky')) ? 'has-danger' : '' }}">
                                        <label for="datepicker">Ngày đăng ký tạm trú <span class="text-danger">*</span> </label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="ngaydangky" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{old('ngaydangky', ($nhankhau->ngaydangky) ? date('d-m-Y', strtotime($nhankhau->ngaydangky)) : ''  )}}">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('ngaysua')) ? 'has-danger' : '' }}">
                                        <label for="datepicker">Ngày sửa <span class="text-danger">*</span> </label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="ngaysua" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>

                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">

                                    <fieldset class="form-group">
                                        <label>Nghề nghiệp</label>
                                        <select name="idnghenghiep" class="form-control select2 {{ ($errors->has('idnghenghiep')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn Nghề nghiệp</option>
                                            @foreach($careers as $career)
                                            <option value="{{ $career->id }}"  {{ old('idnghenghiep', $nhankhau->idnghenghiep) == $career->id ? 'selected' : '' }}>{{ $career->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label>Dân tộc</label>
                                        <select name="iddantoc" class="form-control select2 {{ ($errors->has('iddantoc')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn Dân tộc</option>
                                            @foreach($nations as $nation)
                                            <option value="{{ $nation->id }}"  {{ old('iddantoc', $nhankhau->iddantoc) == $nation->id ? 'selected' : '' }}>{{ $nation->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('tamtru_tungay')) ? 'has-danger' : '' }}">
                                        <label for="datepicker">Tạm trú từ ngày <span class="text-danger">*</span> </label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="tamtru_tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{old('tamtru_tungay', ($nhankhau->tamtru_tungay) ? date('d-m-Y', strtotime($nhankhau->tamtru_tungay)) : ''  )}}">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('tamtru_denngay')) ? 'has-danger' : '' }}">
                                        <label for="datepicker">Tạm trú đến ngày <span class="text-danger">*</span> </label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="tamtru_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{old('tamtru_denngay', ($nhankhau->tamtru_denngay) ? date('d-m-Y', strtotime($nhankhau->tamtru_denngay)) : ''  )}}">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>

                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label>Quốc tịch <span class="text-danger">*</span></label>
                                        <select name="idquoctich" class="form-control select2 {{ ($errors->has('idquoctich')) ? 'has-danger' : '' }}">
                                            <option  value="">Chọn Quốc tịch</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}"  {{ old('idquoctich', $nhankhau->idquoctich) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label>Giới tính <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="radio gender-radio">
                                                <input type="radio" name="gender" value="1" id="radio1" {{ (old('gender', $nhankhau->gioitinh) == 1) ? 'checked' : NULL }}>
                                                <label for="radio1">Nam</label>
                                            </div>
                                            <div class="radio gender-radio">
                                                <input type="radio" name="gender" value="0" id="radio2" {{ (old('gender', $nhankhau->gioitinh) == 0) ? 'checked' : NULL }}>
                                                <label for="radio2">Nữ</label>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('birthday')) ? 'has-danger' : '' }}">
                                        <label for="datepicker">Ngày sinh <span class="text-danger">*</span> </label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="birthday" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{old('birthday', ($nhankhau->ngaysinh) ? date('d-m-Y', strtotime($nhankhau->ngaysinh)) : ''  )}}">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('ghichu')) ? 'has-danger' : '' }}">
                                        <label for="ghichu">Ghi chú sửa <span class="text-danger">*</span> </label>
                                        <input type="text" name="ghichu" parsley-trigger="change" placeholder="" class="form-control" id="ghichu" value="">
                                    </fieldset>

                                    

                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="thuongtru_view">Thường trú <span class="text-danger">*</span></label>
                                        <input value="{{ $nhankhau->chitiet_thuongtru }} {{ ($nhankhau->idxa_thuongtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtru)->value('name') : '' }} {{ ($nhankhau->idhuyen_thuongtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtru)->value('name') : '' }} {{ ($nhankhau->idtinh_thuongtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtru)->value('name') : '' }}" type="text" name="thuongtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="thuongtru_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_thuongtru" class="form-control" value="{{old('idquocgia_thuongtru', $nhankhau->idquocgia_thuongtru)}}" value="@if(isset($nhankhau)){{$nhankhau->idquocgia_thuongtru}}@endif" id="idquocgia_thuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_thuongtru" class="form-control" value="{{old('idtinh_thuongtru', $nhankhau->idtinh_thuongtru)}}" value="@if(isset($nhankhau)){{$nhankhau->idtinh_thuongtru}}@endif" id="idtinh_thuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_thuongtru" class="form-control" value="{{old('idhuyen_thuongtru', $nhankhau->idhuyen_thuongtru)}}" value="@if(isset($nhankhau)){{$nhankhau->idhuyen_thuongtru}}@endif" id="idhuyen_thuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_thuongtru" class="form-control" value="{{old('idxa_thuongtru', $nhankhau->idxa_thuongtru)}}" value="@if(isset($nhankhau)){{$nhankhau->idxa_thuongtru}}@endif" id="idxa_thuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_thuongtru" class="form-control" value="{{old('chitiet_thuongtru', $nhankhau->chitiet_thuongtru)}}" value="@if(isset($nhankhau)){{$nhankhau->chitiet_thuongtru}}@endif" id="chitiet_thuongtru">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noisinh_view">Nguyên quán <span class="text-danger">*</span></label>
                                        <input value="{{ $nhankhau->chitiet_nguyenquan }} {{ ($nhankhau->idxa_nguyenquan) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_nguyenquan)->value('name') : '' }} {{ ($nhankhau->idhuyen_nguyenquan) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_nguyenquan)->value('name') : '' }} {{ ($nhankhau->idtinh_nguyenquan) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_nguyenquan)->value('name') : '' }}" type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="nguyenquan_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_nguyenquan" class="form-control" value="{{old('idquocgia_nguyenquan', $nhankhau->idquocgia_nguyenquan)}}" value="@if(isset($nhankhau)){{$nhankhau->idquocgia_nguyenquan}}@endif" id="idquocgia_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_nguyenquan" class="form-control" value="{{old('idtinh_nguyenquan', $nhankhau->idtinh_nguyenquan)}}" value="@if(isset($nhankhau)){{$nhankhau->idtinh_nguyenquan}}@endif" id="idtinh_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_nguyenquan" class="form-control" value="{{old('idhuyen_nguyenquan', $nhankhau->idhuyen_nguyenquan)}}" value="@if(isset($nhankhau)){{$nhankhau->idhuyen_nguyenquan}}@endif" id="idhuyen_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_nguyenquan" class="form-control" value="{{old('idxa_nguyenquan', $nhankhau->idxa_nguyenquan)}}" value="@if(isset($nhankhau)){{$nhankhau->idxa_nguyenquan}}@endif" id="idxa_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_nguyenquan" class="form-control" value="{{old('chitiet_nguyenquan', $nhankhau->chitiet_nguyenquan)}}" value="@if(isset($nhankhau)){{$nhankhau->chitiet_nguyenquan}}@endif" id="chitiet_nguyenquan">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noilamviec_view">Nơi làm việc</label>
                                        <input value="{{ $nhankhau->chitiet_noilamviec }} {{ ($nhankhau->idxa_noilamviec) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noilamviec)->value('name') : '' }} {{ ($nhankhau->idhuyen_noilamviec) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noilamviec)->value('name') : '' }} {{ ($nhankhau->idtinh_noilamviec) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noilamviec)->value('name') : '' }}" type="text" name="noilamviec_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="noilamviec_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noilamviec" class="form-control" value="{{old('idquocgia_noilamviec', $nhankhau->idquocgia_noilamviec)}}" id="idquocgia_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noilamviec" class="form-control" value="{{old('idtinh_noilamviec', $nhankhau->idtinh_noilamviec)}}" id="idtinh_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noilamviec" class="form-control" value="{{old('idhuyen_noilamviec', $nhankhau->idhuyen_noilamviec)}}" id="idhuyen_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_noilamviec" class="form-control" value="{{old('idxa_noilamviec', $nhankhau->idxa_noilamviec)}}" id="idxa_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noilamviec" class="form-control" value="{{old('chitiet_noilamviec', $nhankhau->chitiet_noilamviec)}}" id="chitiet_noilamviec">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="tamtru_view">Nơi tạm trú</label>
                                        <input value="{{ $nhankhau->chitiet_tamtru }} {{ ($nhankhau->idxa_tamtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_tamtru)->value('name') : '' }} {{ ($nhankhau->idhuyen_tamtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_tamtru)->value('name') : '' }} {{ ($nhankhau->idtinh_tamtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_tamtru)->value('name') : '' }}" type="text" name="tamtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="tamtru_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_tamtru" class="form-control" value="{{old('idquocgia_tamtru', $nhankhau->idquocgia_tamtru)}}" id="idquocgia_tamtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_tamtru" class="form-control" value="{{old('idtinh_tamtru', $nhankhau->idtinh_tamtru)}}" id="idtinh_tamtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_tamtru" class="form-control" value="{{old('idhuyen_tamtru', $nhankhau->idhuyen_tamtru)}}" id="idhuyen_tamtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_tamtru" class="form-control" value="{{old('idxa_tamtru', $nhankhau->idxa_tamtru)}}" id="idxa_tamtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_tamtru" class="form-control" value="{{old('chitiet_tamtru', $nhankhau->chitiet_tamtru)}}" id="chitiet_tamtru">
                                    </fieldset>

                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <input type="hidden" name="idtamtru" value="{{ $nhankhau->idtamtru }}">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="{{ route('tam-tru.index') }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
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
<div class="modal fade" id="address-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Chọn địa chỉ</h4>
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
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection