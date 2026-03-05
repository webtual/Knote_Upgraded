<div class="navbar-custom">
<ul class="list-unstyled topnav-menu float-right mb-0">

    {{-- 
        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li> 
    --}}

    <li class="dropdown notification-list">
        {{--
            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
    			<div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                        </span>Notification
                    </h5>
                </div>
    
                <div class="slimscroll noti-scroll">
    				<a href="javascript:void(0);" class="dropdown-item notify-item active">
                        <div class="notify-icon">
                            <img src="{{ asset('storage/'.Auth::user()->avtar) }}" class="img-fluid rounded-circle" alt="" /> </div>
                        <p class="notify-details">Cristina Pride</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Hi, How are you? What about our next meeting</small>
                        </p>
                    </a>
    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">1 min ago</small>
                        </p>
                    </a>
    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon">
                            <img src="{{ asset('storage/'.Auth::user()->avtar) }}" class="img-fluid rounded-circle" alt="" /> </div>
                        <p class="notify-details">Karen Robinson</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Wow ! this admin looks good and awesome design</small>
                        </p>
                    </a>
    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-warning">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <p class="notify-details">New user registered.
                            <small class="text-muted">5 hours ago</small>
                        </p>
                    </a>
    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">4 days ago</small>
                        </p>
                    </a>
    
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-secondary">
                            <i class="mdi mdi-heart"></i>
                        </div>
                        <p class="notify-details">Carlos Crouch liked
                            <b>Admin</b>
                            <small class="text-muted">13 days ago</small>
                        </p>
                    </a>
                </div>
    			<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fi-arrow-right"></i>
                </a>
    
            </div>
        --}}
    </li>
	
	@if(Auth::user()->roles()->first()->slug != 'loan-applicant')
	
	<li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="{{ asset('storage/'.Auth::user()->avtar) }}" alt="user-image" class="rounded-circle user-avtar">
            <span class="pro-user-name ml-1">
                {{ ucfirst(Auth::user()->name) }} - {{ ucfirst(Auth::user()->roles()->first()->role_name) }}  <i class="mdi mdi-chevron-down"></i> 
            </span>
        </a>
    
        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
            <!-- item-->
            <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome {{ ucfirst(Auth::user()->name) }} !</h6>
            </div>

            <!-- item-->
            @if(Auth::user()->roles()->first()->type == 0)
                <a href="{{ url('my-profile') }}" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Profile</span>
                </a>
                @if(Auth::user()->roles()->first()->slug != 'loan-applicant')
                    <a href="{{ url('my-profile') }}#my-preferences" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>My Preferences</span>
                    </a>
                    @endif
                    <!--<a href="{{ url('my-profile') }}#change-password" class="dropdown-item notify-item">
                        <i class="fe-lock"></i>
                        <span>Change Password</span>
                    </a>-->
                @else
                
                @if(Auth::user()->roles()->first()->slug == 'admin')
                    <a href="{{ url('admin/my-profile') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Profile</span>
                    </a>
                @endif
                
                @if(Auth::user()->roles()->first()->slug == 'broker')
                    <a href="{{ url('broker/my-profile') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Profile</span>
                    </a>
                @endif
                
                <!--<a href="{{ url('admin/my-profile') }}#change-password" class="dropdown-item notify-item">
                    <i class="fe-lock"></i>
                    <span>Change Password</span>
                </a>-->
            @endif
            <div class="dropdown-divider"></div>

            <!-- item-->
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                <i class="fe-log-out"></i>
                <span>Logout</span>
            </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

        </div>
    </li>
    
    @else
    
    	<li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="pro-user-name ml-1">
                    Welcome {{ ucfirst(Auth::user()->name) }} !
                </span>
            </a>
        </li>
        
    
    @endif
    

    {{--  
        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li> 
    --}}


</ul>

    <!-- LOGO -->
    <div class="logo-box">
        @if(auth()->user()->roles()->first()->role_name == "Broker")
            <a href="{{ (Auth::user()->roles()->first()->type == 0) ? url('/') : url('broker/dashboard') }}" class="logo text-center">
                <span class="logo-lg">
                    <img src="{{ asset('user/img/logo.png') }}" alt="logo" height="30">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('user/img/logo.png') }}" alt="logo" height="15">
                </span>
            </a>
        @else
            <a href="{{ (Auth::user()->roles()->first()->type == 0) ? url('/') : url('admin/dashboard') }}" class="logo text-center">
                <span class="logo-lg">
                    <img src="{{ asset('user/img/logo.png') }}" alt="logo" height="30">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('user/img/logo.png') }}" alt="logo" height="15">
                </span>
            </a>
        @endif
        
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
    </ul>
</div>
