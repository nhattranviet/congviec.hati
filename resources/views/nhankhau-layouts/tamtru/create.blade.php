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
            <!-- end row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Đăng ký tạm trú hộ gia đình</h4>
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

                        <form id="form-nhankhau" action="{{ route('tam-tru.store') }}" method="POST" role="form" autocomplete="off">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
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

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="thuongtru_view">Nơi thường trú <span class="text-danger">*</span></label>
                                                            <input type="text" name="thuongtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ thường trú" class="form-control" id="thuongtru_view">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_thuongtru" class="form-control" id="idquocgia_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_thuongtru" class="form-control" id="idtinh_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_thuongtru" class="form-control" id="idhuyen_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_thuongtru" class="form-control" id="idxa_thuongtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_thuongtru" class="form-control" id="chitiet_thuongtru" value="">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                                        <fieldset class="form-group" id="addressPickerGroup">
                                                            <label for="tamtru_view">Nơi đăng ký tạm trú <span class="text-danger">*</span></label>
                                                            <input type="text" name="tamtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ tạm trú" class="form-control" id="tamtru_view" tabindex="1">
                                                            <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idquocgia_tamtru" class="form-control" id="idquocgia_tamtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idtinh_tamtru" class="form-control" id="idtinh_tamtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idhuyen_tamtru" class="form-control" id="idhuyen_tamtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="idxa_tamtru" class="form-control" id="idxa_tamtru" value="">
                                                            <input type="hidden" tabindex="-1" data-addr="" hidden="hidden" name="chitiet_tamtru" class="form-control" id="chitiet_tamtru" value="">
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="sotamtru_so">Sổ tạm trú số <span class="text-danger">*</span></label>
                                                            <input type="text" name="sotamtru_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="sotamtru_so" value="" tabindex="2">
                                                        </fieldset>
                                                    </div>
                                                    
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày ĐK tạm trú <span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input type="text" name="ngaydangky" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="" tabindex="3">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Tạm trú từ ngày <span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input type="text" name="tamtru_tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="" tabindex="4">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Tạm trú đến ngày <span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input type="text" name="tamtru_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="" tabindex="5">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>



                                                </div>

                                                <div class="row m-t-20">
                                                    <div class="col-xs-12 col-sm-12 tab-header">
                                                        <h4 class="header-title m-t-0 m-b-10">THÔNG TIN NHÂN KHẨU</h4>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group" >
                                                                    <label>Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                                                    <select name="idquanhechuho[]" class="form-control  {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}" tabindex="6">
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
                                                                    <input type="text" name="hoten[]" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="" tabindex="7">
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="tenkhac">Tên gọi khác</label>
                                                                    <input type="text" name="tenkhac[]" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="" tabindex="8">
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">
                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noisinh_view">Nguyên quán <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="nguyenquan_view" tabindex="9">
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
                                                                    <select name="idnghenghiep[]" class="form-control" tabindex="10">
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
                                                                    <select name="iddantoc[]" class="form-control" tabindex="11">
                                                                        <option value="">Chọn Dân tộc</option>
                                                                        @foreach($nations as $nation)
                                                                        <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label for="datepicker">Ngày sinh <span class="text-danger">*</span></label>
                                                                        <div class="input-group">
                                                                            <input type="text" name="birthday[]" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="" tabindex="12">
                                                                            <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                        </div><!-- input-group -->
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">
                                                                <fieldset class="form-group" id="addressPickerGroup">
                                                                    <label for="noilamviec_view">Nơi làm việc</label>
                                                                    <input type="text" name="noilamviec_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="noilamviec_view" tabindex="13">
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
                                                                    <select name="idquoctich[]" class="form-control" tabindex="14">
                                                                        <option  value="">Chọn Quốc tịch</option>
                                                                        @foreach($countries as $country)
                                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                                <fieldset class="form-group">
                                                                    <label>Giới tính <span class="text-danger">*</span></label>
                                                                    <div>
                                                                        <input class="gender" type="hidden" tabindex="-1" name="gender[]" value="">
                                                                        <div class="radio gender-radio">
                                                                            <input type="radio" name="gender0" value="1" id="radio1" tabindex="15">
                                                                            <label for="radio1">Nam</label>
                                                                        </div>
                                                                        <div class="radio gender-radio">
                                                                            <input type="radio" name="gender0" value="0" id="radio2" tabindex="15">
                                                                            <label for="radio2">Nữ</label>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Thêm hồ sơ</button>
                                    <button type="button" class="btn btn-danger pull-right" id="createTab"> <i class="fa fa-user-plus"></i> Thêm nhân khẩu</button>
                                    {{-- <a href="{{ route('tam-tru.index') }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a> --}}
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
