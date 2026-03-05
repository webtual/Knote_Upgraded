@extends('layouts._auth_master')

@section('title', 'Login - Knote')
@section('content')

   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="login-more">
            <div class="container mt-2">
               <div class="logo-area pt-2 pl-2 text-center text-lg-left d-none d-md-block">
               		<a href="{{ config('constants.wp_url') }}">
                	<img src="{{ asset('user/images/logo.png') }}" alt="">
                	</a>
               </div>
            </div>
         </div>
         <div class="form-login">
            <div class="card bg-pattern">
               <div class="card-body pl-4 pr-4 pt-3 pb-0">
                  <div class="text-center w-75 m-auto">
                     <a href="{{ url('/') }}">
                     <span><img src="{{ asset('user/images/logo.png') }}" alt="" height="40"></span>
                     </a>
                     <p class="text-muted mb-4 mt-3">Enter your phone and password to access the service.</p>
                  </div>
                  <form class="login-form" action="{{ route('login') }}"  onsubmit="return false;"  method="POST" name="contact-form" id="auth-form">
                	<div class="wrap-form-group validate-input mb-2">
                       <input name="phone" id="phone" type="text" class="form-control" placeholder="" autocomplete="off">
                        <span class="focus-form-control"></span>
                        <span class="label-form-control">Phone</span>
                    </div>
                    
                    
                    <!--<div class="wrap-form-group validate-input">
                         <input name="phone" id="phone" type="text" class="form-control" placeholder="" autocomplete="off">
                        <span class="focus-form-control"></span>
                        <span class="label-form-control">Phone</span>
                    </div>-->
                    
                    
                    <div class="wrap-form-group validate-input mt-3">
                         <input name="password" id="password" type="password" class="form-control" placeholder="" autocomplete="off">
                        <span class="focus-form-control"></span>
                        <span class="label-form-control">Password</span>
                     </div>
                     <div class="form-group mb-3">
                        <div class="custom-control checkbox checkbox-success form-check-inline" style="padding-left: 0rem;">
                           <input type="checkbox" id="inlineCheckbox2" value="option1" >
                           <label for="inlineCheckbox2"> Remember me </label>
                        </div>
                     </div>
                    
                     <div class="form-group mb-2 pb-2 error-message">
                     </div>
                     
                     {{--
                     <div class="row">
                        <div class="col-lg-12">
                           <fieldset class="scheduler-border">
                              <legend class="scheduler-border">Login By</legend>
                              
                              <input class="btn btn-success login-manual" data-password="123456789" type="button" data-phone="9409511111" value="Admin"> 
                        	  
                        	  <input class="btn btn-success login-manual" data-password="123456789" type="button" data-phone="9409533333" value="Investor"> 
							  <input class="btn btn-success login-manual" data-password="123456789" type="button" data-phone="9409544444" value="Entrepreneur"> 
							  
							  <input class="btn btn-success login-manual" data-password="123456789" type="button" data-phone="9409555555" value="Loan Applicant"> 
                        
                           </fieldset>
                        </div>
                     </div>
                     --}}
                     
                     <div class="form-group mb-0 text-center">
                        <button class="btn btn-success btn-block" id="login" name="login" type="submit"> Log In </button>
                     </div>
                  </form>
               </div>
               <!-- end card-body -->
               
               
               <div class="row">
	               <div class="col-12 text-center">
	                  <p class="pt-3"> <a href="{{ url('password/reset') }}" class="text-black ml-1">Forgot your password?</a></p>
	                  
	                  {{--
	                  <p class="text-black pb-0 mb-0">Don't have an account? <a href="{{ url('register') }}" class="text-black ml-1"><b>Sign Up</b></a></p>
	                  --}}
	                  
	               </div>
	               <!-- end col -->
	            </div>
	            <!-- end row -->
               
            </div>
            <!-- end card -->
            
         </div>
      </div>
      <!-- end row -->
   </div>

@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#inlineCheckbox2').attr('checked', 'checked');
        $('[name="phone"]').val(localStorage.phone);
        $('[name="password"]').val(localStorage.password);
    } else {
        $('#inlineCheckbox2').removeAttr('checked');
        $('[name="phone"]').val('');
        $('[name="password"]').val('');
    }

    $('#inlineCheckbox2').click(function() {

        if ($('#inlineCheckbox2').is(':checked')) {
            // save username and password
            localStorage.phone = $('[name="phone"]').val();
            localStorage.password = $('[name="password"]').val();
            localStorage.chkbx = $('#inlineCheckbox2').val();
        } else {
            localStorage.phone = '';
            localStorage.password = '';
            localStorage.chkbx = '';
        }
    });
});

$(":input").bind("keyup change", function(e) {
	var input = $(this).val();
	if(input != ""){
		$(this).closest('.validate-input').find('.label-form-control').fadeOut('slow');
	}else{
		$(this).closest('.validate-input').find('.label-form-control').fadeIn('slow');
	}
});
</script>
@endsection






