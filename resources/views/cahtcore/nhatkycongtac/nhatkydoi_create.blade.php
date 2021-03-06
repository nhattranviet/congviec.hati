@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/assets/pages/nhatkycanbo.js') }}"></script>
@endsection

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

                        <form id="form-nhankhau" action="{{ route('nhat-ky-cong-tac-doi.store') }}" method="POST" role="form" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 m-t-sm-40 m-t-20 m-b-40"></div>
                                <div class="col-md-8">
                                    <div class="alert alert-danger" id="error-msg" style="display: none"></div>
                                    <div class="alert alert-success" id="success-msg" style="display: none"></div>
                                </div>
                                <div class="col-md-2 m-t-sm-40 m-t-20 m-b-40"></div>
                                <div class="col-md-2 m-t-sm-40 m-t-20 m-b-40"></div>
                                <div class="col-md-8 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Tuần dự kiến<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="tuan" class="form-control input-daterange-datepicker" placeholder="dd-mm-yyyy" value="">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <fieldset class="form-group">
                                                <label for="exampleTextarea">Nội dung dự kiến</label>
                                                <textarea class="form-control ckeditor" name="noidungdukien"></textarea>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2 m-t-sm-40 m-t-20 m-b-40"></div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-md-2 m-t-sm-40 m-t-20 m-b-40">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" name="submit" class="btn btn-primary" value="save"> <i class="fa fa-save"></i> Lưu</button>
                                    <a href="{{ route('nhat-ky-cong-tac-doi.index') }}" class="btn btn-danger waves-effect waves-light pull-right"><span class="btn-label"><i class="fa fa-backward"></i></span>Quay lại</a>
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
