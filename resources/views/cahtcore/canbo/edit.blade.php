@extends('layouts.masterPage')

@section('css')
    <style type="text/css">
        .has-danger ~ .select2 .select2-selection {
          border: 1px solid #ff5d48;
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
                        <h4 class="page-title"> {{ $page_title }} </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row" style="height: 100%">
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="form-nhankhau" action="{{ route('can-bo.update', $canbo_info->idcanbo) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-4">
                                </div>
                                <div class="col-xs-4">
                                    <div class="alert alert-danger" id="error-msg" style="display: none">
                                    </div>
                                    <div class="alert alert-success" id="success-msg" style="display: none">
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-4">
                                    
                                    <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                        <label for="hoten">Họ tên<span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $canbo_info->hoten }}" name="hoten" parsley-trigger="change" placeholder="Nhập họ tên" class="form-control" id="hoten">
                                    </fieldset>

                                    <fieldset class="form-group {{ ($errors->has('hoten')) ? 'has-danger' : '' }}">
                                        <label for="email">Email<span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $canbo_info->email }}" name="email" parsley-trigger="change" placeholder="Nhập họ email" class="form-control" id="email">
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Đơn vị<span class="text-danger">*</span></label>
                                        <select id="donvi" name="iddonvi" class="form-control select2  {{ ($errors->has('donvi')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn đơn vị</option>
                                            @foreach($list_donvi as $donvi)
                                                <option {{ ($donvi->id == $canbo_info->iddonvi) ? 'selected' : NULL }} value="{{ $donvi->id }}" >{{ $donvi->name }} ({{ $donvi->kyhieu }})</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    
                                    <fieldset class="form-group" >
                                        <label>Đội<span class="text-danger">*</span></label>
                                        <select name="id_iddonvi_iddoi" class="doicongtac form-control select2  {{ ($errors->has('id_iddonvi_iddoi')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn đội công tác</option>
                                            @foreach($list_doicongtac as $doicongtac)
                                                <option {{ ($doicongtac->id == $canbo_info->id_iddonvi_iddoi) ? 'selected' : NULL }} value="{{ $doicongtac->id }}" >{{ $doicongtac->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Cấp bậc<span class="text-danger">*</span></label>
                                        <select name="idcapbac" class="form-control select2  {{ ($errors->has('idcapbac')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn cấp bậc</option>
                                            @foreach($list_capbac as $capbac)
                                                <option {{ ($capbac->id == $canbo_info->idcapbac) ? 'selected' : NULL }} value="{{ $capbac->id }}" >{{ $capbac->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Chức vụ<span class="text-danger">*</span></label>
                                        <select name="idchucvu" class="form-control select2  {{ ($errors->has('idchucvu')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn chức vụ</option>
                                            @foreach($list_chucvu as $chucvu)
                                                <option {{ ($chucvu->id == $canbo_info->idchucvu) ? 'selected' : NULL }} value="{{ $chucvu->id }}">{{ $chucvu->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group" >
                                        <label>Quyền tài khoản<span class="text-danger">*</span></label>
                                        <select name="idnhomquyen" class="form-control select2  {{ ($errors->has('idnhomquyen')) ? 'has-danger' : '' }}">
                                            <option value="">Chọn nhóm quyền</option>
                                            @foreach($list_nhomquyen as $nhomquyen)
                                                <option {{ ($nhomquyen->id == $canbo_info->idnhomquyen) ? 'selected' : NULL }} value="{{ $nhomquyen->id }}">{{ $nhomquyen->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label class="control-label">Quản lý đội (đối với lãnh đạo đơn vị)</label>
                                        <select multiple="multiple" name="quanlydoi[]" class="doicongtac form-control select2">
                                            <option value="">Chọn đội công tác</option>
                                            @foreach($list_doicongtac as $doicongtac)
                                                <option {{ ( in_array( $doicongtac->id, $list_doiquanly ) )  ? 'selected' : NULL}} value="{{ $doicongtac->id }}" >{{ $doicongtac->name }}</option>
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