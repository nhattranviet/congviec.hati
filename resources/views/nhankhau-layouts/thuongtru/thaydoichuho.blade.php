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
                    <h4 class="header-title m-t-0 pull-left">Thay đổi chủ hộ</h4>
                </div>
                <div class="col-xs-12">
                    <div class="card-box">
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
                        <form id="form-nhankhau" action="{{ route('thay-doi-chu-ho', $idhoso) }}" method="POST" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Thay đổi chủ hộ</h4>
                                    <div class="btn-group pull-right m-t-15">
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row m-t-20">
                                        @foreach($list_nhankhau as $nhankhau)
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                                <fieldset class="form-group" >
                                                    <label>{{ $nhankhau->hoten }}</label>
                                                    <select name="idquanhechuho[]" class="form-control select2 {{ ($errors->has('idquanhechuho')) ? 'has-danger' : '' }}">
                                                        <option value="">Chọn quan hệ</option>
                                                        @foreach($list_quanhechuho as $quanhechuho)
                                                        <option value="{{ $quanhechuho->id }}"  {{ old('idquanhechuho[]', $nhankhau->idquanhechuho) == $quanhechuho->id ? 'selected' : '' }}>{{ $quanhechuho->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="id_in_sohokhau[]" value="{{ $nhankhau->id }}">
                                                </fieldset>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Thay đổi chủ hộ</button>
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
@endsection