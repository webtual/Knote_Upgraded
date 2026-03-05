@extends('layouts._auth_master')
@section('title', 'Register - Knote')
@section('content')
<div class="account-pages pt-1 pb-5 cu-footer-tp-section">
	<div class="container">
		<div class="text-center mt-4 mb-4 header-title">
			<!--<div class="logo-center pb-3">-->
			<!--	<a href="{{ config('constants.wp_url') }}">-->
		 <!--   	<img src="{{ asset('user/images/logo.png') }}" alt="">-->
		 <!--   	</a>-->
			<!--</div>-->
		   <h1><strong>Business loans to fund your {{ date('Y') }} vision</strong></h1>
		   <!--<h4><strong>Access up to $500,000 for anything your business needs</strong></h4>-->
		</div>
		<div class="row">
			<div class="col-lg-10 ml-auto mr-auto">
		      <div class="card bg-pattern light-grey overflow-hidden">
		         <div class="row">
		            <div class="col-lg-7 col-xl-8">
		               <div class="card-body p-sm-4 p-3 text-left h-100">
		                  
		                  <div class="text-left mb-2">
		                     <h2><strong>Start a business loan application</strong></h2>
		                     <h4 class="mb-3 tag-line-create-account">It wont take long at all - quick & easy application!</h4>
		                  </div>
		                  
		                  <br>
		                  
		                  <div id="step-1" class="my-5 animated fadeInDown">
		                     <h4 class="c-text-success"><strong>Are you applying for?</strong></h4>
		                     
		                    <!--<div class="form-group ml-1 d-flex flex-column">
                               <div class="radio radio-info form-check-inline">
                                  <input type="radio" id="apply_for_option" value="2" name="apply_for_option" checked="checked">
                                  <label for="inlineRadio1">Secured property backed funding </label>
                               </div>
                               <div class="radio radio-info form-check-inline mt-1">
                                  <input type="radio" id="apply_for_option" value="1" name="apply_for_option"  >
                                  <label for="inlineRadio1">Business cash flow funding </label>
                               </div>
                            </div>-->
                            
                            <div class="form-group ml-1 d-flex flex-column">
                               <div class="radio radio-info form-check-inline">
                                  <input type="radio" id="apply_for_option" value="2" name="apply_for_option" checked="checked">
                                  <label for="inlineRadio1">Knote Fast Property Backed Funding </label>
                               </div>
                               <div class="radio radio-info form-check-inline mt-1">
                                  <input type="radio" id="apply_for_option" value="1" name="apply_for_option"  >
                                  <label for="inlineRadio1">Knote Fast Business Cash Flow Funding </label>
                               </div>
                               <div class="radio radio-info form-check-inline mt-1">
                                  <input type="radio" id="apply_for_option" value="3" name="apply_for_option"  >
                                  <label for="inlineRadio1">Knote Fast Crypto Backed Funding </label>
                               </div>
                            </div>
		                    
		                    <div class="pb-3">
		                        <a href="javascript:;" class="btn btn-success waves-effect waves-light btn-step-1">Next</a> 
		                    </div>
		                  </div>
		                  
		                  <div id="step-5" class="d-none animated fadeInDown">
		                     <p class="mb-1 mt-1 font-20 text-dark">Your account has been created successfully</p>
		                     <div id="splash-details">
		                        <div id="register-info"></div>
		                        <div class="text-center mb-4 mt-4">
		                           <div class="role-4 role-3 d-none"> 
		                        		<a href="{{ url('loan/create') }}" class="ml-1 btn btn-outline-success waves-effect waves-light">Create new loan application</a> 
		                           </div>
		                        </div>
		                        
		                        <h5 class="text-dark font-weight-bold">When we call, we’ll be able to help you with:</h5>
		                        
		                        <ul class="reg-form">
			                        <li>- Any questions you have about knote</li>
			                        <li>- What you’ll need to complete your application</li>
			                        <li>- Next steps to continue</li>
			                    </ul>
		                        <p class="mt-3 text-dark font-weight-bold">We look forward to discussing your funding needs with you.</p>
		                     </div>
		                  </div>
		                
		                  {{--
		                  <div id="step-4" class="d-none">
		                     <p class="mb-1 mt-1 font-20 text-dark">Your account has been created successfully</p>
		                     <div id="splash-details">
		                        <div id="register-info"></div>
		                        <div class="text-center mb-4 mt-4">
		                           <div class="role-4 role-3 d-none"> 
		                        		<a href="{{ url('dashboard') }}" class="btn btn-outline-dark waves-effect waves-light">Go to dashboard</a> 
		                        		<a href="{{ url('loan/create') }}" class="ml-1 btn btn-outline-success waves-effect waves-light">Create new loan application</a> 
		                           </div>
		                           <div class="role-5 d-none"> 
		                        		<a href="{{ url('dashboard') }}" class="btn btn-outline-dark waves-effect waves-light">Go to dashboard</a> 
		                           </div>
		                        </div>
		                        
		                        <h5 class="text-dark font-weight-bold">When we call, we’ll be able to help you with:</h5>
		                        
		                        <ul class="reg-form">step-4
			                        <li>- Any questions you have about knote</li>
			                        <li>- What you’ll need to complete your application</li>
			                        <li>- Next steps to continue</li>
			                    </ul>
		                        <p class="mt-3 text-dark font-weight-bold">We look forward to discussing your funding needs with you.</p>
		                     </div>
		                  </div>
		                  --}}
		                  
		                  <form action="{{ url('validate-step-2') }}" method="POST" onsubmit="return false;" name="contact-form" class="animated fadeInDown register-form new-register-form d-none" id="step-2" autocomplete="off">
		                       @csrf
		                     <div class="form-group">
		                        <label for="name">Full name</label>
		                        <input name="fullname" id="fullname" autocomplete="off" type="fullname" class="form-control">
		                     </div>
		                     <div class="form-row">
		                        <div class="form-group col-md-6">
		                           <label for="name">Email Address</label>
		                           <input name="email" id="email" type="email" autocomplete="off" class="form-control" >
		                        </div>
		                        <div class="col-md-6">
		                           <div class="form-group mb-0">
		                              <label for="name">Phone</label>
		                           </div>
		                           <div class="form-row">
		                              <!--<div class="form-group col-3 col-md-3 col-lg-3">-->
		                              <!--   <input type="text" class="form-control" autocomplete="off" name="countrycode" id="country-code" value="+61" readonly="readonly" placeholder="+61">-->
		                              <!--</div>-->
		                              <div class="form-group col-12 col-md-12 col-lg-12" for="phone">
		                                 <input name="phone" id="phone" type="text" class="form-control phone-field" autocomplete="off">
		                              </div>
		                           </div>
		                        </div>
		                     </div>
		                    @php
                                use App\User;
                            @endphp
		                    <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="know_about_us">How did you know about us?</label>
                                    <select id="know_about_us" name="know_about_us" class="form-control">
                                        <option value="">Select..</option>
                                        @foreach (User::KNOW_ABOUT_US_VAL as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6" style="display:none;">
                                    <label for="know_about_us_others">Please Specify:</label>
                                    <input name="know_about_us_others" id="know_about_us_others" autocomplete="off" type="text" class="form-control">
                                </div>
                            </div>
		                     
		                     <!--
		                     <div class="form-row password-row">
		                        <div class="form-group col-md-6">
		                           <label for="email">Password</label>
		                           <input name="password" id="password" autocomplete="off" type="password" class="form-control">
		                        </div>
		                        <div class="form-group col-md-6">
		                           <label for="email">Confirm Password</label>
		                           <input name="confirm_password" autocomplete="off" id="confirm_password" type="password" class="form-control">
		                        </div>
		                     </div>
		                     -->
		                     <div class="form-group mb-3">
		                        <div id="request_a_callback" class="custom-control checkbox checkbox-success form-check-inline pl-0">
		                           <input type="checkbox" id="policy-accept" value="1" name="request_a_callback">
		                           <label for="inlineCheckbox2">
		                           	    Request a call-back
		                           </label>
		                        </div>
		                     </div>
		                     <div class="form-group mb-1 pb-1 error-message"> </div>
		                     
		                     <input type="hidden" name="role" value="3">
		                     <input type="hidden" name="apply_for" id="apply_for" value="1">
		                     
		                     <div class="form-row">
		                        <div class="form-group mb-0 text-left col-xl-6  terms-condition"> By getting started you are agreeing to our <a target="_blank" href="{{ config('constants.wp_privacy_policy') }}">Terms &amp; Conditions</a> </div>
		                        <div class="form-group mb-0 text-center col-xl-6">
		                           <button class="btn btn-success btn-lg btn-block" id="btn-register" name="register" type="submit"> Get started </button>
		                        </div>
		                     </div>
		                  </form>
		                  
		                  <div id="step-3" class="my-5 d-none animated fadeInDown">
    		                  <form action="{{ url('validate-step-3') }}" data-redirect="{{ url('loan/create') }}" method="POST" onsubmit="return false;" name="otp-form" class="comman-form" id="otp-form" autocomplete="off">
    		                     <div class="form-group">
    		                        <label for="name">Enter 6 Digits OTP Number</label>
    		                        <input name="otp" id="otp" type="text" value="" class="form-control numbers-only" maxlength="6">
    		                     </div>
    		                     <div class="form-row pb-3">
    		                        
    		                        <div class="form-group mb-0 text-center col-md-12">
    		                           <button class="btn btn-success btn-lg btn-block" id="btn-verify-otp" name="btn-verify-otp" type="submit"> Verify OTP </button>
    		                        </div>
    		                     </div>
    		                  </form>
    		              </div>
		                  
		                  <div id="step-4" class="thank-you d-none animated fadeInDown">
		                     <div class="your-call-back">
		                        <h5>Your call-back request has been submitted.</h5>
		                        <p>Our customer service team will be in touch as soon as possible
		                           To discuss your application. We’re open Mon - Fri, 9:00am till 5:30pm.
		                           
		                           <!--Mon – Fri, 8:00 AM until-->
		                           <!--7:00 PM AEST. -->
		                        </p>
		                     </div>
		                     <h5>When we call, we’ll be able to help you with:</h5>
		                     <ul>
		                        <li>Any questions you have about knote</li>
		                        <li>What you’ll need to complete your application</li>
		                        <li>Next steps to continue</li>
		                     </ul>
		                     <p>We look forward to discussing your funding needs with you.</p>
		                  </div>
		                  
		               </div>
		            </div>
		            <div class="col-lg-5 col-xl-4">
		                <div class="p-sm-4 p-3">
		               <div class="what-do-need">
		                  <h4><strong>How Knote can help?</strong></h4>
		                  <ul class="what-we-need-apply">
		                     <li><i class="fa fa-check" aria-hidden="true"></i> Property Loan</li>
		                     <li><i class="fa fa-check" aria-hidden="true"></i> Business Cash flow Loan</li>
		                     <li><i class="fa fa-check" aria-hidden="true"></i> Commercial / Business Loan</li>
		                     <li><i class="fa fa-check" aria-hidden="true"></i> Cryptocurrency Loan</li>
		                  </ul>
		               </div>
		               <div class="have-questions mt-4">
		                  <h4><strong>We are happy to answer questions</strong></h4>
		                  <p>Our friendly customer service team are waiting to help you.</p>
		                  <ul>
		                     <li>
		                     	<a href="tel://1300056683"><i class="fa fa-phone fa-flip-horizontal" aria-hidden="true"></i>Call us on 1300 056 683</a><br>
		                        <span class="ml-1">Mon - Fri, 9:00am till 5:30pm</span> 
		                     </li>
		                     <li>
		                     	<a href="mailto:hello@knote.com.au"><i class="fa fa-envelope" aria-hidden="true"></i>Email hello@knote.com.au</a>
		                     </li>
		                  </ul>
		               </div></div>
		            </div>
		            
		         </div>
		      </div>
		      <!-- end card-body --> 
			</div>
		</div>
	</div>
</div>

<!--<div class="pt-1 mb-4">-->
<!--    <footer class="footer footer-alt text-white p-0">-->
<!--        <div>-->
<!--            <span>© {{ date('Y') }} Knote Group Aus Pty Ltd. (A.C.N. 657 400 041)</span>-->
<!--        </div>-->
<!--        <div>-->
<!--            <span>Knote Group Aus Pty Ltd is credit representative of Jass Group (Aus) Pty Ltd CRN 544373</span>	-->
<!--        </div>-->
<!--    </footer>-->
<!--</div>-->

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

<script>
$(document).ready(function () {
    $('#know_about_us').on('change', function () {
        if ($(this).val() == '8') {
            $('#know_about_us_others').closest('.form-group').show();
        } else {
            $('#know_about_us_others').closest('.form-group').hide();
            $('#know_about_us_others').val(''); // Clear input if hidden
        }
    });

    // Trigger change on page load (e.g., for edit form)
    $('#know_about_us').trigger('change');
});

</script>

<script>
    $('.btn-step-1').click(function(){
        var apply_for = $('input[name="apply_for_option"]:checked').val();
        $('#apply_for').val(apply_for);
        $('#step-2').fadeIn().removeClass('d-none');
        $('#step-1').fadeOut();
    });

</script>
<script>
$(document).ready(function() {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 5) {
      $(".sticky-navbar").addClass("stickynav");
    } else {
      $(".sticky-navbar").removeClass("stickynav");
    }
  });
});
$(document).ready(function(){
  $(".cunavbar-toggler").click(function(){
    $(".cucollapse").toggleClass("active");
    $(".cucollapse-overlay").toggleClass("active");
  });
});
$(document).ready(function(){
  $(".cucollapse-overlay").click(function(){
    $(".cucollapse").removeClass("active");
    $(".cucollapse-overlay").removeClass("active");
  });
});
</script>
@endsection