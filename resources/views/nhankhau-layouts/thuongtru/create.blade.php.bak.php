@extends('layouts.masterPage')
@section('js')
    <script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection

@section('css')
    <style type="text/css">
        input[type="radio"]:focus{
            outline: 2px auto rgb(229, 151, 0) !important;
            outline-offset: -2px !important;
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
                        <h4 class="page-title">Nhập hồ sơ hộ khẩu</h4>
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

                        <form id="form-nhankhau" action="{{ route('nhankhau.store') }}" method="POST" role="form" autocomplete="on">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 m-b-40">
                                    <ul class="m-b-30 nav nav-tabs m-b-10" id="myTabalt" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-expanded="true">Trang chính</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabaltContent">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home1" aria-labelledby="home-tab">
                                            <div>
                                                <div class="row hokhau-code">
                                                    <div class="col-xs-12 col-sm-12 tab-header">
                                                        <h4 class="header-title m-t-0 m-b-10">THÔNG TIN HỒ SƠ</h4>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                                                            <input type="text" name="hosohokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hosohokhau_so" value="" tabindex="1">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                                            <input type="text" name="hokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hokhau_so" value="" tabindex="2">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="so_dktt_so">Sổ ĐKTT số </label>
                                                            <input type="text" name="so_dktt_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_so" value="" tabindex="3">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="so_dktt_toso">Tờ số </label>
                                                            <input type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="" tabindex="4">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" tabindex="5">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="thuongtru_view">Nơi đăng ký thường trú <span class="text-danger">*</span></label>
                                                            <input type="text" name="thuongtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ thường trú" class="form-control addressPickerClass" id="thuongtru_view" autocomplete="off" tabindex="6">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_thuongtru" class="form-control" id="idquocgia_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_thuongtru" class="form-control" id="idtinh_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_thuongtru" class="form-control" id="idhuyen_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_thuongtru" class="form-control" id="idxa_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_thuongtru" class="form-control" id="chitiet_thuongtru" value="">
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 tab-header">
                                                        <h4 class="header-title m-t-0 m-b-10">THÔNG TIN NHÂN KHẨU</h4>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group" >
                                                                    <label>Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                                                    <select name="idquanhechuho[]" class="form-control  {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}"  tabindex="7">
                                                                        <option value="">Chọn quan hệ</option>
                                                                        @foreach($list_quanhechuho as $quanhechuho)
                                                                        <option value="{{ $quanhechuho->id }}"  {{ old('idquanhechuho') == $quanhechuho->id ? 'selected' : '' }}>{{ $quanhechuho->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="hoten">Họ và tên <span class="text-danger">*</span></label>
                                                                    <input type="text" name="hoten[]" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value=""  tabindex="8">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="tenkhac">Tên gọi khác</label>
                                                                    <input type="text" name="tenkhac[]" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="" tabindex="9">
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noisinh_view">Nơi sinh <span class="text-danger">*</span></label>
                                                                    <input type="text" name="noisinh_view" onload="test();" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi sinh" class="form-control" id="noisinh_view"  tabindex="10">
                                                                    <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_noisinh[]" class="form-control" value="" id="idquocgia_noisinh">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_noisinh[]" class="form-control" value="" id="idtinh_noisinh">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_noisinh[]" class="form-control" value="" id="idhuyen_noisinh">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_noisinh[]" class="form-control" value="" id="idxa_noisinh">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_noisinh[]" class="form-control" value="" id="chitiet_noisinh">
                                                                </fieldset>

                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="datepicker">Ngày sinh <span class="text-danger">*</span></label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="birthday[]" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="" tabindex="11">
                                                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                        </div><!-- input-group -->
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Giới tính <span class="text-danger">*</span></label>
                                                                    <div>
                                                                        <input class="gender" type="hidden" tabindex="-1" name="gender[]" value="">
                                                                        <div class="radio gender-radio">
                                                                            <input type="radio" name="gender0" value="1" id="radio1" tabindex="12">
                                                                            <label for="radio1">Nam</label>
                                                                        </div>
                                                                        <div class="radio gender-radio">
                                                                            <input type="radio" name="gender0" value="0" id="radio2" tabindex="12">
                                                                            <label for="radio2">Nữ</label>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Học vấn</label>
                                                                    <select name="idtrinhdohocvan[]" class="form-control" tabindex="13">
                                                                        <option value="">Chọn Học vấn</option>
                                                                        @foreach($educations as $education)
                                                                        <option value="{{ $education->id }}">{{ $education->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noisinh_view">Nguyên quán <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="nguyenquan_view" tabindex="14">
                                                                    <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_nguyenquan[]" class="form-control" id="idquocgia_nguyenquan">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_nguyenquan[]" class="form-control" id="idtinh_nguyenquan">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_nguyenquan[]" class="form-control" id="idhuyen_nguyenquan">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_nguyenquan[]" class="form-control" id="idxa_nguyenquan">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_nguyenquan[]" class="form-control" id="chitiet_nguyenquan">
                                                                </fieldset>

                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Nghề nghiệp</label>
                                                                    <select name="idnghenghiep[]" class="form-control" tabindex="15">
                                                                        <option value="">Chọn Nghề nghiệp</option>
                                                                        @foreach($careers as $career)
                                                                        <option value="{{ $career->id }}">{{ $career->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Dân tộc</label>
                                                                    <select name="iddantoc[]" class="form-control" tabindex="16">
                                                                        <option value="">Chọn Dân tộc</option>
                                                                        @foreach($nations as $nation)
                                                                        <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="cmnd_so">Số CMND/Hộ chiếu</label>
                                                                    <input type="text" name="cmnd_so[]" parsley-trigger="change" placeholder="Nhập số CMND/Hộ chiếu" class="form-control" id="cmnd_so" value="" tabindex="17">
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noiohiennay_view">Nơi ở hiện nay <span class="text-danger">*</span></label>
                                                                    <input type="text" name="noiohiennay_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi ở hiện nay" class="form-control" id="noiohiennay_view" tabindex="18">
                                                                    <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_noiohiennay[]" class="form-control" id="idquocgia_noiohiennay">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_noiohiennay[]" class="form-control" id="idtinh_noiohiennay">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_noiohiennay[]" class="form-control" id="idhuyen_noiohiennay">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_noiohiennay[]" class="form-control" id="idxa_noiohiennay">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_noiohiennay[]" class="form-control" id="chitiet_noiohiennay">
                                                                </fieldset>

                                                            </div>
                                                            
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="trinhdochuyenmon">Trình độ chuyên môn</label>
                                                                    <input type="text" name="trinhdochuyenmon[]" parsley-trigger="change" placeholder="Trình độ chuyên môn" class="form-control" value="" id="trinhdochuyenmon" tabindex="19">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="trinhdongoaingu">Trình độ ngoại ngữ</label>
                                                                    <input type="text" name="trinhdongoaingu[]" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="" id="trinhdongoaingu" tabindex="20">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Tôn giáo <span class="text-danger">*</span></label>
                                                                    <select name="idtongiao[]" class="form-control" tabindex="21">
                                                                        <option value="">Chọn Tôn giáo</option>
                                                                        @foreach($religions as $religion)
                                                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noilamviec_view">Nơi làm việc</label>
                                                                    <input type="text" name="noilamviec_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="noilamviec_view" tabindex="22">
                                                                    <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_noilamviec[]" class="form-control" id="idquocgia_noilamviec">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_noilamviec[]" class="form-control" id="idtinh_noilamviec">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_noilamviec[]" class="form-control" id="idhuyen_noilamviec">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_noilamviec[]" class="form-control" id="idxa_noilamviec">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_noilamviec[]" class="form-control" id="chitiet_noilamviec">
                                                                </fieldset>

                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Quốc tịch <span class="text-danger">*</span></label>
                                                                    <select name="idquoctich[]" class="form-control" tabindex="23">
                                                                        <option  value="">Chọn Quốc tịch</option>
                                                                        @foreach($countries as $country)
                                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="biettiengdantoc">Biết tiếng dân tộc</label>
                                                                    <input type="text" name="biettiengdantoc[]" parsley-trigger="change" placeholder="Biết tiếng dân tộc" class="form-control" value="" id="biettiengdantoc" tabindex="24">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="datepicker">Ngày ĐKTT <span class="text-danger">*</span></label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input type="text" name="ngaydangky[]" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value=""  tabindex="25">
                                                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                        </div><!-- input-group -->
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="thuongtrutruoc_view">Nơi thường trú trước đây (hộ ngoài huyện chuyển đến)</label>
                                                                    <input type="text" name="thuongtrutruoc_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn nơi thường trú trước đây" class="form-control" id="thuongtrutruoc_view" tabindex="26">
                                                                    <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_thuongtrutruoc[]" class="form-control" id="idquocgia_thuongtrutruoc">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_thuongtrutruoc[]" class="form-control" id="idtinh_thuongtrutruoc">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_thuongtrutruoc[]" class="form-control" id="idhuyen_thuongtrutruoc">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_thuongtrutruoc[]" class="form-control" id="idxa_thuongtrutruoc">
                                                                    <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_thuongtrutruoc[]" class="form-control" id="chitiet_thuongtrutruoc">
                                                                </fieldset>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt bản thân (Từ đủ 14 tuổi trở lên đến nay ở đâu, làm gì:) </label>
                                                            <textarea class="form-control ckeditor" name="description[]" rows="3" tabindex="27">
                                                                <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:100%;">
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
                                                            </textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tóm tắt gia đình</label>
                                                            <textarea class="form-control ckeditor" name="descriptionFamily[]" rows="3" tabindex="28">
                                                                <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;" summary="Tóm lược">
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
                                                            </textarea>
                                                        </fieldset>

                                                        <fieldset class="form-group">
                                                            <label for="exampleTextarea">Tiền án (Tội danh, hình phạt, theo bản án số)</label>
                                                            <textarea class="form-control" name="criminalRecord[]" rows="3" tabindex="29"></textarea>
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
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Thêm hồ sơ</button>
                                    <button type="button" class="btn btn-danger pull-right" id="createTab"><i class="fa fa-user"></i> Thêm nhân khẩu</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
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
