@extends('layouts._auth_master')
    @if(Route::currentRouteName() == "login.customer")
        @section('title', 'Secure Customer Login | Knote')
        @section('meta_description', 'Log in to your Knote account to manage your applications, track progress so that you dont have to worry about the loans.')
    @endif    
        
    @if(Route::currentRouteName() == "login.internal")
        @section('title', 'Secure Employee Login Portal | Knote Internal Login')
        @section('meta_description', 'Access your Knote employee portal securely to manage internal communications, tasks, and resources. Log in to stay connected to track loan applications smoothly.')
    @endif
    
    @if(Route::currentRouteName() == "login.broker")
        @section('title', 'Secure Broker Login Portal | Knote Internal Login')
        @section('meta_description', 'Access your Knote broker portal securely to manage internal communications, tasks, and resources. Log in to stay connected to track loan applications smoothly.')
    @endif
@section('content')
<section class="new_page_banner">
    @if(Route::currentRouteName() == "login.customer")
        <h1>Customer<span>Login</span></h1>
    @endif
                
    @if(Route::currentRouteName() == "login.internal")
        <h1>Internal<span>Login</span></h1>
    @endif
                
    @if(Route::currentRouteName() == "login.broker")
        <h1>Broker<span>Login</span></h1>
    @endif
    
</section>
<div class="account-pages login-page py-5 px-2">
   <div class="container new_login_page  overflow-hidden">
      <div class="row">
         <div class="col-lg-6 background_cover">
            <div class="d-flex align-items-end justify-content-center h-100 ">
                @if(Route::currentRouteName() == "login.customer")
                    <!--<img src="{{ asset('user/images/otp-vector-img.png') }}" alt="" class="w-100" style="max-width:400px;">-->
                    <img src="{{ asset('comman/images/img/human-vector.webp') }}" alt="" class="w-100" style="max-width:400px;">
                @endif
                
                @if(Route::currentRouteName() == "login.internal")
                    <!--<img src="{{ asset('user/images/OTP.png') }}" alt="" class="w-100" style="max-width:400px;">-->
                    <img src="{{ asset('comman/images/img/human-vector-2.webp') }}" alt="" class="w-100" style="max-width:400px;">
                @endif
                
                @if(Route::currentRouteName() == "login.broker")
                    <!--<img src="{{ asset('user/images/OTP.png') }}" alt="" class="w-100" style="max-width:400px;">-->
                    <img src="{{ asset('comman/images/img/human-vector-1.webp') }}" alt="" class="w-100" style="max-width:400px;">
                @endif
                
            </div>
         </div>
         <div class="col-lg-6 d-flex align-items-center justify-content-center px-2 px-sm-5  py-3 py-sm-5">
            <div class="card login_card px-4 px-xl-5 py-4 py-xl-5 h-100 w-100 mb-0 justify-content-center">
            
               <div class="mbns-otpform ">
                    <form name="send-otp-form" id="send-otp-form" onsubmit="return false;" action="{{ url('login/sent-otp') }}">
                        @csrf
                            @if(Route::currentRouteName() == "login.customer")
                                <h3 class="mb-1">Customer Login</h3>
                            @endif
                            @if(Route::currentRouteName() == "login.internal")
                                <h3 class="mb-1">Internal Login</h3>
                            @endif
                            @if(Route::currentRouteName() == "login.broker")
                                <h3 class="mb-1">Broker Login</h3>
                            @endif
                          <p class="">We will send you a confirmation code</p>
                          <div class="cu-form-group mt-3">
                             <label for="exampleInputPassword1">Enter Your Mobile Number</label>
                             <div class="position-relative">
                                <input type="hidden" value="+61" name="countrycode">
                                <input type="hidden" value="{{ Route::currentRouteName() }}" name="login_type">
                                <input type="text" class="form-control phone-field rounded-pill" name="mobile_number"  data-mask="9999 999 999" placeholder="Enter Your Mobile Number">
                                <span class="d-flex align-items-center num-login-wrapper">
                                    <span class="fa-wrapper"><i class="fa fa-phone fa-flip-horizontal " aria-hidden="true"></i> </span>
                                    <!--<span> +61 </span>-->
                                </span>
                             </div>
                          </div>
                          <button type="button" class="btn btn-primary mt-3 w-100 cusendotp text-white rounded-pill text-uppercase submit_button" id="send-otp">Send OTP</button>
                    </form>
               </div>
               
               <div class="otps-otpform otp-form d-none">
                   <form name="verify-otp-form" id="verify-otp-form" onsubmit="return false;" action="{{ url('login/verify-otp') }}">
                       @csrf
                      <h3 class="mb-1 text-center">Enter Verification code</h3>
                      <p class="text-center">Send to your mobile number <span id="input_mobile_number"></span></p>
                      <div class="d-flex justify-content-center mt-3">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <!-- Store OTP Value -->
                         <input class="otp-value" type="hidden" name="otp_number">
                         
                         <input type="hidden" value="{{ Route::currentRouteName() }}" name="login_type">
                      </div>
                      <div class="otp-error">
                          
                      </div>
                      <div class="d-block mt-4">
                         <button class="btn btn-primary w-100 rounded-pill text-uppercase submit_button" id="verify-otp" type="button">Verify</button>
                      </div>
                    </form>
               </div>
           
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript">


$('#send-otp').click(function(){
    $('.error-block').remove();
    var url = $('#send-otp-form').attr('action');
    var mobile = $("input[name='mobile_number']").val();
    
    if(mobile == ""){
        $('input[name="mobile_number"]').after('<span class="help-block error-block text-danger"><small>Please enter the mobile number</small></span>'); 
        return false;
    }else{
    
        $.ajax ({
           type: 'POST',
           url: url,
           //async: false,
           data: $('#send-otp-form').serialize(),
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success : function(response) {
                if(save_exit_true()){
                    if(response.status == 201){
                        toaserMessage(response.status, response.message);
                        //var mobile = "+61 "+$("input[name='mobile_number']").val();
                        
                        $('#input_mobile_number').text(mobile);
                        $(".mbns-otpform").addClass("d-none");
                        $(".otps-otpform").removeClass("d-none");
                        $('.otp-field:eq(0)').focus();
                    }else{
                        $('input[name="mobile_number"]').after('<span class="help-block error-block text-danger"><small class="text-danger">'+response.message+'</small></span>'); 
                        //toaserMessage(response.status, response.message);
                    }    
                }
           },
           error: function (reject) {
                if(save_exit_true()){
                    if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        $.each(errors,function(field_name,error){
                            $('input[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small class="text-danger">Mobile Number is Invalid</small></span>'); 
                        });
                    }
                }
            }
        }); 
    }
})


$('#verify-otp').click(function(){
    $('.error-block').remove();
    var url = $('#verify-otp-form').attr('action');
    $.ajax ({
       type: 'POST',
       url: url,
       //async: false,
       data: $('#verify-otp-form').serialize(),
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){
                    if(response.data != ""){
                        window.location.href = response.data;
                    }
                }else{
                    $('.otp-error').after('<span class="help-block error-block text-danger"><small class="text-danger">'+response.message+'</small></span>');
                    //toaserMessage(response.status, response.message);
                }    
            }
       },
       error: function (reject) {
            if(save_exit_true()){
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    $.each(errors,function(field_name,error){
                        $('.otp-error').after('<span class="help-block error-block text-danger"><small class="text-danger">'+errors+'</small></span>'); 
                    });
                }
            }
        }
    }); 
})



</script>

<script>
    $(document).ready(function () {
	$(".otp-form *:input[type!=hidden]:first").focus();
	let otp_fields = $(".otp-form .otp-field"),
		otp_value_field = $(".otp-form .otp-value");
	otp_fields
		.on("input", function (e) {
			$(this).val(
				$(this)
					.val()
					.replace(/[^0-9]/g, "")
			);
			let opt_value = "";
			otp_fields.each(function () {
				let field_value = $(this).val();
				if (field_value != "") opt_value += field_value;
			});
			otp_value_field.val(opt_value);
		})
		.on("keyup", function (e) {
			let key = e.keyCode || e.charCode;
			if (key == 8 || key == 46 || key == 37 || key == 40) {
				// Backspace or Delete or Left Arrow or Down Arrow
				$(this).prev().focus();
			} else if (key == 38 || key == 39 || $(this).val() != "") {
				// Right Arrow or Top Arrow or Value not empty
				$(this).next().focus();
			}
		})
		.on("paste", function (e) {
			let paste_data = e.originalEvent.clipboardData.getData("text");
			let paste_data_splitted = paste_data.split("");
			$.each(paste_data_splitted, function (index, value) {
				otp_fields.eq(index).val(value);
			});
		});
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