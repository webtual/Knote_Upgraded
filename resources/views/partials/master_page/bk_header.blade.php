<!--====================================================nav-bar-start======================================================-->
<section class="sticky-navbar new-style">
   <div class="container cu-nav">
      <nav class="navbar navbar-expand-xl py-3 navbar-light bg-transparent">
         <a class="navbar-brand cu-a-tag" href="{{ config('constants.wp_url') }}">
         <img src="{{ asset('user/images/logo.png') }}" alt="">
         </a>
         <div class="mr-2 d-xl-none ml-auto">
            <a href="tel://1300056683" class="btn py-1 bg-ctheme"><i class="fa fa-phone fa-flip-horizontal text-white" aria-hidden="true"></i> <span class="text-white font-weight-bold">Call Us</span></a>
         </div>
         <!--data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"-->
         <button class="navbar-toggler cunavbar-toggler" type="button">
         <i class="fas fa-bars"></i>
         </button>
         <div class="collapse navbar-collapse show cucollapse" id="navbarSupportedContent">
            <div class="d-flex justify-content-between py-2 px-2 d-xl-none">
               <div >
                  <a class="navbar-brand" href="{{ config('constants.wp_url') }}">
                  <img src="{{ asset('user/images/logo.png') }}" alt="">
                  </a>
               </div>
               <duv>
                  <button class="navbar-toggler bg-ctheme cunavbar-toggler border-0 p-2" type="button">
                  <i class="fas fa-times"></i>
                  </button>
               </duv>
            </div>
            <ul class="navbar-nav ml-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="{{ config('constants.wp_url')  }}about-us">About Us</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{ config('constants.wp_url')  }}privacy-policy">Privacy Policy</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{ config('constants.wp_url')  }}contact-us">Support</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Business Loan <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}cash-flow-loans">Cash Flow Loans</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}short-term-business-loans">Short Term Business Loans</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}unsecured-business-loans">Unsecured Business Loans</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}fast-business-loans">Fast Business Loans</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}working-capital-loans">Working Capital Loans</a>
                  </div>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Property Loan <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}private-lending">Private Lending</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}property-funding">Property Funding</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}commercial-land-funding">Commercial Land Funding</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}gap-funding">Gap Funding</a>
                     <a class="dropdown-item" href="{{ config('constants.wp_url')  }}land-banking">Land Banking</a>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{ config('constants.wp_url')  }}blog">Blog</a>
               </li>
               
               @if(Auth::check())
                    
                    <li class="nav-item">
                        <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('logout') }}">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                   
               @else
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Log In <i class="fa fa-angle-down" aria-hidden="true"></i>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('login/customer') }}">Customer Login</a>
                            <a class="dropdown-item" href="{{ url('login/internal') }}">Internal Login</a>
                            <a class="dropdown-item" href="{{ url('login/broker') }}">Broker Login</a>
                            <a class="dropdown-item" href="{{ url('register/broker') }}">Broker Registration</a>
                      </div>
                    </li>
               @endif
               
            </ul>
         </div>
         <div class="cucollapse-overlay"></div>
      </nav>
   </div>
</section>
<!--====================================================nav- bar- end======================================================-->
