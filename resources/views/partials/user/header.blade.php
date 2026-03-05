
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="fa fa-envelope-o"></i> <a href="mailto:hello@knote.com.au">hello@knote.com.au</a>
        <i class="fa fa-phone"></i> <a href="tel:+1300 056 683">1300 056 683</a>
      </div>
      <div class="top-menu">
        <ul>
          @if(Auth::check())
            @if(Route::currentRouteName() == 'root')
              @if(Auth::user()->roles()->first()->type == 0)
              <li><a href="{{ url('dashboard') }}">Dashboard</a></li>
              @else
               <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
              @endif
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @else
              <div class="social-links float-right">
                <a href="{{ config('constants.social_link.twitter') }}" class="twitter" target="blank" ><i class="fa fa-twitter"></i></a>
                <a href="{{ config('constants.social_link.facebook') }}" class="facebook" target="blank"><i class="fa fa-facebook"></i></a>
                <a href="{{ config('constants.social_link.instagram') }}" class="instagram" target="blank"><i class="fa fa-instagram"></i></a>
                <a href="{{ config('constants.social_link.google') }}" class="google-plus" target="blank" ><i class="fa fa-google-plus"></i></a>
                <a href="{{ config('constants.social_link.linkedin') }}" class="linkedin" target="blank"><i class="fa fa-linkedin"></i></a>
              </div>

            @endif
          @else
            @if(Route::currentRouteName() == 'root') 
              <li><a href="{{ url('login') }}">Sign in</a></li>
              <li><a href="{{ url('register/loan-applicant') }}">Apply Now</a></li>
            @else
              <div class="social-links float-right">
                <a href="{{ config('constants.social_link.twitter') }}" class="twitter" target="blank" ><i class="fa fa-twitter"></i></a>
                <a href="{{ config('constants.social_link.facebook') }}" class="facebook" target="blank"><i class="fa fa-facebook"></i></a>
                <a href="{{ config('constants.social_link.instagram') }}" class="instagram" target="blank"><i class="fa fa-instagram"></i></a>
                <a href="{{ config('constants.social_link.google') }}" class="google-plus" target="blank" ><i class="fa fa-google-plus"></i></a>
                <a href="{{ config('constants.social_link.linkedin') }}" class="linkedin" target="blank"><i class="fa fa-linkedin"></i></a>
              </div>
            @endif  
          @endif 
        </ul>
      </div>
    </div>
  </section>
  @if( (Route::currentRouteName() == 'root') || (Route::currentRouteName() == 'dashboard') || (Route::currentRouteName() == 'page.loans') || (Route::currentRouteName() == 'blog.show') || (Route::currentRouteName() == 'page.terms') || (Route::currentRouteName() == 'page.about') || (Route::currentRouteName() == 'page.privacy') || (Route::currentRouteName() == 'page.media') || (Route::currentRouteName() == 'page.faq') )
    @include('partials.user.header_menu')
  @endif
