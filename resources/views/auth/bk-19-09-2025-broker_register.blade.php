@extends('layouts._auth_master')
@section('title', 'Broker Registration - Knote')
@section('content')
<div class="account-pages pt-1 pb-5 cu-footer-tp-section">
    <div class="container">
        <div class="text-center mt-4 mb-4 header-title">
            <!--<h1><strong></strong></h1>-->
        </div>
        <div class="row">
            <div class="col-lg-10 ml-auto mr-auto">
                <div class="card bg-pattern light-grey overflow-hidden">
                    <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card-body p-sm-4 p-3 text-left h-100">
                                
                                <div class="text-left mb-2">
                                    <h2><strong>Broker Registration</strong></h2>
                                    <h4 class="mb-3 tag-line-create-account">It wont take long at all - quick & easy registration!</h4>
                                </div>
                                <br>
                                
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
                                    <div class="form-group mb-1 pb-1 error-message"> </div>
                                    <input type="hidden" name="role" value="6">
                                    <div class="form-row">
                                        <div class="form-group mb-0 text-left col-xl-6 terms-condition"> By getting
                                            started you are agreeing to our <a target="_blank"
                                                href="{{ config('constants.wp_privacy_policy') }}">Terms &amp;
                                                Conditions</a> </div>
                                        <div class="form-group mb-0 text-center col-xl-6">
                                            <button class="btn btn-success btn-lg btn-block" id="btn-broker-register"
                                                name="btn-broker-register" type="submit"> Register </button>
                                        </div>
                                    </div>
                                </form>
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
                                            <a href="tel://1300056683"><i class="fa fa-phone fa-flip-horizontal"
                                                    aria-hidden="true"></i>Call us on 1300 056 683</a><br>
                                            <span class="ml-1">Mon - Fri, 9:00am till 5:30pm</span>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@knote.com.au"><i class="fa fa-envelope"
                                                    aria-hidden="true"></i>Email hello@knote.com.au</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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