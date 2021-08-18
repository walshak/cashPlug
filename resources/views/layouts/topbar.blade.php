<header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="{{url('/')}}">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="{{asset('plugins/images/logo-icon.png')}}" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        {{-- <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{asset('plugins/images/logo-text.png')}}" alt="homepage" />
                        </span> --}}
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        @if (Auth::check())
                            <li>
                                @if (Auth::user()->role == 2)
                                    <a class="profile-pic" href="{{route('users.profile')}}">
                                        {{-- <img src="plugins/images/users/varun.jpg" alt="user-img" width="36"
                                            class="img-circle">--}}
                                            <span class="text-white font-medium">{{Auth::user()->name}}</span>
                                    </a>
                                @elseif (Auth::user()->role == 1)
                                    <a class="profile-pic" href="{{route('admin.profile')}}">
                                        {{-- <img src="plugins/images/users/varun.jpg" alt="user-img" width="36"
                                            class="img-circle">--}}
                                            <span class="text-white font-medium">{{Auth::user()->name}} [Admin]</span>
                                    </a>
                                @elseif (Auth::user()->role == 0)
                                    <a class="profile-pic" href="{{route('super-admin.profile')}}">
                                        {{-- <img src="plugins/images/users/varun.jpg" alt="user-img" width="36"
                                            class="img-circle">--}}
                                            <span class="text-white font-medium">{{Auth::user()->name}} [Super Admin]</span>
                                    </a>
                                @endif
                            </li>
                            <li>
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-warning m-1">Logout</button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a href="{{route('login')}}" class="btn btn-warning m-1">Login</a>
                            </li>

                            <li>
                                <a href="{{route('register')}}" class="btn btn-primary m-1">Register</a>
                            </li>
                        @endif
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
