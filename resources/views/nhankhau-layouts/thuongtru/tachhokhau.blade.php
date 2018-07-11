@extends('layouts.masterPage')

@section('css')
    <style type="text/css">
        #nhankhaugoc .ms-container{
            max-width: 100% !important;
        }
    </style>
@endsection


@section('js')
    <script type="text/javascript">
        $(document).ready(function(){

            $('.nhankhaugoc').on('change', function()
            {
                var str = '';
                $("select.nhankhaugoc > option:selected").each(function() {
                    var html_string = '<div class="col-md-3 col-xs-12 m-t-sm-40 m-t-20 m-b-10"> <fieldset class="form-group" > <label>'+this.text+'</label> <select name="idquanhechuho[]" class="form-control select2"> <option value="">Chọn quan hệ với chủ hộ</option> {!! $str_ret !!} </select> <input type="hidden" name="id_in_sohokhau[]" value="'+this.value+'"> <input type="hidden" name="idnhankhau[]" value="'+$(this).attr('idnhankhau')+'"> </fieldset> </div>';
                    str = str + html_string;
                });
                $('#str_ret').html(str);
                $('.select2').select2()
            });

            
            
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
                    <h4 class="header-title m-t-0 pull-left">Tách hộ khẩu</h4>
                </div>
                <div class="col-xs-12">
                    <div class="card-box">
                        <form id="form-nhankhau" action="{{ route('post-tach-ho-khau', $idhoso) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Đăng ký thường trú</h4>
                                    {{-- <h4 class="m-t-0 pull-left"><span class="header-title">HỘ: {{ $thongtinhoso->hoten }} - {{ $thongtinhoso->hosohokhau_so }} - {{ $thongtinhoso->hokhau_so }} ({{ $thongtinhoso->chitiet_thuongtru }} {{ ($thongtinhoso->idxa_thuongtru) ? '-'.DB::table('tbl_xa_phuong_tt')->where('id', $thongtinhoso->idxa_thuongtru)->value('name') : '' }} {{ ($thongtinhoso->idhuyen_thuongtru) ? '-'.DB::table('tbl_huyen_tx')->where('id', $thongtinhoso->idhuyen_thuongtru)->value('name') : '' }} {{ ($thongtinhoso->idtinh_thuongtru) ? '-'.DB::table('tbl_tinh_tp')->where('id', $thongtinhoso->idtinh_thuongtru)->value('name') : '' }})</span> </h4>  --}}
                                    <div class="btn-group pull-right m-t-15">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-10 m-b-10">
                                    <fieldset id="nhankhaugoc" class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                        <label for="hoten">Họ và tên </label>
                                        <select multiple="multiple" class="multi-select nhankhaugoc" id="my_multi_select1" name="nhankhautach[]" data-plugin="multiselect">
                                            @foreach($list_nhankhau as $nhankhau)
                                                <option idnhankhau="{{ $nhankhau->idnhankhau }}" {{ ($nhankhau->idquanhechuho == 1) ? 'disabled="disabled"' : '' }} value="{{ $nhankhau->id }}" >{{ $nhankhau->hoten }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-12 col-xs-12 m-t-sm-40">
                                    <h4 class="header-title m-t-0">THIẾT LẬP QUAN HỆ CHO SỔ HỘ KHẨU MỚI</h4>
                                    <div class="row" id="str_ret"></div>
                                </div>
                            </div>

                            <div class="row hokhau-code">
                                <div class="col-xs-12 col-sm-12 tab-header">
                                    <h4 class="header-title m-t-0 m-b-10">THÔNG TIN HỒ SƠ HỘ KHẨU MỚI</h4>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="hosohokhau_so">Hồ sơ hộ khẩu số <span class="text-danger">*</span></label>
                                        <input type="text" name="hosohokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hosohokhau_so" value="@if(isset($brief)){{$brief->hosohokhau_so}} @endif">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                        <input type="text" name="hokhau_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="hokhau_so" value="@if(isset($brief)){{$brief->hokhau_so}} @endif">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="so_dktt_so">Sổ ĐKTT số <span class="text-danger">*</span></label>
                                        <input type="text" name="so_dktt_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_so" value="@if(isset($brief)) {{ $brief->so_dktt_so}} @endif">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                                        <input type="text" name="so_dktt_toso" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="so_dktt_toso" value="@if(isset($brief)) {{ $brief->so_dktt_so}} @endif">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                    <fieldset class="form-group">
                                        <label for="datepicker">Ngày tách <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="input-group">
                                                <input type="text" name="date_action" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Tách hồ sơ</button>
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