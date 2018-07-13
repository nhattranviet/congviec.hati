@extends('layouts.masterPage')

@section('css_code')
    <style type="text/css">
        .has-danger ~ .select2 .select2-selection {
          border: 1px solid #ff5d48;
        }
    </style>
@endsection

@section('js_code')
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#donvi" ).on( 'change', function() {
                var donvi = $('#donvi').val();
                if(donvi)
                {

                    $.get('/getDoi/' + donvi, function (data) {
                        //success data
                        $('#doicongtac').empty();
                        $('#doicongtac').html(data);
                    })
                    
                }
            });

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
                    <div class="page-title-box">
                        <h4 class="page-title"> {{ $page_title }} </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row" style="height: 100%">
                <div class="col-xs-12">
                    <div class="card-box">

                        <form action="{{ route('can-bo.store') }}" method="POST" role="form">
                            @csrf
                            <div class="row m-t-20">
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                    @if ($errors->any())
                                        <p>
                                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                @foreach ($errors->all() as $error)
                                                    <p> {{ $error }} </p>
                                                @endforeach
                                                
                                            </div>
                                        </p>
                                    @endif
                                    
                                    <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                        <label for="hoten">Họ tên<span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('hoten') }}" name="hoten" parsley-trigger="change" placeholder="Nhập họ tên" class="form-control" id="hoten">
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Đơn vị<span class="text-danger">*</span></label>
                                        <select id="donvi" name="iddonvi" class="form-control select2  {{ ($errors->has('donvi')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn đơn vị</option>
                                            @foreach($list_donvi as $donvi)
                                                <option value="{{ $donvi->id }}"  {{ old('iddonvi') == $donvi->id ? 'selected' : '' }}>{{ $donvi->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    
                                    <fieldset class="form-group" >
                                        <label>Đội<span class="text-danger">*</span></label>
                                        <select id="doicongtac" name="id_iddonvi_iddoi" class="form-control select2  {{ ($errors->has('id_iddonvi_iddoi')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn đội công tác</option>
                                        </select>
                                    </fieldset>
                                    

                                    <fieldset class="form-group" >
                                        <label>Cấp bậc<span class="text-danger">*</span></label>
                                        <select name="idcapbac" class="form-control select2  {{ ($errors->has('idcapbac')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn cấp bậc</option>
                                            @foreach($list_capbac as $capbac)
                                                <option value="{{ $capbac->id }}"  {{ old('idcapbac') == $capbac->id ? 'selected' : '' }}>{{ $capbac->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Chức vụ<span class="text-danger">*</span></label>
                                        <select name="idchucvu" class="form-control select2  {{ ($errors->has('idchucvu')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn chức vụ</option>
                                            @foreach($list_chucvu as $chucvu)
                                                <option value="{{ $chucvu->id }}"  {{ old('idchucvu') == $chucvu->id ? 'selected' : '' }}>{{ $chucvu->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Quyền tài khoản<span class="text-danger">*</span></label>
                                        <select name="idnhomquyen" class="form-control select2  {{ ($errors->has('idnhomquyen')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn nhóm quyền</option>
                                            @foreach($list_nhomquyen as $nhomquyen)
                                                <option value="{{ $nhomquyen->id }}"  {{ old('idnhomquyen') == $nhomquyen->id ? 'selected' : '' }}>{{ $nhomquyen->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <div class="checkbox checkbox-primary">
                                            <input name="active" value="1" type="checkbox">
                                            <label for="checkbox21">
                                                Kích hoạt tài khoản
                                            </label>
                                        </div>
                                    </fieldset>


                                    <button type="submit" class="btn btn-primary">Thêm cán bộ</button>
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