@extends('layouts._auth_master')
@section('title', 'Broker Registration - Knote')
@section('content')
<section class="new_page_banner">
    <h1>Broker<span>Registration</span></h1>
</section>
<div class="pt-4 pb-5">
    <div class="container new_design">
        <div class="row">
            <div class="col-lg-8" style="align-self: center;">
                <div class="fund_your_left pr-lg-5">
                	<P class="quick_easy_application mb-4 mt-3">It wont take long at all - quick & easy registration!</P>
                	<div id="thank-you-div" class="d-none thank-you animated fadeInDown">
                		<div class="your-call-back">
                			<h5>Your broker request has been submitted.</h5>
                			<p>Your broker account is currently under review by our admin team. Once the verification is complete, your account will be activated and a confirmation email will be sent to you.</p>
                		</div>
                		<h5>When we call, we’ll be able to help you with:</h5>
                		<ul>
                			<li>Any questions you have about knote</li>
                			<li>What you’ll need to complete your registration</li>
                			<li>Next steps to continue</li>
                		</ul>
                		<p>We look forward to discussing your funding needs with you.</p>
                	</div>
                	<form action="{{ url('broker/store') }}" method="POST" onsubmit="return false;" name="broker-register-div" class="animated fadeInDown broker-register-form new-register-form" id="broker-register-div" autocomplete="off">
                		@csrf
                		<div class="form-group">
                			<label for="name">Full name</label>
                			<input name="fullname" id="fullname" autocomplete="off" type="fullname" maxlength="50"
                				class="form-control">
                		</div>
                		<div class="form-row">
                			<div class="form-group col-md-6">
                				<label for="name">Email Address</label>
                				<input name="email" id="email" type="email" autocomplete="off" maxlength="100"
                					class="form-control">
                			</div>
                			<div class="col-md-6">
                				<div class="form-group mb-0">
                					<label for="name">Phone</label>
                				</div>
                				<div class="form-row">
                					<div class="form-group col-12 col-md-12 col-lg-12" for="phone">
                						<input name="phone" id="phone" type="text"
                							class="form-control phone-field" autocomplete="off">
                					</div>
                				</div>
                			</div>
                		</div>
                		<input type="hidden" name="role" value="6">
                		<div class="form-row">
                			<div class="form-group  text-left col-xl-12 terms-condition"> By getting
                				started you are agreeing to our <a target="_blank"
                					href="{{ config('constants.wp_privacy_policy') }}">Terms &amp;
                				Conditions</a> 
                			</div>
                			<div class="form-group mb-0 text-center col-xl-12">
                				<button class="btn btn-success btn-lg btn-block rounded-pill" id="btn-broker-register"
                					name="btn-broker-register" type="submit"> Register </button>
                			</div>
                			<div class="form-group mt-1 pb-1 error-message"></div>
                		</div>
                	</form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="fund_your_right">
                    <div class="what_do_need">
                    	<h4>How Knote can help?</h4>
                    	<ul>
                    		<li><i class="fa fa-check" aria-hidden="true"></i> Property Loan</li>
                    		<li><i class="fa fa-check" aria-hidden="true"></i> Business Cash flow Loan</li>
                    		<li><i class="fa fa-check" aria-hidden="true"></i> Commercial / Business Loan</li>
                    		<li><i class="fa fa-check" aria-hidden="true"></i> Cryptocurrency Loan</li>
                    	</ul>
                    </div>
                    <div class="have_questions">
                    	<h4>We are happy to answer questions</h4>
                    	<p>Our friendly customer service team are waiting to help you.</p>
                    	<ul>
                    		<li class="mb-2">
                    			<a href="tel://1300056683"><i class="fa fa-phone fa-flip-horizontal" aria-hidden="true"></i>Call us on 1300 056 683</a><br>
                    			<span class="ml-3">Mon - Fri, 9:00am till 5:30pm</span> 
                    		</li>
                    		<li>
                    			<a href="mailto:hello@knote.com.au"><i class="fa fa-envelope" aria-hidden="true"></i>Email hello@knote.com.au</a>
                    		</li>
                    	</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
$('#btn-broker-register').click(function(){

    $('.error-block').remove();
    var url = $('.broker-register-form').attr('action');
    var redirect_url = $('.broker-register-form').attr('data-redirect-url');
 
    $.ajax ({
        type: 'POST',
        url: url,
        data: $(".broker-register-form").serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            
            if(response.status == 201){
                
                $('.broker-register-form')[0].reset();
                
                $('#broker-register-div').fadeOut();
                $('#thank-you-div').fadeIn().removeClass('d-none');

            }else{
                $('.error-block').remove();
                $('.error-message').append('<span class="help-block error-block"><small>'+response.message+'</small></span>');  
            }
        },
        error: function (reject) {
            $('.error-block').remove();
            if( reject.status === 422 ) {
                var errors = $.parseJSON(reject.responseText);
                var errors = errors['errors'];
                
                $.each(errors,function(field_name,error){
                    if(field_name == "terms_and_condition"){
                        $('.error-message').append('<span class="help-block error-block"><small>'+error+'</small></span>');  
                    }else{
                        $('input[name="'+field_name+'"]').after('<span class="help-block error-block"><small>'+error+'</small></span>');  
                    }
                });
            }
        }
    }); 
});
</script>
@endsection