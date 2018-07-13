@extends('layouts.masterPage')

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();

        

        
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
                    <div class="alert alert-danger" id="error-msg" style="display: none">
                    </div>
                    <div class="alert alert-success" id="success-msg" style="display: none">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <h4 class="header-title m-t-0 pull-left">Thống kê</h4>
                </div>
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="tim-kiem-hoso" action="{{ URL::to('get-bao-cao-nhan-khau') }}" idresult="nhankhautable" method="GET" role="form">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Thông tin nhân khẩu</h4>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row hokhau-code">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="hoten">Họ tên</label>
                                                <input type="text" name="hoten" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hoten" value="">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Đăng ký: từ ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngaydangky_tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Đăng ký: đến ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngaydangky_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày sinh: từ ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngaysinh_tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày sinh đến ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="ngaysinh_denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Tôn giáo</label>
                                                <select name="idtongiao" class="form-control select2">
                                                    <option value="all">Tất cả</option>
                                                    @foreach($religions as $religion)
                                                    <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>

                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label>Xã đăng ký thường trú</label>
                                                <select name="idxa_thuongtru" class="form-control select2">
                                                    <option  value="all">Tất cả</option>
                                                    @foreach($list_xa_phuong as $xa_phuong)
                                                    <option value="{{ $xa_phuong->id }}">{{ $xa_phuong->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Nghề nghiệp</label>
                                                <select name="idnghenghiep" class="form-control select2">
                                                    <option value="all">Tất cả</option>
                                                    @foreach($careers as $career)
                                                    <option value="{{ $career->id }}">{{ $career->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Dân tộc</label>
                                                <select name="iddantoc" class="form-control select2">
                                                    <option value="all">Tất cả</option>
                                                    @foreach($nations as $nation)
                                                    <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label>Giới tính </label>
                                                <div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender" value="all" id="radio1" checked="checked">
                                                        <label for="radio1">Tất cả</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender" value="0" id="radio1">
                                                        <label for="radio1">Nam</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="gender" value="1" id="radio2">
                                                        <label for="radio2">Nữ</label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Đã làm CMND</label>
                                                <div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="cmnd_so" value="all" id="radio1" checked="checked">
                                                        <label for="radio1">Tất cả</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="cmnd_so" value="0" id="radio1">
                                                        <label for="radio1">Chưa làm</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="cmnd_so" value="1" id="radio2">
                                                        <label for="radio2">Đã làm</label>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label>Tiền án - Tiền sự</label>
                                                <div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="tienan_tiensu" value="all" id="radio1" checked="checked">
                                                        <label for="radio1">Tất cả</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="tienan_tiensu" value="0" id="radio1">
                                                        <label for="radio1">Không</label>
                                                    </div>
                                                    <div class="radio gender-radio">
                                                        <input type="radio" name="tienan_tiensu" value="1" id="radio2">
                                                        <label for="radio2">Có</label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button id="submitBtn" type="submit" class="btn btn-primary">Lọc kết quả</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div id="nhankhautable" class="col-xs-12 loading">

                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>

@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection