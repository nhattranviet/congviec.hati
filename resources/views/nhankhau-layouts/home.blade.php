@extends('layouts.masterPage')

@section('js')
<script src="{{ asset('/assets/plugins/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
@endsection

@section('css')
    <style type="text/css">
        tr {
            padding: 5px;
        }

        .nhat_box_wrap {
            border: 1px solid #eceeef;
        }

        .nhat_box_wrap .nhat_box_head{
            color: gold;
            background-color: #464141;
            max-height: 50px;
            vertical-align: center;
        }

        /* .nhat_box_wrap .nhat_box_head{
            font-size: 1.1em; margin-right: 1.1em;
        } */
        .nhat_box_wrap .nhat_box_head i{
            font-size: 1.1em;
            padding-right: 10px;
            border-right: 1px solid tan;
        }

        .btn-warning {
            color: #fff;
            background-color: #8c7913;
            border-color: #8c7913;
        }

        .nhat_box_tool a i{
            font-size: 1.2em;
        }

        .content-page > .content {
            margin-top: 70px;
            padding: 0px 8px 15px 8px;
        }
        .bg-image{
            padding: 0px;
            margin: 0px;
            height: 125px;
            background-image: url({{ asset('img/banner.jpg') }});
            /* background-repeat: repeat-x; */
        }
        
    </style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row bg-image" >
                <img style="max-width: 100%; height: auto;" src="{{ asset('img/banner.jpg') }}" alt="">
            </div> 
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-xs-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="row nhat_box_wrap m-b-10">

                                <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 nhat_box_head m-b-30">
                                    <h4 class="header-title m-t-0 pull-left"> <i class="zmdi zmdi-apps"></i> <span>thường trú</span></h4>
                                </div>
                                <div style="border-left: 5px solid white;" class="col-xs-6 col-md-6 col-lg-6 col-xl-6 nhat_box_head m-b-30">
                                    <h4 class="header-title m-t-0 pull-left"> <i class="zmdi zmdi-apps"></i> <span>tạm trú</span></h4>
                                </div>
                                <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 m-b-10 nhat_box_tool m-b-30">
                                    <div class="col-xs-6">
                                        <a href="{{ route('nhan-khau.index') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Quản lý hồ sơ hộ khẩu, nhân khẩu"> <i style="font-size: 18px;" class="zmdi zmdi-view-web m-r-5"></i> <span>QUẢN LÝ</span> </a>
                                        <a href="{{ route('nhan-khau.create') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Thêm mới hồ sơ hộ khẩu"> <i style="font-size: 18px;" class="zmdi zmdi-accounts-add m-r-5"></i> <span>HỒ SƠ</span> </a>
                                        <a href="{{ URL::to('bao-cao-nhan-khau') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Tìm kiếm, tra cứu thông tin nhân khẩu"> <i style="font-size: 18px;" class="zmdi zmdi-local-wc m-r-5"></i> <span>LỌC</span> </a>
                                        <a href="{{ route('thong-ke') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Báo cáo nhân hộ khẩu thường trú và tạm trú"> <i style="font-size: 18px;" class="zmdi zmdi-window-restore m-r-5"></i> <span>BÁO CÁO</span> </a>

                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 m-b-10 nhat_box_tool m-b-30">
                                    <div class="col-xs-6">
                                        <a href="{{ route('tam-tru.index') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Quản lý sổ, nhân khẩu tạm trú"> <i style="font-size: 18px;" class="zmdi zmdi-view-web m-r-5"></i> <span>QUẢN LÝ</span> </a>
                                        <a href="{{ route('tam-tru.create') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Thêm mới sổ tạm trú hộ gia đình"> <i style="font-size: 18px;" class="zmdi zmdi-accounts-add m-r-5"></i> <span>SỔ TẠM TRÚ (HỘ)</span> </a>
                                        <a href="{{ route('get-add-so-tam-tru-ca-nhan') }}" style="margin: 0 1.1em 0 1.1em;" class="waves-effect waves-light text-primary" data-toggle="tooltip" data-placement="top" title="Thêm mới sổ tạm trú cá nhân"> <i style="font-size: 18px;" class="zmdi zmdi-accounts-add m-r-5"></i> <span>SỔ TẠM TRÚ (CÁ NHÂN)</span> </a>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="row nhat_box_wrap m-t-10 m-b-10">
                                <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 nhat_box_head m-b-10">
                                    <h4 class="header-title m-t-0 pull-left"> <i class="zmdi zmdi-local-printshop"></i> <span>THỐNG KÊ THƯỜNG TRÚ</span></h4>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3 nhat_box_content">
                                    <div class="card-box tilebox-two">
                                        <i style="color:red;" class="zmdi zmdi-collection-text pull-xs-right"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">HỒ SƠ</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $thuongtru_tongsoho }}</span></h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color: seagreen;" class="fa fa-users pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">NHÂN KHẨU</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $thuongtru_tongnhankhau }}</span></h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color: red;" class="icon-user-female pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">NHÂN KHẨU NỮ</h6>
                                        <h2 class="m-b-10" data-plugin="counterup">{{ $thuongtru_gioitinh_nu }}</h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color:seagreen;" class="fa fa-user-plus pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">NHÂN KHẨU TỪ 14 TUỔI</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $thuongtru_nhankhau_better_14 }}</span></h2>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row nhat_box_wrap m-t-10 m-b-10">
                                <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 nhat_box_head m-b-10">
                                    <h4 class="header-title m-t-0 pull-left"> <i class="zmdi zmdi-collection-text"></i> <span>THỐNG KÊ TẠM TRÚ</span></h4>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3 nhat_box_content">
                                    <div class="card-box tilebox-two">
                                        <i style="color:violet;" class="ion-android-book pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">SỔ TẠM TRÚ</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $tamtru_tongso_ho }}</span></h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color:violet;" class="zmdi zmdi-nature-people pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">SỐ NHÂN KHẨU</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $tamtru_sonhankhau }}</span></h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color: violet;" class="zmdi zmdi-female pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">SỐ NHÂN KHẨU NỮ</h6>
                                        <h2 class="m-b-10" data-plugin="counterup">{{ $tamtru_gioitinhnu }}</h2>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="card-box tilebox-two">
                                        <i style="color:violet;" class="fa fa-user-plus pull-xs-right text-muted"></i>
                                        <h6 class="text-primary text-uppercase m-b-15 m-t-10">NHÂN KHẨU TỪ 14 TUỔI</h6>
                                        <h2 class="m-b-10"><span data-plugin="counterup">{{ $tamtru_nhankhau_better_14 }}</span></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="row nhat_box_wrap m-t-10">
                                <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 nhat_box_head">
                                    <h4 class="header-title m-t-0 pull-left"> <i class="zmdi zmdi-timer"></i> <span>MỚI CẬP NHẬT</span></h4>
                                </div>
                                <div class="col-xs-12 col-lg-12 col-xl-6">
                                    <div class="card-box">
                                        <h4 class="header-title m-t-0">Hồ sơ hộ khẩu</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th>Hồ sơ hộ khẩu số</th>
                                                        <th>Chủ hộ</th>
                                                        <th>Nơi thường trú</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($thuongtru_hosohokhau as $hoso)
                                                        <tr>
                                                            <td>{{ $hoso->hosohokhau_so }}</td>
                                                            <td>{{ $hoso->hoten }}</td>
                                                            <td>{{ DB::table('tbl_xa_phuong_tt')->where('id',$hoso->idxa_thuongtru)->value('name') }}</td>
                                                            <td><a href="/nhan-khau/{{ $hoso->idhoso }}/chi-tiet-ho-khau" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết hồ sơ"> <i style="color: #039cfd;" class="zmdi zmdi-eye"></i> </a></td>
                                                        </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-12 col-xl-6">
                                    <div class="card-box">
                                        <h4 class="header-title m-t-0">Sổ tạm trú</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-b-0">
                                                <thead>
                                                    <tr>
                                                        <th>Sổ tạm trú</th>
                                                        <th>Họ tên</th>
                                                        <th>Nơi thường trú</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tamtru_hosohokhau as $hoso)
                                                        <tr>
                                                            <td>{{ $hoso->sotamtru_so }}</td>
                                                            <td>{{ $hoso->hoten }}</td>
                                                            <td>{{ DB::table('tbl_xa_phuong_tt')->where('id',$hoso->idxa_tamtru)->value('name') }}</td>
                                                            <td><a href=" {{ route('chi-tiet-so-tam-tru', $hoso->idsotamtru) }} " class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Chi tiết hồ sơ"> <i style="color: #039cfd;" class="zmdi zmdi-eye"></i> </a></td>
                                                        </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            
                            
                        </div>
                    </div>

                </div>
                







                    
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
</div>

@endsection
