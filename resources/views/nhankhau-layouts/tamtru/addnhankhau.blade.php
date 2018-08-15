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
                <div class="col-xs-12">
                    <div class="card-box">
                        <form id="form-nhankhau" action="{{ route('post-add-nhan-khau-tam-tru', $sotamtru->idsotamtru) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 tab-header">
                                    <h4 class="header-title m-t-0 m-b-10">Thêm nhân khẩu vào sổ tạm trú: Hộ {{ $sotamtru->hoten }} - Mã sổ {{ $sotamtru->sotamtru_so }}</h4>
                                    <p>(Tạm trú tại {{ $sotamtru->chitiet_tamtru }} - {{ ($sotamtru->idxa_tamtru) ? DB::table('tbl_xa_phuong_tt')->where('id', $sotamtru->idxa_tamtru)->value('name') : '' }} - {{ ($sotamtru->idhuyen_tamtru) ? DB::table('tbl_huyen_tx')->where('id', $sotamtru->idhuyen_tamtru)->value('name') : '' }} - {{ ($sotamtru->idtinh_tamtru) ? DB::table('tbl_tinh_tp')->where('id', $sotamtru->idtinh_tamtru)->value('name') : '' }}) </p>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                                <label for="hoten">Sổ tạm trú số <span class="text-danger">*</span> </label>
                                                <input disabled="disabled" type="text" name="hoten" parsley-trigger="change" placeholder="Sổ tạm trú" class="form-control" id="hoten" value="{{ $sotamtru->sotamtru_so }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group" >
                                                <label>Quan hệ với chủ hộ <span class="text-danger">*</span></label>
                                                <select name="idquanhechuho" class="form-control select2  {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}">
                                                    <option value="">Chọn quan hệ</option>
                                                    @foreach($list_quanhechuho as $quanhechuho)
                                                    <option value="{{ $quanhechuho->id }}"  {{ old('idquanhechuho') == $quanhechuho->id ? 'selected' : '' }}>{{ $quanhechuho->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                                <label for="hoten">Họ và tên <span class="text-danger">*</span> </label>
                                                <input type="text" name="hoten" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('tenkhac')) ? 'has-danger' : '' }}">
                                                <label for="tenkhac">Tên gọi khác </label>
                                                <input type="text" name="tenkhac" parsley-trigger="change" placeholder="Tên gọi khác/Biệt danh" class="form-control" id="tenkhac" value="">
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('birthday')) ? 'has-danger' : '' }}">
                                                <label for="datepicker">Ngày sinh <span class="text-danger">*</span> </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="birthday" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group">
                                                <label>Giới tính <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender" value="1" id="radio1">
                                                        <label for="radio1">Nam</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender" value="0" id="radio2">
                                                        <label for="radio2">Nữ</label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('ngaydangky')) ? 'has-danger' : '' }}">
                                                <label for="datepicker">Ngày đăng ký tạm trú <span class="text-danger">*</span> </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngaydangky" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('tamtru_tungay')) ? 'has-danger' : '' }}">
                                                <label for="datepicker">Tạm trú từ ngày <span class="text-danger">*</span> </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="tamtru_tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group {{ ($errors->has('tamtru_denngay')) ? 'has-danger' : '' }}">
                                                <label for="datepicker">Tạm trú đến ngày <span class="text-danger">*</span> </label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="tamtru_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group">
                                                <label>Dân tộc</label>
                                                <select name="iddantoc" class="form-control select2 {{ ($errors->has('iddantoc')) ? 'has-danger' : '' }}">
                                                    <option value="">Chọn Dân tộc</option>
                                                    @foreach($nations as $nation)
                                                    <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group">
                                                <label>Nghề nghiệp</label>
                                                <select name="idnghenghiep" class="form-control select2 {{ ($errors->has('idnghenghiep')) ? 'has-danger' : '' }}">
                                                    <option value="">Chọn Nghề nghiệp</option>
                                                    @foreach($careers as $career)
                                                    <option value="{{ $career->id }}" >{{ $career->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                            <fieldset class="form-group">
                                                <label>Quốc tịch <span class="text-danger">*</span></label>
                                                <select name="idquoctich" class="form-control select2">
                                                    <option  value="">Chọn Quốc tịch</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        
                                    </div>

                                    

                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6" id="picker">

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noisinh_view">Nguyên quán <span class="text-danger">*</span></label>
                                        <input value="" type="text" name="nguyenquan_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nguyên quán" class="form-control" id="nguyenquan_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_nguyenquan" class="form-control" value="" id="idquocgia_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_nguyenquan" class="form-control" value="" id="idtinh_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_nguyenquan" class="form-control" value="" id="idhuyen_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_nguyenquan" class="form-control" value="" id="idxa_nguyenquan">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_nguyenquan" class="form-control" value="" id="chitiet_nguyenquan">
                                    </fieldset>

                                    <fieldset class="form-group" id="addressPickerGroup">
                                        <label for="noilamviec_view">Nơi làm việc</label>
                                        <input value="" type="text" name="noilamviec_view" id="addressPicker" parsley-trigger="change" placeholder="Chọn địa chỉ nơi làm việc" class="form-control" id="noilamviec_view">
                                        <span id="clearAddress"><i class="fa fa-times-circle"></i></span>
                                        <input type="hidden" data-addr="" hidden="hidden" name="idquocgia_noilamviec" class="form-control" value="" id="idquocgia_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idtinh_noilamviec" class="form-control" value="" id="idtinh_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idhuyen_noilamviec" class="form-control" value="" id="idhuyen_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="idxa_noilamviec" class="form-control" value="" id="idxa_noilamviec">
                                        <input type="hidden" data-addr="" hidden="hidden" name="chitiet_noilamviec" class="form-control" value="" id="chitiet_noilamviec">
                                    </fieldset>

                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
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
@include('layouts.address_modal')
@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection