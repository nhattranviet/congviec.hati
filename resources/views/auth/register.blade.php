<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>Đăng ký tài khoản</title>

        <!-- App CSS -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>

    </head>


    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">

        	<div class="account-bg">
                <div class="card-box m-b-0">
                    <div class="text-xs-center">
                        <img src="{{ asset('img/medium_logo.png') }}">
                    </div>
                    <div class="text-xs-center m-t-10">
                        <a href="#" style="font-size: 1.5em; color: #1bb99a; font-weight: bold">
                            <span>CÔNG AN HUYỆN KỲ ANH <br> PHẦN MỀM QUẢN LÝ NHÂN KHẨU</span>
                        </a>
                    </div>
                    <div class="m-t-30 m-b-20">
                        <div class="col-xs-12 text-xs-center m-b-10">
                            <h6 class="text-muted text-uppercase m-b-0 m-t-0">ĐĂNG KÝ TÀI KHOẢN</h6>
                        </div>

                        <div class="col-xs-12">
                            @if ($errors->any())
                                <div class="alert alert-danger" id="error-msg">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <div class="alert alert-success" id="success-msg" style="display: none"></div>
                        </div>
                        <form id="form-nhankhaus" action="{{ route('register') }}" class="form-horizontal m-t-20" method="POST" role="form">
                            @csrf
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" value="{{ old('name') }}" name="name" type="text" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" value="{{ old('email') }}" name="email" type="email" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" value="{{ old('username') }}" name="username" type="text" placeholder="Tên đăng nhập">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" value="{{ old('password') }}" name="password" type="password" placeholder="Mật khẩu">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" value="{{ old('password_confirmation') }}" name="password_confirmation" type="password" placeholder="Nhập lại mật khẩu">
                                </div>
                            </div>

                            <div class="form-group text-center m-t-30">
                                <div class="col-xs-12 text-xs-center">
                                    <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Đăng ký</button>
                                    {{-- <button type="submit" class="btn btn-primary">Đăng ký</button> --}}
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <!-- end card-box-->

            <div class="m-t-20">
                <div class="text-xs-center">
                    <p class="text-white">Đã có tài khoản? <a href="{{ route('login') }}" class="text-white m-l-5"><b>Đăng nhập</b> </a></p>
                </div>
            </div>

        </div>
        <!-- end wrapper page -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/js/tether.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/js/detect.js')}}"></script>
        <script src="{{ asset('assets/js/fastclick.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{ asset('assets/js/waves.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ asset('assets/plugins/switchery/switchery.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.app.js')}}"></script>
        <script src="{{ asset('/assets/js/jquery.app.js?v=1.0.0') }}"></script>

    </body>
</html>