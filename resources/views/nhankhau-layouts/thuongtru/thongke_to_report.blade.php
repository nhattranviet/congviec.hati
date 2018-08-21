@extends('layouts.masterPage')

@section('js')
    <script src="{{ asset('/js/FileSaver.js') }}"></script>
    <script src="{{ asset('/js/jquery.wordexport.js') }}"></script>
    <script type="text/javascript">
        // jQuery(document).ready(function ($) {
        //     $("a.word-export").click(function (event) {
        //         alert('test');
        //         $("#page-content").wordExport();
        //     });
            
        // });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // var config = {};
            // config.entities_latin = false
            // $('.ckeditor').ckeditor(config);
            // alert('test');
            $(document).on("click", "#exportToWord", function(event){
                event.preventDefault();
                $("#page-content").wordExport();
            })

            

        });

    </script>
@endsection

@section('css')
    <style type="text/css">
        tr {
            padding: 5px;
        }
        @page {
                    mso-page-orientation: landscape;
                    size: 841.95pt 595.35pt; /* EU A4 */
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
                        <h4 class="page-title">Báo cáo theo mẫu HK15</h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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

                        <form id="tim-kiem-hoso" action="{{ route('get-thong-ke-nhan-khau') }}" idresult="nhankhautable" method="GET" role="form">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 class="header-title m-t-0 pull-left">Thống kê</h4>
                                </div>
                                <div class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">
                                    <div class="row hokhau-code">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Báo cáo từ ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="tungay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="datepicker">Báo cáo đến ngày</label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="denngay" class="form-control" placeholder="dd-mm-yyyy" id="datepicker">
                                                        <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                            <h5>Không cư trú tại địa phương</h5>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_ho">Tổng số hộ <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_ho" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_ho" value="0">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhau">Tổng số nhân khẩu <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhau" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhau" value="0">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhauthanhthi">Nhân khẩu thành thị <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhauthanhthi" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhauthanhthi" value="0">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhaunu">Nhân khẩu nữ <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhaunu" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhaunu" value="0">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-2">
                                            <fieldset class="form-group">
                                                <label for="khongcutru_nhankhautu14">Nhân khẩu từ 14 tuổi <span class="text-danger">*</span></label>
                                                <input type="text" name="khongcutru_nhankhautu14" parsley-trigger="change" placeholder="Nhập số" class="form-control" id="khongcutru_nhankhautu14" value="0">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-xs-12 col-sm-12">
                                    <button id="submitBtns" type="submit" class="btn btn-primary">Báo cáo</button>
                                    <button id="exportToWord" class="btn btn-primary"> <i class="fa fa-file-word-o"></i> Export</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div id="nhankhautable" class="col-xs-12 loading WordSection1">

                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>

@endsection