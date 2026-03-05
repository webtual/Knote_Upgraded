<header id="header">
  <div class="container">

    <div id="logo" class="pull-left">
      <a href="{{ config('constants.wp_url') }}" class="scrollto"><img src="{{ asset('user/img/logo.png') }}"
          alt="" /></a>
    </div>

    <nav id="nav-menu-container">
      <ul class="nav-menu">

        <!--
        <li class="{{ (Route::currentRouteName() == 'root') ? 'menu-active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
        -->
        @if(Auth::check())
          @if(Auth::user()->roles()->first()->type == 0)
            <li class="{{ request()->is('dashboard') ? 'menu-active' : '' }}"><a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
          @else
            <li class="{{ request()->is('dashboard') ? 'menu-active' : '' }}"><a
                href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          @endif
        @endif
        @if((Route::currentRouteName() == 'root') || (Route::currentRouteName() == 'dashboard'))
          @if(Route::currentRouteName() == 'root')
            <li><a href="#services">Services</a></li>
          @else
            <li><a href="#loan-calculator">Loan Calculator</a></li>
          @endif

          <!--<li><a href="#contact">Contact Us</a></li> -->
        @else
          <li><a href="{{ url('/') }}#services">Services</a></li>
          <li><a href="{{ url('/') }}#contact">Contact Us</a></li>
        @endif
        <li class="{{ request()->is('about-us') ? 'menu-active' : '' }}"><a href="{{ route('page.about') }}">About
            Us</a></li>


        @if(Auth::check())
          <!--
                @if(Auth::user()->roles()->first()->type == 0)
                <li><a href="{{ url('dashboard') }}">Dashboard</a></li>
                @else
                <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                @endif-->
          <li><a href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @else
          <li><a href="{{ url('login') }}">Sign in</a></li>
          <li><a href="{{ url('register/loan-applicant') }}">Apply Now</a></li>
        @endif


      </ul>
    </nav>
  </div>
</header>