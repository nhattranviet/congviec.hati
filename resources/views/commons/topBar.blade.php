<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{ URL::to('/') }}" class="logo">
        {{-- <i class="zmdi zmdi-group-work icon-c-logo"></i> --}}
        <img src="{{ asset('img/mini_logo.png') }}">
        <span>CA HÀ TĨNH</span>
        </a>
    </div>
    <nav class="navbar navbar-custom">
        <ul class="nav navbar-nav">
        <li class="nav-item">
            <button class="button-menu-mobile open-left waves-light waves-effect">
            <i class="zmdi zmdi-menu"></i>
            </button>
        </li>
        <li class="nav-item hidden-mobile">
            <form role="search" class="app-search">
            <input type="text" placeholder="Search..." class="form-control">
            <a href="">
                <i class="fa fa-search"></i>
            </a>
            </form>
        </li>
        </ul>
        <ul class="nav navbar-nav pull-right">
            <li class="nav-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                Chào <b class="text-warning"> {{ (Auth::check()) ? Auth::user()->username : NULL }}!</b>
                </a>
            </li>
            <li class="nav-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <img src="/assets/images/users/avatar-1.jpg" alt="user" class="img-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="text-overflow">
                    {{-- <small>Quyền:<b class="text-default"> {{ Session::get('userinfo')->tennhomquyen }} </b></small> --}}
                    </h5>
                </div>
                <!-- item-->
                <a href="{{ route('can-bo-showinfo') }}" class="dropdown-item notify-item">
                    <i class="zmdi zmdi-settings"></i>
                    <span>Thông tin</span>
                </a>
                <!-- item-->
                <a href="{{ URL::to('logout') }}" class="dropdown-item notify-item">
                    <i class="zmdi zmdi-power"></i>
                    <span>Thoát</span>
                </a>
                </div>
            </li>
            
        </ul>
    </nav>

</div>