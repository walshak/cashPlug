<aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        @if(Auth::check() && Auth::user()->role == 2)
                            <li class="sidebar-item pt-2">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('users.dashboard')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('users.profile')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Profile</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('users.settings')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-cog" aria-hidden="true"></i>
                                    <span class="hide-menu">Settings</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <form action="{{route('logout')}}" method="post" id="logout-form">
                                    @csrf
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:{}"
                                        aria-expanded="false" onclick="document.getElementById('logout-form').submit()">
                                        <i class="fas fa-sign-out-alt text-danger" aria-hidden="true"></i>
                                        <span class="hide-menu">Logout <br> {{Auth::user()->name}}</span>
                                    </a>
                                </form>
                            </li>
                        @elseif (Auth::check() && Auth::user()->role == 1)
                            <li class="sidebar-item pt-2">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.dashboard')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.profile')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Profile</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.settings')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-cog" aria-hidden="true"></i>
                                    <span class="hide-menu">Settings</span>
                                </a>
                            </li>
                            <hr>
                            <span class="text-gray m-3">ADMIN LINKS</span>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.suspend-user-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Suspend user</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.approve-payment-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-pound" aria-hidden="true"></i>
                                    <span class="hide-menu">Approve payment</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <form action="{{route('logout')}}" method="post" id="logout-form">
                                    @csrf
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:{}"
                                        aria-expanded="false" onclick="document.getElementById('logout-form').submit()">
                                        <i class="fas fa-sign-out-alt text-danger" aria-hidden="true"></i>
                                        <span class="hide-menu">Logout <br>{{Auth::user()->name}} [Admin]</span>
                                    </a>
                                </form>
                            </li>
                        @elseif (Auth::check() && Auth::user()->role == 0)
                            <li class="sidebar-item pt-2">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.dashboard')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.profile')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Profile</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.settings')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-cog" aria-hidden="true"></i>
                                    <span class="hide-menu">Settings</span>
                                </a>
                            </li>
                            {{-- admin links --}}
                            <hr>
                            <span class="text-gray m-3">ADMIN LINKS</span>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.suspend-user-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Suspend user</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.approve-payment-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-cog" aria-hidden="true"></i>
                                    <span class="hide-menu">Approve payment</span>
                                </a>
                            </li>
                            <hr>
                            <span class="text-gray m-3">SUPER-ADMIN LINKS</span>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.make-admin-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Make admin</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.make-super-admin-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Make Super-admin</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.suspend-admin-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Suspend admin</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('plan.create')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Create plan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('super-admin.financials-page')}}"
                                    aria-expanded="false">
                                    <i class="fas fa-cog" aria-hidden="true"></i>
                                    <span class="hide-menu">Financials</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <form action="{{route('logout')}}" method="post" id="logout-form">
                                    @csrf
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:{}"
                                        aria-expanded="false" onclick="document.getElementById('logout-form').submit()">
                                        <i class="fas fa-sign-out-alt text-danger" aria-hidden="true"></i>
                                        <span class="hide-menu">Logout <br>{{Auth::user()->name}} [Super Admin]</span>
                                    </a>
                                </form>
                            </li>
                        @endif
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" style="min-height: 250px;">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
