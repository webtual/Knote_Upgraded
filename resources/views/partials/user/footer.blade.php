<footer id="footer">
  <div class="container">
    {{--
    <div class="row">
      <div class="col-md-12">
          <div class="footer-menu">
            <ul class="foo-ul">
              @if(Route::currentRouteName() == 'root')
              <li><a href="#services">Services</a></li> 
              <li><a href="#business-proposals">Business Proposal</a></li> 
              <li><a href="#resources">Resources</a></li> 
              <li><a href="#contact">Contact Us</a></li>
              @else
              <li><a href="{{ url('/') }}#services">Services</a></li> 
              <li><a href="{{ url('/') }}#business-proposals">Business Proposal</a></li> 
              <li><a href="{{ url('/') }}#resources">Resources</a></li> 
              <li><a href="{{ url('/') }}#contact">Contact Us</a></li>
              @endif 
              <li><a href="{{ route('page.about') }}">About Us</a></li>
              <li><a href="{{ config('constants.wp_privacy_policy') }}">Terms</a></li>
              <!--<li><a href="{{ route('page.privacy') }}">Privacy</a></li> -->
              <!--<li><a href="{{ route('page.media') }}">Media</a></li>         -->
            </ul>
          </div>
      </div>
    </div>
    --}}
    
    <div class="row">
      <div class="col-lg-9 mb-2 mb-lg-0">
        <div class="copyright">
            <span>© {{ date('Y') }} Knote Group Aus Pty Ltd. (A.C.N. 657 400 041)</span>
            <span>Knote Group Aus Pty Ltd is credit representative of Jass Group (Aus) Pty Ltd CRN 544373</span>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="social-links text-lg-right text-left">
          <a href="{{ config('constants.social_link.twitter') }}" class="twitter" target="blank" ><i class="fa fa-twitter"></i></a>
          <a href="{{ config('constants.social_link.facebook') }}" class="facebook" target="blank"><i class="fa fa-facebook"></i></a>
          <a href="{{ config('constants.social_link.instagram') }}" class="instagram" target="blank"><i class="fa fa-instagram"></i></a>
          <a href="{{ config('constants.social_link.google') }}" class="google-plus" target="blank" ><i class="fa fa-google-plus"></i></a>
          <a href="{{ config('constants.social_link.linkedin') }}" class="linkedin" target="blank"><i class="fa fa-linkedin"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- #footer -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>