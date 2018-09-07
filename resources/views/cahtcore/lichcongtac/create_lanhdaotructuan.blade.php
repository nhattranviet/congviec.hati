@extends('layouts.masterPage')
@section('css')
    <link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- end row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{ $page_name }}</h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box">

                        <form id="form-nhankhau" action="{{ route('lich-cong-tac.store_lanhdaotructuan',$iddonvi) }}" method="POST" role="form" autocomplete="off">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="alert alert-danger" id="error-msg" style="display: none"></div>
                                    <div class="alert alert-success" id="success-msg" style="display: none"></div>
                                </div>

                                <div class="col-md-12 m-t-sm-40 m-t-20 m-b-40">
                                    <fieldset class="form-group">
                                        <label for="datepicker">Chọn tuần<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="tuan" class="form-control input-daterange-datepicker" placeholder="dd-mm-yyyy" value="">
                                                <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                            </div><!-- input-group -->
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="datepicker">Lãnh đạo trực<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select name="idlanhdaotruc" class="form-control select2" style="width: 100%;">
                                                    <option value=""> Chọn lãnh đạo trực </option>
                                                    @foreach ($list_lanhdao as $lanhdao)
                                                        <option value="{{ $lanhdao->id }}"> {{ $lanhdao->hoten.' ('.$lanhdao->tenchucvu.')' }} </option>
                                                    @endforeach
                                                </select>
                                            </div><!-- input-group -->
                                    </fieldset>
                                </div>
                                
                            </div>
                            <div class="row m-t-10">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" class="btn btn-primary" value="save"> <i class="fa fa-save"></i> Lưu</button>
                                    <a href="{{ route('lich-cong-tac.index', $iddonvi) }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
                                </div>
                            </div>
                            {{ csrf_field() }}
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
