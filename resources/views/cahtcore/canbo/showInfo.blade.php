@extends('layouts.masterPage')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <div class="card-box"  style="height: 800px;">
                        <div class="col-md-6 col-xs-12 m-t-sm-40">
                            <p>
                                <img style="width: 100%" src="{{ asset('img/user_default.png') }}">
                            </p>
                            <h5 style="text-align: center">

                                {{ $userinfo->hoten }}
                            </h5>
                            <hr>
                            <p><b class="text-danger">{{ $userinfo->tendonvi }}</b></p>
                            
                            <hr>
                            <p>Cấp bậc: <b class="text-danger">{{ $userinfo->tencapbac }}</b></p>
                            <hr>
                            
                            <p>Đội: <b class="text-danger">{{ $userinfo->tendoicongtac }}</b></p>
                            <hr>
                            <p>Chức vụ: <b class="text-danger">{{ $userinfo->tenchucvu }}</b></p>
                            <hr>
                            <p>Nhóm quyền: <b class="text-danger">{{ $userinfo->tennhomquyen }}</b> </p>
                            <hr>
                            <p>Email: <b class="text-danger">{{ $userinfo->email }}</b> </p>
                            <hr>
                            <p>Tên đăng nhập: <b class="text-danger">{{ $userinfo->username }}</b> </p>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="col-xs-9">
                    <div class="card-box" style="height: 800px;">
                        <div class="col-md-6 col-xs-12 m-t-sm-40">

                            <ul class="nav nav-pills m-b-10" id="myTabalt" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#change_password" role="tab" aria-controls="home" aria-expanded="true"><i class="fa fa-lock"></i> Đổi mật khẩu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#user_info" role="tab" aria-controls="profile"><i class="fa fa-info-circle"></i> Thông tin cá nhân</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#user_message" role="tab" aria-controls="profile"><i class="fa fa-envelope"></i> Tin nhắn</a>
                                </li>
                                
                            </ul>
                            <div class="tab-content" id="myTabaltContent">
                                <div role="tabpanel" class="tab-pane fade in active" id="change_password" aria-labelledby="home-tab">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="alert alert-danger" id="error-msg" style="display: none"></div>
                                            <div class="alert alert-success" id="success-msg" style="display: none"></div>
                                        </div>
                                    </div>
                                    <form id="form-nhankhau" action="{{ route('nguoi-dung-changepassword') }}" method="POST" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <fieldset class="form-group">
                                                    <label for="old_password">Mật khẩu cũ <span class="text-danger">*</span></label>
                                                    <input type="password" name="old_password" parsley-trigger="change" class="form-control" id="old_password" value="">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <fieldset class="form-group">
                                                    <label for="password">Mật khẩu mới <span class="text-danger">*</span></label>
                                                    <input type="password" name="password" parsley-trigger="change" class="form-control" id="password" value="">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <fieldset class="form-group">
                                                    <label for="re_password">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                                    <input type="password" name="re_password" parsley-trigger="change" class="form-control" id="re_password" value="">
                                                </fieldset>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Đổi mật khẩu</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="user_info" role="tabpanel" aria-labelledby="profile-tab">
                                    <h5>Chức năng quản lý công viêc:</h5>
                                    <p>
                                        - Cấp Trưởng đơn vị xem tất cả công việc trong đơn vị
                                    </p>
                                    <p>
                                        - Phó đơn vị xem việc ở đội mình phụ trách
                                    </p>
                                    <p>
                                        - Đội trưởng xem các công việc được giao cho các cán bộ trong đội của mình
                                    </p>
                                    <p>
                                        - Cán bộ, đội phó được xem các công việc mình được nhận
                                    </p>
                                    <p>
                                        - Ngoài ra, tất cả mọi người đều có quyền nhập việc, ai nhập việc nào được quyền xem trạng thái công việc đó
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="user_message" role="tabpanel" aria-labelledby="profile-tab">
                                    <p>
                                        Đang cập nhật chức năng message...
                                    </p>
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
