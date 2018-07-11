@extends('layouts.masterPage')
@section('css')
    <style type="text/css">
        .test-loading{
            color: red;
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
                        <h4 class="page-title">ĐĂNG KÝ THƯỜNG TRÚ</h4>
                        <ol class="breadcrumb p-0">
                            <li>
                                <a href="/nhan-khau/">Danh sách nhân khẩu</a>
                            </li>
                            <li class="active">
                                Thêm hồ sơ
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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
                <div class="col-xs-12">
                    <div class="card-box">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    {{-- <h4 class="header-title m-t-0 pull-left">Thay đổi chủ hộ</h4> --}}
                                    <h4 class="m-t-0 pull-left"><span class="header-title">HỘ GỐC: {{ $thongtinhoso->hoten }} - {{ $thongtinhoso->hosohokhau_so }} - {{ $thongtinhoso->hokhau_so }} ({{ $thongtinhoso->chitiet_thuongtru }} {{ ($thongtinhoso->idxa_thuongtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $thongtinhoso->idxa_thuongtru)->value('name') : '' }} {{ ($thongtinhoso->idhuyen_thuongtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $thongtinhoso->idhuyen_thuongtru)->value('name') : '' }} {{ ($thongtinhoso->idtinh_thuongtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $thongtinhoso->idtinh_thuongtru)->value('name') : '' }})</span> </h4> 
                                    <div class="btn-group pull-right m-t-15">
                                        {{-- <button type="button" class="btn btn-custom" id="createTab">Thêm nhân khẩu</button> --}}
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <form id="tim-kiem-hoso" action="{{ URL::to('search-ho-so') }}" method="GET" role="form" idresult="nhankhautable">
                                        @csrf
                                        <div class="input-group mb-3">
                                          <input name="keyword" type="text" class="form-control" placeholder="Nhập mã hồ sơ số hoặc hộ khẩu số của hộ chọn nhập">
                                          <div class="input-group-append">
                                            <button id="submitBtn" class="btn btn-default" type="submit"> <i class="fa fa-search"></i> Tìm kiếm hồ sơ</button>
                                          </div>
                                        </div>
                                        <input type="hidden" name="idhogoc" value="{{ $idhoso }}">
                                    </form>
                                </div>

                                <div id="nhankhautable" class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40 loading">

                                </div>
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
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection