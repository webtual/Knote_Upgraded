@extends('layouts._auth_master')
    @section('title', 'Applicant/Director/Proprietor Consent | Knote')
    @section('meta_description', 'Log in to your Knote account to manage your applications, track progress so that you dont have to worry about the loans.')
@section('content')
<section class="new_page_banner">
        <h1>Application<span>Access</span></h1>
</section>
<div class="account-pages login-page py-5 px-2">
   <div class="container new_login_page  overflow-hidden">
      <div class="row">
         <div class="col-lg-6 background_cover">
            <div class="d-flex align-items-end justify-content-center h-100">
                <img src="{{ asset('comman/images/img/human-vector.webp') }}" alt="" class="w-100" style="max-width:400px;">
            </div>
         </div>
         <div class="col-lg-6 d-flex align-items-center justify-content-center px-2 px-sm-5  py-3 py-sm-5">
            <div class="card login_card px-4 px-xl-5 py-4 py-xl-5 h-100 w-100 mb-0 justify-content-center">
               
               <div class="mbns-otpform ">
                    <form name="send-otp-form" id="send-otp-form" onsubmit="return false;" action="{{ url('loan/consent-sent-otp') }}">
                        @csrf
                            <h3 class="mb-1">Application Access</h3>
                          <p class="">We will send you a confirmation code</p>
                          <div class="cu-form-group mt-3">
                             <label for="exampleInputPassword1">Your Mobile Number</label>
                             <div class="position-relative">
                                <input type="hidden" value="+61" name="countrycode">
                                <input type="text" class="form-control phone-field" name="mobile_number"  data-mask="9999 999 999" placeholder="Enter Your Mobile Number" readonly="" value="{{display_aus_phone($team_data->mobile)}}">
                                <span class="d-flex align-items-center num-login-wrapper">
                                    <span class="fa-wrapper"><i class="fa fa-phone fa-flip-horizontal " aria-hidden="true"></i> </span>
                                </span>
                             </div>
                          </div>
                          <input type="hidden" value="{{ $team_id }}" id="team_id_val" name="team_id_val">
                          <button type="button" class="btn btn-primary mt-3 w-100 cusendotp text-white rounded-pill text-uppercase submit_button" id="send-otp">Send OTP</button>
                    </form>
               </div>
               
               <div class="otps-otpform otp-form d-none">
                   <form name="verify-otp-form" id="verify-otp-form" onsubmit="return false;" action="{{ url('loan/consent-verify-otp') }}">
                       @csrf
                      <h3 class="mb-1 text-center">Enter Verification code</h3>
                      <p class="text-center">Send to your mobile number <span id="input_mobile_number">{{display_aus_phone($team_data->mobile)}}</span></p>
                      <div class="d-flex justify-content-center mt-3">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <input class="otp-field" type="text" name="opt-field[]" maxlength=1 placeholder="">
                         <!-- Store OTP Value -->
                         <input class="otp-value" type="hidden" name="otp_number">
                         <input type="hidden" value="{{ $team_id }}" id="team_id" name="team_id">
                      </div>
                      <div class="otp-error ml-3">
                          
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
           data: $('#send-otp-form').serialize(),
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success : function(response) {
                if(save_exit_true()){
                    if(response.status == 201){
                        toaserMessage(response.status, response.message);
                        $('#input_mobile_number').text(mobile);
                        $(".mbns-otpform").addClass("d-none");
                        $(".otps-otpform").removeClass("d-none");
                        $('.otp-field:eq(0)').focus();
                    }else{
                        $('input[name="mobile_number"]').after('<span class="help-block error-block text-danger"><small>'+response.message+'</small></span>'); 
                    }    
                }
           },
           error: function (reject) {
                if(save_exit_true()){
                    if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        $.each(errors,function(field_name,error){
                            $('input[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>Mobile Number is Invalid</small></span>'); 
                        });
                    }
                }
            }
        }); 
    }
});

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
                    $('.otp-error').html('<span class="help-block error-block text-danger"><small class="text-danger">'+response.message+'</small></span>');
                }    
            }
       },
        error: function (reject) {
            if(save_exit_true()){
                if(reject.status === 422 ) {
                    var response = $.parseJSON(reject.responseText);
                    var errors = response['errors'];
                    $('.error-block').remove();
                    $.each(errors, function(field_name, error_array) {
                        $.each(error_array, function(index, error_message) {
                            $('.otp-error').html('<span class="help-block error-block text-danger"><small class="text-danger">'+ error_message +'</small></span>');
                        });
                    });
                }
            }
        }
    }); 
});
</script>

<script>
    $(document).ready(function () {
    	$(".otp-form *:input[type!=hidden]:first").focus();
    	let otp_fields = $(".otp-form .otp-field"),otp_value_field = $(".otp-form .otp-value");
    	otp_fields.on("input", function (e) {
    			$(this).val($(this).val().replace(/[^0-9]/g, ""));
    			let opt_value = "";
    			otp_fields.each(function () {
    				let field_value = $(this).val();
    				if (field_value != "") opt_value += field_value;
    			});
    			otp_value_field.val(opt_value);
    		}).on("keyup", function (e) {
    			let key = e.keyCode || e.charCode;
    			if (key == 8 || key == 46 || key == 37 || key == 40) {
    				// Backspace or Delete or Left Arrow or Down Arrow
    				$(this).prev().focus();
    			} else if (key == 38 || key == 39 || $(this).val() != "") {
    				// Right Arrow or Top Arrow or Value not empty
    				$(this).next().focus();
    			}
    		}).on("paste", function (e) {
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