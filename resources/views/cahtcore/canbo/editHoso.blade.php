@extends('layouts.masterPage') @section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var config = {};
        config.entities_latin = false
        $('.ckeditor').ckeditor(config);


    });
</script>
@endsection @section('content')
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
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="form-nhankhau" action="{{ route('nhankhau.store') }}" method="POST" role="form">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-b-40">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 tab-header">
                                            <h4 class="header-title m-t-0 m-b-10">THÔNG TIN CÁ NHÂN</h4>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="hoten">Họ và tên
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="hoten" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="tenkhac">Tên gọi khác</label>
                                                <input type="text" name="tenkhac" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac"
                                                    value="">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày sinh
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="birthday" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0">
                                                            <i class="icon-calender"></i>
                                                        </span>
                                                    </div>
                                                    <!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày vào Đảng
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngayvaodang" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0">
                                                            <i class="icon-calender"></i>
                                                        </span>
                                                    </div>
                                                    <!-- input-group -->
                                                </div>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Giới tính
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <input class="gender" type="hidden" name="gender" value="">
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender0" value="1" id="radio1">
                                                        <label for="radio1">Nam</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender0" value="0" id="radio2">
                                                        <label for="radio2">Nữ</label>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Học vấn</label>
                                                <select name="idtrinhdohocvan" class="form-control select2">
                                                    <option value="">Chọn Học vấn</option>
                                                    @foreach($educations as $education)
                                                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">

                                            <fieldset class="form-group">
                                                <label>Nghề nghiệp</label>
                                                <select name="idnghenghiep" class="form-control select2">
                                                    <option value="">Chọn Nghề nghiệp</option>
                                                    @foreach($careers as $career)
                                                    <option value="{{ $career->id }}">{{ $career->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Dân tộc</label>
                                                <select name="iddantoc" class="form-control select2">
                                                    <option value="">Chọn Dân tộc</option>
                                                    @foreach($nations as $nation)
                                                    <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="cmnd_so">Số CMND</label>
                                                <input type="text" name="cmnd_so" parsley-trigger="change" placeholder="Nhập số CMND" class="form-control" id="cmnd_so"
                                                    value="">
                                            </fieldset>

                                            

                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="hochieu_so">Số Hộ Chiếu</label>
                                                <input type="text" name="hochieu_so" parsley-trigger="change" placeholder="Nhập số hộ chiếu (Nếu có)" class="form-control"
                                                    so value="" id="hochieu_so">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="trinhdochuyenmon">Trình độ chuyên môn</label>
                                                <input type="text" name="trinhdochuyenmon" parsley-trigger="change" placeholder="Trình độ chuyên môn" class="form-control" value="" id="trinhdochuyenmon">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="trinhdongoaingu">Trình độ ngoại ngữ</label>
                                                <input type="text" name="trinhdongoaingu" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="" id="trinhdongoaingu">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="sodt">Số điện thoại</label>
                                                <input type="text" name="sodt" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="" id="sodt">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="sodt">Mạng xã hội</label>
                                                <input type="text" name="sodt" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="" id="sodt">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="biettiengdantoc">Biết tiếng dân tộc</label>
                                                <input type="text" name="biettiengdantoc" parsley-trigger="change" placeholder="Biết tiếng dân tộc" class="form-control"
                                                    value="" id="biettiengdantoc">
                                            </fieldset>
                                            
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label>Tôn giáo
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="idtongiao" class="form-control select2">
                                                    <option value="">Chọn Tôn giáo</option>
                                                    @foreach($religions as $religion)
                                                    <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Quốc tịch
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="idquoctich" class="form-control select2">
                                                    <option value="">Chọn Quốc tịch</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                            
                                            <fieldset class="form-group">
                                                <label for="ghichu">Ghi chú</label>
                                                <input type="text" name="ghichu" parsley-trigger="change" placeholder="Trình độ ngoại ngữ" class="form-control" value="" id="ghichu">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noithuongtru_view">Nơi thường trú</label>
                                        <input type="text" name="noithuongtru_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc"
                                            class="form-control" id="noithuongtru_view">
                                        <span id="clearAddress">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noithuongtru" class="form-control" id="idquocgia_noithuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noithuongtru" class="form-control" id="idtinh_noithuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noithuongtru" class="form-control" id="idhuyen_noithuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_noithuongtru" class="form-control" id="idxa_noithuongtru">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noithuongtru" class="form-control" id="chitiet_noithuongtru">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noiohiennay_view">Nơi ở hiện nay
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="noiohiennay_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi ở hiện nay"
                                            class="form-control" id="noiohiennay_view">
                                        <span id="clearAddress">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noiohiennay" class="form-control" id="idquocgia_noiohiennay">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noiohiennay" class="form-control" id="idtinh_noiohiennay">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noiohiennay" class="form-control" id="idhuyen_noiohiennay">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_noiohiennay" class="form-control" id="idxa_noiohiennay">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noiohiennay" class="form-control" id="chitiet_noiohiennay">
                                    </fieldset>
                                </div>

                                <div class="col-md-6">
                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noisinh_view">Nơi sinh
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="noisinh_view" onload="test();" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi sinh"
                                            class="form-control" id="noisinh_view">
                                        <span id="clearAddress">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noisinh" class="form-control" value="" id="idquocgia_noisinh">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noisinh" class="form-control" value="" id="idtinh_noisinh">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noisinh" class="form-control" value="" id="idhuyen_noisinh">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_noisinh" class="form-control" value="" id="idxa_noisinh">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noisinh" class="form-control" value="" id="chitiet_noisinh">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noisinh_view">Nguyên quán
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán"
                                            class="form-control" id="nguyenquan_view">
                                        <span id="clearAddress">
                                            <i class="fa fa-times-circle"></i>
                                        </span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_nguyenquan" class="form-control" id="idquocgia_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_nguyenquan" class="form-control" id="idtinh_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_nguyenquan" class="form-control" id="idhuyen_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_nguyenquan" class="form-control" id="idxa_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_nguyenquan" class="form-control" id="chitiet_nguyenquan">
                                    </fieldset>
                                </div>
                                
                            </div>
                            <div class="row m-t-50">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Cập nhật</button>
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
                                <option value="">Chọn Quốc gia</option>
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
                                <option value="">Chọn Huyện</option>
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
