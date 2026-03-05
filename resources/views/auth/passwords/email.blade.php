@extends('layouts._auth_master')

@section('title', 'Password Reset - Knote')
@section('content')

<div class="container-fluid">
      <div class="row justify-content-center">
         <div class="login-more">
            <div class="container mt-2">
               <div class="logo-area pt-2 pl-2 text-center text-lg-left d-none d-md-block">
               		<a href="{{ url('/') }}">
                	<img src="{{ asset('user/images/logo.png') }}" alt="">
                	</a>
               </div>
            </div>
         </div>
         <div class="form-login">
            <div class="card bg-pattern">
               <div class="card-body p-4 mt-4">
                  <div class="text-center w-75 m-auto">
                     <a href="{{ url('/') }}">
                     <span><img src="{{ asset('user/images/logo.png') }}" alt="" height="40"></span>
                     </a>
                     <p class="text-muted mb-4 mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                  </div>
                 <form class="forget-form" role="form" method="post" style="display: block !important;" action="{{ route('password.email') }}">
                  @csrf
                  
                	<div class="wrap-form-group validate-input">
                       <input name="email" id="emailaddress" type="text" class="form-control" placeholder="" autocomplete="off" value="{{ old('email') }}">
                        <span class="focus-form-control"></span>
                        <span class="label-form-control">Enter your email</span>
                    </div>
                    
                    @if ($errors->has('email'))
                        <span class="help-block text-red"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                    
                    
                    
                    
                    
                    
                    
                     
                     <div class="form-group mb-0 text-center">
                        <button class="btn btn-success btn-block" type="submit"> Reset Password </button>
                     </div>
                  </form>
               </div>
               <!-- end card-body -->
            </div>
            
         </div>
      </div>
      <!-- end row -->
   </div>

@endsection
