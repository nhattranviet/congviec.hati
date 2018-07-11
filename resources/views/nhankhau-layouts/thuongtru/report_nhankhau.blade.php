@extends('layouts.masterPage')

@section('js')
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $.ajax({
                url: $('#tim-kiem-hoso').attr('action')+'?page='+page,
                type: 'GET',
                data: $('#tim-kiem-hoso').serialize(),
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: function(data) {
                  if ($.isEmptyObject(data.error)) {
                    $('#nhankhautable').html(data);
                  }
                  else
                  {
                    printMsg('#error-msg', data.error[0]);
                  }
                  window.scrollTo(0,0);
                },
                error: function (data)
                {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        console.log(data.responseText);
                    });
                }
              })
            });
        });
    </script> -->
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
                <form id="tim-kiem-hoso" action="{{ URL::to('post-bao-cao-nhan-khau') }}" method="GET" role="form">
                    @csrf
                    
                </form>
                
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                    <div class="col-xs-12 col-sm-12">
                        <h4 class="header-title m-t-0 pull-left">Thay đổi chủ hộ</h4>
                        <div class="btn-group pull-right m-t-15">
                            {{-- <button type="button" class="btn btn-custom" id="createTab">Thêm nhân khẩu</button> --}}
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-3">
                        <form id="tim-kiem-hoso" action="{{ URL::to('post-bao-cao-nhan-khau') }}" method="GET" role="form">
                            @csrf
                            <div class="input-group m-b-3">
                              <input name="keyword" type="text" class="form-control" placeholder="Nhập mã hồ sơ số hoặc hộ khẩu số của hộ chọn nhập">
                              <div class="input-group-append">
                                <button id="submitBtn" class="btn btn-default" type="submit"> <i class="fa fa-search"></i> Tìm kiếm hồ sơ</button>
                              </div>
                            </div>
                            {{-- <input type="hidden" name="idhogoc" value="{{ $idhoso }}"> --}}
                        </form>
                    </div>

                    <div id="nhankhautable" class="col-md-12 col-xs-12 m-t-sm-40 m-t-20 m-b-40">

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