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
                    <div class="page-title-box">
                        <h4 class="page-title">Sửa thông tin nhân khẩu</h4>
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
                    <div class="card-box">
                        @if ($errors->any())
                            <p>
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    @foreach ($errors->all() as $error)
                                        <p> {{ $error }} </p>
                                    @endforeach
                                    
                                </div>
                            </p>
                        @endif
                        <form id="form-nhankhau" action="{{ route('sua-nhan-khau', $nhankhau->id_in_sohokhau) }}" method="POST" role="form">
                            @csrf
                            <input type="hidden" name="idnhankhau" value="{{ $nhankhau->id }}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Thông tin nhân khẩu</h4>
                                    <div class="btn-group pull-right m-t-15">
                                        {{-- <button type="button" class="btn btn-custom" id="createTab">Thêm nhân khẩu</button> --}}
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <ul class="m-b-30 nav nav-tabs m-b-10" id="myTabalt" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-expanded="true">Trang chính</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabaltContent">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home1" aria-labelledby="home-tab">
                                            <div>

                                                <div class="row m-t-20">
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group" >
                                                            <label>Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                                            <select name="idquanhechuho" class="form-control select2 {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn quan hệ</option>
                                                                @foreach($list_quanhechuho as $quanhechuho)
                                                                <option value="{{ $quanhechuho->id }}"  {{ old('idquanhechuho', $nhankhau->idquanhechuho) == $quanhechuho->id ? 'selected' : '' }}>{{ $quanhechuho->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                        <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                                            <label for="hoten">Họ và tên <span class="text-danger">*</span> </label>
                                                            <input type="text" name="hoten" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="{{old('hoten', $nhankhau->hoten)}}">
                                                        </fieldset>
                                                        <fieldset class="form-group {{ ($errors->has('tenkhac')) ? 'has-danger' : '' }}">
                                                            <label for="tenkhac">Tên gọi khác </label>
                                                            <input type="text" name="tenkhac" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="{{old('tenkhac', $nhankhau->tenkhac)}}">
                                                        </fieldset>
                                                        <fieldset class="form-group {{ ($errors->has('birthday')) ? 'has-danger' : '' }}">
                                                            <label for="datepicker">Ngày sinh <span class="text-danger">*</span> </label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input type="text" name="birthday" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="{{old('birthday', ($nhankhau->ngaydangky) ? date('d-m-Y', strtotime($nhankhau->ngaysinh)) : ''  )}}">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày ĐKTT<span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input  value="{{old('ngaydangky', ($nhankhau->ngaydangky) ? date('d-m-Y', strtotime($nhankhau->ngaydangky)) : '' )}}" type="text" name="ngaydangky" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>

                                                    </div>



                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label>Học vấn</label>
                                                            <select name="idtrinhdohocvan" class="form-control select2 {{ ($errors->has('idtrinhdohocvan')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn học vấn</option>
                                                                @foreach($educations as $education)
                                                                    <option value="{{ $education->id }}"  {{ old('idtrinhdohocvan', $nhankhau->idtrinhdohocvan) == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

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

                                                        <fieldset class="form-group {{ ($errors->has('cmnd_so')) ? 'has-danger' : '' }}">
                                                            <label for="cmnd_so">Số CMND</label>
                                                            <input type="text" name="cmnd_so" parsley-trigger="change" placeholder="Nhập số CMND" class="form-control" id="cmnd_so" value="{{old('cmnd_so', $nhankhau->cmnd_so)}}">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label>Giới tính <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="hidden" name="gender" value="@if(isset($nhankhau)){{$nhankhau->gioitinh}} @endif">
                                                                <div class="radio gender-radio">
                                                                    <input type="radio" name="gender" value="1" id="radio1" {{ (old('gender', $nhankhau->gioitinh) == 1) ? 'checked' : NULL }} >
                                                                    <label for="radio1">Nam</label>
                                                                </div>
                                                                <div class="radio gender-radio">
                                                                    <input type="radio" name="gender" value="0" id="radio2" {{ (old('gender', $nhankhau->gioitinh) == 0) ? 'checked' : NULL }} >
                                                                    <label for="radio2">Nữ</label>
                                                                </div>
                                                            </div>
                                                        </fieldset>

                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group {{ ($errors->has('trinhdochuyenmon')) ? 'has-danger' : '' }}">
                                                            <label for="trinhdochuyenmon">Trình độ chuyên môn</label>
                                                            <input type="text" name="trinhdochuyenmon" parsley-trigger="change" placeholder="Trình độ chuyên môn" class="form-control" value="{{old('trinhdochuyenmon', $nhankhau->trinhdochuyenmon)}}" id="trinhdochuyenmon">
                                                        </fieldset>

                                                        <fieldset class="form-group {{ ($errors->has('trinhdongoaingu')) ? 'has-danger' : '' }}">
                                                            <label for="trinhdongoaingu">Trình độ ngoại ngữ</label>
                                                            <input type="text" name="trinhdongoaingu" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="{{old('trinhdongoaingu', $nhankhau->trinhdongoaingu)}}" id="trinhdongoaingu">
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label>Tôn giáo <span class="text-danger">*</span></label>
                                                            <select name="idtongiao" class="form-control select2 {{ ($errors->has('idtongiao')) ? 'has-danger' : '' }}">
                                                                <option value="">Chọn Tôn giáo</option>
                                                                @foreach($religions as $religion)
                                                                <option value="{{ $religion->id }}"  {{ old('idtongiao', $nhankhau->idtongiao) == $religion->id ? 'selected' : '' }}>{{ $religion->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label>Quốc tịch <span class="text-danger">*</span></label>
                                                            <select name="idquoctich" class="form-control select2 {{ ($errors->has('idquoctich')) ? 'has-danger' : '' }}">
                                                                <option  value="">Chọn Quốc tịch</option>
                                                                @foreach($countries as $country)
                                                                <option value="{{ $country->id }}"  {{ old('idquoctich', $nhankhau->idquoctich) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>

                                                        <fieldset class="form-group {{ ($errors->has('biettiengdantoc')) ? 'has-danger' : '' }}">
                                                            <label for="biettiengdantoc">Biết tiếng dân tộc</label>
                                                            <input type="text" name="biettiengdantoc" parsley-trigger="change" placeholder="Biết tiếng dân tộc" class="form-control" value="{{old('biettiengdantoc', $nhankhau->biettiengdantoc)}}" id="biettiengdantoc">
                                                        </fieldset>
                                                        
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-5" id="picker">

                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span> </label>
                                                            <input value="{{ $nhankhau->chitiet_noisinh }} {{ ($nhankhau->idxa_noisinh) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noisinh)->value('name') : '' }} {{ ($nhankhau->idhuyen_noisinh) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noisinh)->value('name') : '' }} {{ ($nhankhau->idtinh_noisinh) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noisinh)->value('name') : '' }}" type="text" name="noisinh_view" onload="test();" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi sinh" class="form-control" id="noisinh_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noisinh" class="form-control" value="{{old('idquocgia_noisinh', $nhankhau->idquocgia_noisinh)}}" id="idquocgia_noisinh">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noisinh" class="form-control" value="{{old('idtinh_noisinh', $nhankhau->idtinh_noisinh)}}" id="idtinh_noisinh">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noisinh" class="form-control" value="{{old('idhuyen_noisinh', $nhankhau->idhuyen_noisinh)}}" id="idhuyen_noisinh">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_noisinh" class="form-control" value="{{old('idxa_noisinh', $nhankhau->idxa_noisinh)}}" id="idxa_noisinh">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noisinh" class="form-control" value="{{old('chitiet_noisinh', $nhankhau->chitiet_noisinh)}}" id="chitiet_noisinh">
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
                                                            <label for="noiohiennay_view">Nơi ở hiện nay <span class="text-danger">*</span></label>
                                                            <input value="{{ $nhankhau->chitiet_noiohiennay }} {{ ($nhankhau->idxa_noiohiennay) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_noiohiennay)->value('name') : '' }} {{ ($nhankhau->idhuyen_noiohiennay) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_noiohiennay)->value('name') : '' }} {{ ($nhankhau->idtinh_noiohiennay) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_noiohiennay)->value('name') : '' }}" type="text" name="noiohiennay_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi ở hiện nay" class="form-control" id="noiohiennay_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noiohiennay" class="form-control" value="{{old('idquocgia_noiohiennay', $nhankhau->idquocgia_noiohiennay)}}" id="idquocgia_noiohiennay">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noiohiennay" class="form-control" value="{{old('idtinh_noiohiennay', $nhankhau->idtinh_noiohiennay)}}" id="idtinh_noiohiennay">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noiohiennay" class="form-control" value="{{old('idhuyen_noiohiennay', $nhankhau->idhuyen_noiohiennay)}}" id="idhuyen_noiohiennay">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_noiohiennay" class="form-control" value="{{old('idxa_noiohiennay', $nhankhau->idxa_noiohiennay)}}" id="idxa_noiohiennay">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noiohiennay" class="form-control" value="{{old('chitiet_noiohiennay', $nhankhau->chitiet_noiohiennay)}}" id="chitiet_noiohiennay">
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
                                                            <label for="thuongtrutruoc_view">Nơi thường trú trước đây (hộ ngoài huyện chuyển đến)</label>
                                                            <input value="{{ $nhankhau->chitiet_thuongtrutruoc }} {{ ($nhankhau->idxa_thuongtrutruoc) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $nhankhau->idxa_thuongtrutruoc)->value('name') : '' }} {{ ($nhankhau->idhuyen_thuongtrutruoc) ? '-'.DB::table('tbl_huyen_tx')->where('id', $nhankhau->idhuyen_thuongtrutruoc)->value('name') : '' }} {{ ($nhankhau->idtinh_thuongtrutruoc) ? '-'.DB::table('tbl_tinh_tp')->where('id', $nhankhau->idtinh_thuongtrutruoc)->value('name') : '' }}" type="text" name="thuongtrutruoc_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn nơi thường trú trước khi chuyển đến" class="form-control" id="thuongtrutruoc_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_thuongtrutruoc" class="form-control" value="{{old('idquocgia_thuongtrutruoc', $nhankhau->idquocgia_thuongtrutruoc)}}" id="idquocgia_thuongtrutruoc">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idtinh_thuongtrutruoc" class="form-control" value="{{old('idtinh_thuongtrutruoc', $nhankhau->idtinh_thuongtrutruoc)}}" id="idtinh_thuongtrutruoc">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_thuongtrutruoc" class="form-control" value="{{old('idhuyen_thuongtrutruoc', $nhankhau->idhuyen_thuongtrutruoc)}}" id="idhuyen_thuongtrutruoc">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="idxa_thuongtrutruoc" class="form-control" value="{{old('idxa_thuongtrutruoc', $nhankhau->idxa_thuongtrutruoc)}}" id="idxa_thuongtrutruoc">
                                                            <input type="hidden" data-addr="" hidden="hidden" name="chitiet_thuongtrutruoc" class="form-control" value="{{old('chitiet_thuongtrutruoc', $nhankhau->chitiet_thuongtrutruoc)}}" id="chitiet_thuongtrutruoc">
                                                        </fieldset>

                                                        

                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày sửa<span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input  value="{{old('date_action')}}" type="text" name="date_action" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-10">
                                                        <fieldset class="form-group">
                                                            <label for="ghichu">Lý do</label>
                                                            <input type="text" name="ghichu" parsley-trigger="change" placeholder="Nhập lý do" class="form-control" value="{{old('ghichu')}}" id="ghichu">
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <fieldset class="form-group">
                                                            <div>
                                                                <div class="checkbox checkbox-primary">
                                                                    <input name="moisinh" value="1" {{ old('moisinh', $nhankhau->moisinh) == 1 ? 'checked' : '' }} type="checkbox">
                                                                    <label for="checkbox21">
                                                                        Nhân khẩu mới sinh
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) </label>
                                                            <textarea class="form-control ckeditor" name="description" rows="3">@if(isset($nhankhau)){{$nhankhau->tomtatbanthan}}
                                                                @else
                                                                    <table align="center" border="1" cellpadding="1" cellspacing="0" style="width:100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th style="text-align: center; vertical-align: middle; width: 20%;">
                                                                                    <p>Từ tháng năm <br>- đến tháng năm</p>
                                                                                </th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 60%;">
                                                                                    <p>Chổ ở</p>
                                                                                    <p>(Ghi rõ số nhà, đường phố; thôn, xóm, làng, ấp, bản, buôn, phum, sóc; xã/ phường/thị trấn; quận/ huyện; tỉnh/ thành phố. Nếu ở nước ngoài thì ghi rõ tên nước)</p>
                                                                                </th>
                                                                                <th>Nghề nghiệp, nơi làm việc</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                @endif
                                                                <p></p>
                                                            </textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt gia đình</label>
                                                            <textarea class="form-control ckeditor" name="descriptionFamily" rows="3">@if(isset($nhankhau)){{$nhankhau->tomtatgiadinh}} 
                                                                @else
                                                                    <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:100%" summary="Tóm lược">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align: center; vertical-align: middle; width: 5%;" scope="col">STT</th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 20%;" scope="col">Họ tên</th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 10%;" scope="col">Ngày sinh</th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 5%;" scope="col">Giới tính</th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 5%;" scope="col">Quan hệ</th>
                                                                                <th style="text-align: center; vertical-align: middle; width: 15%;" scope="col">Nghề nghiệp</th>
                                                                                <th scope="col">Địa chỉ chổ ở hiện nay</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                @endif

                                                            </textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)</label>
                                                            <textarea class="form-control" name="criminalRecord" rows="1">{{old('criminalRecord', $nhankhau->tienan_tiensu)}} </textarea>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Cập nhật</button>
                                </div>
                            </div>
                            <input type="hidden" name="idhoso" value="{{ $nhankhau->idhoso }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>
@include('layouts.address_modal')
@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection