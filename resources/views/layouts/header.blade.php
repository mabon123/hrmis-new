<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('index', app()->getLocale()) }}" class="nav-link">@lang('menu.home')</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('index', app()->getLocale()) }}" class="nav-link">@lang('menu.about_us')</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if ($countStaffsNeedApproval > 0 || $countCPDNeedApproval > 0)
                <span class="badge badge-warning navbar-badge">{{ ($countStaffsNeedApproval + $countCPDNeedApproval) }}</span>
                @endif
            </a>

            @if ($countStaffsNeedApproval > 0 || $countCPDNeedApproval > 0)
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    {{ ($countStaffsNeedApproval + $countCPDNeedApproval) > 1 ? ($countStaffsNeedApproval + $countCPDNeedApproval).' '.__('common.notification_m') : ($countStaffsNeedApproval + $countCPDNeedApproval).' '.__('common.notification_1') }}
                </span>
                @if ($countStaffsNeedApproval > 0)
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.need.approval', app()->getLocale()) }}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> {{ $countStaffsNeedApproval > 1 ? $countStaffsNeedApproval.' '.__('common.notif_profile_m') : $countStaffsNeedApproval.' '.__('common.notif_profile_1') }}
                </a>
                @endif

                @if ($countCPDNeedApproval > 0)
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> {{ $countCPDNeedApproval > 1 ? $countCPDNeedApproval.' '.__('common.notif_cpd_m') : $countCPDNeedApproval.' '.__('common.notif_cpd_1')}}
                </a>
                @endif
            </div>
            @endif
        </li>
        <!-- Manage Leave Request -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('leave-requests.index', app()->getLocale()) }}" title="ស្នើច្បាប់ឈប់សម្រាក">
                <i class="far fa-envelope"></i>
                @if ($countLeaveRequests > 0)
                <span id="span_leave_req" class="badge badge-danger navbar-badge">{{ $countLeaveRequests }}</span>
                @endif
            </a>
        </li>

        <!-- Manage online user registration -->
        @if (auth()->user()->can('view-manage-user-registration'))
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('user.need.approval', app()->getLocale()) }}" title="ស្នើចុះឈ្មោះគណនី">
                <i class="far fa-user"></i>
                @if ($countUsersNeedApproval > 0)
                <span class="badge badge-warning navbar-badge">{{ $countUsersNeedApproval }}</span>
                @endif
            </a>
        </li>
        @endif
        <!-- Manage online user registration poe-->
        @if (Auth::user()->hasRole('poe-admin'))
            @if (auth()->user()->can('view-manage-user-registration'))
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('user.need.approvalpoe', app()->getLocale()) }}" title="ស្នើចុះឈ្មោះគណនី">
                    <i class="fas fa-users"></i>
                    @if ($countUsersNeedApprovalpoe > 0)
                    <span class="badge badge-warning navbar-badge">{{ $countUsersNeedApprovalpoe }}</span>
                    @endif
                </a>
            </li>
            @endif
        @endif    

        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon {{ app()->getLocale()=='kh' ? 'flag-icon-kh' : 'flag-icon-gb' }}"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['language' => 'en'])) }}" class="dropdown-item {{ app()->getLocale()=='en' ? 'active' : '' }}">
                    <i class="flag-icon flag-icon-gb mr-2"></i> English
                </a>
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['language' => 'kh'])) }}" class="dropdown-item {{ app()->getLocale()=='kh' ? 'active' : '' }}">
                    <i class="flag-icon flag-icon-kh mr-2"></i> ខ្មែរ
                </a>
            </div>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="d-none d-md-inline">@lang('menu.welcome'),
                    {{ Auth::check() ? Auth::user()->username : '' }}</span>
                <i class="fas fa-cog"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-default" style="height:200px;">
                    <img src="{{ asset('images/moeys-logo.png') }}" class="img-circle elevation-2" alt="User Image">
                    <p>
                        {{ Auth::check() ? Auth::user()->username.' - '.(Auth::user()->roles[0]->{'role_'.app()->getLocale()}) : '' }}
                        <small>Member since {{ Auth::check() ? date('F j, Y', strtotime(Auth::user()->created_at)) : '' }}</small>
                        <br />
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('staffs.profile', app()->getLocale()) }}" class="btn btn-default btn-flat">@lang('menu.profile')</a>

                    <a href="{{ route('logout', app()->getLocale()) }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('menu.signout')</a>

                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->