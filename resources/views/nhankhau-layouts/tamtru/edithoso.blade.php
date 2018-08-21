@extends('layouts.masterPage')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Sửa hồ sơ</h4>
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
                        <form id="form-nhankhau" action="{{ route('tam-tru.update', $sotamtru->id) }}" method="POST" role="form">
                            {{ method_field('PUT') }}
                            @csrf
                            <input type="hidden" name="idsotamtru" value="{{ $sotamtru->id }}">
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
                                                            <label for="sotamtru_so">Sổ tạm trú số <span class="text-danger">*</span></label>
                                                            <input type="text" name="sotamtru_so" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="sotamtru_so" value="{{ old('sotamtru_so', $sotamtru->sotamtru_so) }}">
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

                                                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-7">
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
                            <div class="row">
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