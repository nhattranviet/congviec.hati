@extends('layouts.masterPage')

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection

@section('css')
    <style type="text/css">
        tr {
            padding: 5px;
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

                        <form id="tim-kiem-hoso" action="{{ route('get-thong-ke-nhan-khau') }}" idresult="nhankhautable" method="GET" role="form">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Thông tin nhân khẩu</h4>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row hokhau-code">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Báo cáo từ ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Báo cáo đến ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <h5>Không cư trú tại địa phương</h5>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_ho">Tổng số hộ <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_ho" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_ho" value="">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhau">Tổng số nhân khẩu <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhau" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhau" value="">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhauthanhthi">Nhân khẩu thành thị <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhauthanhthi" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhauthanhthi" value="">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhaunu">Nhân khẩu nữ <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhaunu" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhaunu" value="">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhautu14">Nhân khẩu từ 14 tuổi <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhautu14" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhautu14" value="">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button id="submitBtns" type="submit" class="btn btn-primary">Báo cáo</button>
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