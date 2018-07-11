@extends('layouts.masterPage')

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
                    <h4 class="header-title m-t-0 pull-left">Sửa thông tin hồ sơ</h4>
                </div>
                <div class="col-xs-12">
                    <div class="card-box">
                        @if ($errors->any())
                            <p>
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                    @foreach ($errors->all() as $error)
                                        <p> {{ $error }} </p>
                                    @endforeach
                                    
                                </div>
                            </p>
                        @endif
                        <form id="form-nhankhau" action="{{ route('nhankhau.update', $hoso->id) }}" method="POST" role="form">
                            {{ method_field('PUT') }}
                            @csrf
                            <input type="hidden" name="idhoso" value="{{ $hoso->id }}">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
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
                                                            <input type="text" name="hosohokhau_so" parsley-trigger="change" class="form-control" id="hosohokhau_so" value="{{ old('hosohokhau_so', $hoso->hosohokhau_so) }}">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="hokhau_so">Hộ khẩu số <span class="text-danger">*</span></label>
                                                            <input type="text" name="hokhau_so" parsley-trigger="change" class="form-control" id="hokhau_so" value="{{ old('hokhau_so', $hoso->hokhau_so) }}">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                                                        <fieldset class="form-group">
                                                            <label for="so_dktt_so">Sổ ĐKTT số <span class="text-danger">*</span></label>
                                                            <input type="text" name="so_dktt_so" parsley-trigger="change" class="form-control" id="so_dktt_so" value="{{ old('so_dktt_so', $hoso->so_dktt_so) }}">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-1">
                                                        <fieldset class="form-group">
                                                            <label for="so_dktt_toso">Tờ số <span class="text-danger">*</span></label>
                                                            <input type="text" name="so_dktt_toso" parsley-trigger="change" class="form-control" id="so_dktt_toso" value="{{ old('so_dktt_toso', $hoso->so_dktt_toso) }}">
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày nộp lưu <span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input value="{{ old('datetime', ($hoso->ngaynopluu) ? date('d-m-Y', strtotime($hoso->ngaynopluu)) : '' ) }}" type="text" name="datetime" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                        <fieldset class="form-group">
                                                            <label for="datepicker">Ngày sửa<span class="text-danger">*</span></label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input value="{{ old('date_action') }}" type="text" name="date_action" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                                    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                                </div><!-- input-group -->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-10">
                                                        <fieldset class="form-group">
                                                            <label for="hokhau_so">Ghi chú/Lý do sửa<span class="text-danger">*</span></label>
                                                            <input type="text" name="ghichu" parsley-trigger="change" class="form-control" id="ghichu" value="{{ old('ghichu') }}">
                                                        </fieldset>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-50">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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

@endsection

@section('js')
<script src="{{ asset('/assets/pages/jquery.addr-pickers.init.js') }}?v=1.0.2"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#picker > #addressPickerGroup').each(function() {

            var inputs = $(this).find('input[type=hidden]').toArray();

            var binding = {
                country: 'Việt Nam', province: '', district: '', ward: '', addressDetail: $('#'+inputs[4].id).val()
            };

            var arrData = [];

            var el = $(this);


// Get province or citie
getProvinces($('#'+inputs[0].id).val(), null,function(data) {

    for (var i = 0; i < data.length; i++) {

        if (data[i].id == $('#'+inputs[1].id).val()) {

            binding.province = data[i].name;
            arrData[0] = binding;
            loadAddress(el, arrData[0]);

            break;

        }
    }
});

// Get district
getDistricts($('#'+inputs[1].id).val(), null,function(data) {

    for (var i = 0; i < data.length; i++) {

        if (data[i].id == $('#'+inputs[2].id).val()) {

            binding.district = data[i].name;
            arrData[1] = binding;
            loadAddress(el, arrData[1]);
            break;
        }
    }
});

// Get ward
getWards($('#'+inputs[2].id).val(), null,function(data) {

    for (var i = 0; i < data.length; i++) {

        if (data[i].id == $('#'+inputs[3].id).val()) {

            binding.ward = data[i].name;
            arrData[2] = binding;
            loadAddress(el, arrData[2]);
            break;
        }
    }
});

});
    });
</script>
@endsection