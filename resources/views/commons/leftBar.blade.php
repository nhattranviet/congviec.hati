<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">Navigation</li>

                <li class="has_sub">
                    <a href="{{ URL::to('/') }}" class="waves-effect">
                        <span class="label label-pill label-primary pull-xs-right">1</span>
                        <i class="zmdi zmdi-view-dashboard"></i>
                        <span> Bảng điều khiển </span>
                    </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="zmdi zmdi zmdi-pin-account"></i>
                        <span> Thường trú </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('nhan-khau.index') }}">Quản lý hồ sơ</a>
                        </li>
                        <li>
                            <a href="{{ route('nhan-khau.create') }}">Nhập hồ sơ</a>
                        </li>
                        <li>
                            <a href="{{ route('thong-ke') }}">Báo cáo</a>
                        </li>

                        <li>
                            <a href="{{ route('get-bao-cao-nhan-khau') }}">Tìm kiếm và tra cứu</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="zmdi zmdi-nature-people"></i>
                        <span> Tạm trú </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('tam-tru.index') }}">Quản lý hồ sơ</a>
                        </li>
                        <li>
                            <a href="{{ route('tam-tru.create') }}">Nhập sổ tạm trú hộ gia đình</a>
                        </li>
                        <li>
                            <a href="{{ route('get-add-so-tam-tru-ca-nhan') }}">Nhập sổ tạm trú cá nhân</a>
                        </li>
                        <li>
                            <a href="{{ route('check-qua-han') }}">Kiểm tra quá hạn tạm trú</a>
                        </li>
                        
                    </ul>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
</div>