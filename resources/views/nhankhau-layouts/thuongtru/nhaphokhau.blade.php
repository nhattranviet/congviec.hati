@extends('layouts.masterPage')

@section('css')
    <style type="text/css">
        #nhankhaugoc .ms-container{
            max-width: 100% !important;
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
                        <form id="form-nhankhau" action="{{ route('post-nhap-ho-khau', [$idhosogoc, $idhosonhap]) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 m-b-10 text-danger">thông tin hồ sơ lấy theo hộ gốc, hộ nhập sẽ bị xóa</h4>
                                    <div class="btn-group pull-right m-t-15">
                                    </div>
                                </div>
                                @foreach($list_nhankhau as $nhankhau)
                                    <div class="col-md-2 col-xs-12 m-t-sm-40 m-t-20 m-b-10">
                                        <fieldset class="form-group" >
                                            <label>{{ $nhankhau->hoten }}</label>
                                            <select name="idquanhechuho[]" class="form-control select2">
                                                @foreach($list_quanhechuho as $quanhechuho)
                                                <option value="{{ $quanhechuho->id }}" >{{ $quanhechuho->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_in_sohokhau[]" value="{{ $nhankhau->id }}">
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>

                            @foreach($list_nhankhau as $nhankhau)
                                @if($nhankhau->idhoso == $idhosogoc)
                                    <div class="row hokhau-code">
                                        <div class="col-xs-12 col-sm-12 tab-header">
                                            <h4 class="header-title m-t-0 m-b-10">Hộ sơ hộ gốc (hồ sơ giữ lại)</h4>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="hosohokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hosohokhau_so" value="{{ $nhankhau->hosohokhau_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="hokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hokhau_so" value="{{ $nhankhau->hokhau_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="so_dktt_so">Sổ ĐKTT số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="so_dktt_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_so" value="{{ $nhankhau->so_dktt_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="{{ $nhankhau->so_dktt_toso }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input disabled="disabled" value="{{ ($nhankhau->ngaynopluu) ? date('d-m-Y', strtotime($nhankhau->ngaynopluu)) : ''}}" type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    @break
                                @endif
                            @endforeach

                            @foreach($list_nhankhau as $nhankhau)
                                @if($nhankhau->idhoso == $idhosonhap)
                                    <div class="row hokhau-code">
                                        <div class="col-xs-12 col-sm-12 tab-header">
                                            <h4 class="header-title m-t-0 m-b-10">Hộ sơ gộp (hồ sơ sẽ xóa)</h4>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="hosohokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hosohokhau_so" value="{{ $nhankhau->hosohokhau_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                            <fieldset class="form-group">
                                                <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="hokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hokhau_so" value="{{ $nhankhau->hokhau_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="so_dktt_so">Sổ ĐKTT số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="so_dktt_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_so" value="{{ $nhankhau->so_dktt_so }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                                                <input disabled="disabled" type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="{{ $nhankhau->so_dktt_toso }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input disabled="disabled" value="{{ ($nhankhau->ngaynopluu) ? date('d-m-Y', strtotime($nhankhau->ngaynopluu)) : ''}}" type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Nhập hộ khẩu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="chuhos" class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40"></div>

        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>
@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
@endsection