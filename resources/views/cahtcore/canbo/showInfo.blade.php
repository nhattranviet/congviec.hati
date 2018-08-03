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
                                    <form id="form-user" action="{{ route('can-bo-selfUpdate', $userinfo->idcanbo) }}" method="POST" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <label for="hoten">Họ và tên
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="hoten" parsley-trigger="change" placeholder="Họ và tên" class="form-control" id="hoten" value="{{ $userinfo->hoten }}">
                                                </fieldset>

                                                <fieldset class="form-group" >
                                                    <label>Chức vụ<span class="text-danger">*</span></label>
                                                    <select name="idchucvu" class="form-control select2  {{ ($errors->has('idchucvu')) ? 'has-danger' : '' }}">
                                                        <option value="">Chọn chức vụ</option>
                                                        @foreach($list_chucvu as $chucvu)
                                                            <option {{ ($userinfo->idchucvu == $chucvu->id ? 'selected' : NULL) }} value="{{ $chucvu->id }}" >{{ $chucvu->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>

                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-group" >
                                                    <label>Cấp bậc<span class="text-danger">*</span></label>
                                                    <select name="idcapbac" class="form-control select2  {{ ($errors->has('idcapbac')) ? 'has-danger' : '' }}">
                                                        <option value="">Chọn cấp bậc</option>
                                                        @foreach($list_capbac as $capbac)
                                                            <option {{ ($userinfo->idcapbac == $capbac->id ? 'selected' : NULL) }} value="{{ $capbac->id }}" >{{ $capbac->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                                <button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Cập nhật</button>
                                            </div>
                                        </div>
                                    </form>
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
