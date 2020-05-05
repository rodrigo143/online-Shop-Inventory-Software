<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            @if(Auth::check() && Auth::user()->role->id == 1)
                <ul class="metismenu" id="side-menu">
                <li class="menu-title">Navigation</li>
                <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                    <a href="{{route('admin.dashboard')}}" class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                        <i class="fe-airplay"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fe-package"></i>
                        <span> Store </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ (request()->is('admin/product')) ? 'active' : '' }}">
                            <a href="{{url('admin/product ')}}" class="{{ (request()->is('admin/product')) ? 'active' : '' }}">Products</a>
                        </li>
                        <li class="{{ (request()->is('admin/store')) ? 'active' : '' }}">
                            <a href="{{url('admin/store ')}}" class="{{ (request()->is('admin/store')) ? 'active' : '' }}">Store</a>
                        </li>
                        <li >
                            <a href="{{url('admin/purchase ')}}" class="{{ (request()->is('admin/purchase')) ? 'active' : '' }}">Purchase</a>
                        </li>
                        <li>
                            <a href="{{url('admin/stock ')}}" class="{{ (request()->is('admin/stock')) ? 'active' : '' }}">Stock</a>
                        </li>
                        <li>
                            <a href="{{url('admin/supplier ')}}" class="{{ (request()->is('admin/supplier')) ? 'active' : '' }}">Supplier</a>
                        </li>
                        <li>
                            <a href="{{url('admin/payment ')}}" class="{{ (request()->is('admin/payment')) ? 'active' : '' }}">Payment</a>
                        </li>
                        <li>
                            <a href="{{url('admin/payment/type ')}}" class="{{ (request()->is('admin/payment/type')) ? 'active' : '' }}">Payment Method</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fe-truck"></i>
                        <span> Courier </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ (request()->is('admin/courier')) ? 'active' : '' }}">
                            <a href="{{url('admin/courier ')}}" class="{{ (request()->is('admin/courier')) ? 'active' : '' }}">Courier</a>
                        </li>
                        <li class="{{ (request()->is('admin/city')) ? 'active' : '' }}">
                            <a href="{{url('admin/city ')}}" class="{{ (request()->is('admin/city')) ? 'active' : '' }}">City</a>
                        </li>
                        <li class="{{ (request()->is('admin/zone')) ? 'active' : '' }}">
                            <a href="{{url('admin/zone ')}}" class="{{ (request()->is('admin/zone')) ? 'active' : '' }}">Zone</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ (request()->routeIs('admin/order')) ? 'active' : '' }}">
                    <a href="{{url('admin/order/status/Processing ')}}" class="{{ (request()->is('admin/order')) ? 'active' : '' }}">
                        <i class="fe-shopping-cart"></i>
                        <span> Order </span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/order/Pending Invoiced')) ? 'active' : '' }}">
                    <a href="{{url('admin/order/status/Pending Invoiced ')}}" class="{{ (request()->is('admin/order/status/Pending Invoiced')) ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span> Invoiced </span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/order/Delivered')) ? 'active' : '' }}">
                    <a href="{{url('admin/order/status/Delivered ')}}" class="{{ (request()->is('admin/order/status/Delivered')) ? 'active' : '' }}">
                        <i class="mdi mdi-truck-check"></i>
                        <span> Delivered </span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/user')) ? 'active' : '' }}">
                    <a href="{{url('admin/user ')}}" class="{{ (request()->is('admin/user')) ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span> User </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fe-truck"></i>
                        <span> Report </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ (request()->is('admin/report/dateCourierUser')) ? 'active' : '' }}">
                            <a href="{{url('admin/report/dateCourierUser ')}}" class="{{ (request()->is('admin/report/dateCourierUser')) ? 'active' : '' }}">Single Date Courier User Report</a>
                        </li>
                        <li class="{{ (request()->is('admin/report/multipleDateCourierUser')) ? 'active' : '' }}">
                            <a href="{{url('admin/report/multipleDateCourierUser ')}}" class="{{ (request()->is('admin/report/multipleDateCourierUser')) ? 'active' : '' }}">Multiple Date Courier User Report</a>
                        </li>
                        <li class="{{ (request()->is('admin/report/dateCourier')) ? 'active' : '' }}">
                            <a href="{{url('admin/report/dateCourier ')}}" class="{{ (request()->is('admin/report/dateCourier')) ? 'active' : '' }}">Date wise Courier Report</a>
                        </li>
                        <li class="{{ (request()->is('admin/report/dateUser')) ? 'active' : '' }}">
                            <a href="{{url('admin/report/dateUser ')}}" class="{{ (request()->is('admin/report/dateUser')) ? 'active' : '' }}">Date wise user Report</a>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
            @if(Auth::check() && Auth::user()->role->id == 2)
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Navigation</li>
                    <li class="{{ (request()->is('user/dashboard')) ? 'active' : '' }}">
                        <a href="{{route('user.dashboard')}}" class="{{ (request()->is('user/dashboard')) ? 'active' : '' }}">
                            <i class="fe-airplay"></i>
                            <span> Dashboards </span>
                        </a>
                    </li>
                    <li class="{{ (request()->routeIs('user/order')) ? 'active' : '' }}">
                        <a href="{{url('user/order/status/Processing ')}}" class="{{ (request()->is('user/order')) ? 'active' : '' }}">
                            <i class="fe-shopping-cart"></i>
                            <span> Order </span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('user/order/Pending Invoiced')) ? 'active' : '' }}">
                        <a href="{{url('user/order/status/Pending Invoiced ')}}" class="{{ (request()->is('user/order/status/Pending Invoiced')) ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i>
                            <span> Invoiced </span>
                        </a>
                    </li>
                    <li class="{{ (request()->is('user/order/Delivered')) ? 'active' : '' }}">
                        <a href="{{url('user/order/status/Delivered ')}}" class="{{ (request()->is('user/order/status/Delivered')) ? 'active' : '' }}">
                            <i class="mdi mdi-truck-check"></i>
                            <span> Delivered </span>
                        </a>
                    </li>
                </ul>
            @endif



        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
