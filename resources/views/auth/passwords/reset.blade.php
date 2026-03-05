@extends('layouts._auth_master')
@section('title', 'Reset Password - Knote')
@section('content')
<div class="account-pages mt-5 mb-5">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
               <div class="card-body p-4">
                  <div class="text-center w-75 m-auto">
                     <a href="{{ url('/') }}">
                     <span><img src="{{ asset('user/img/logo_banner.png') }}" alt="" height="40"></span>
                     </a>
                     <p class="text-muted mb-4 mt-3">Enter your new password</p>
                  </div>
                  <form class="login-form" method="POST" action="{{ route('password.update') }}">
                     @csrf
                     <input type="hidden" name="token" value="{{ $token }}">
                     <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                     <div class="form-group mb-3">
                        <label for="email">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="form-group mb-3">
                        <label for="email">Password Confirm</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Password Confirm" required autocomplete="new-password">
                     </div>
                     <div class="form-group mb-2 pb-2 error-message">
                     </div>
                     <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-success btn-block">
                        {{ __('Reset Password') }}
                        </button>
                     </div>
                  </form>
               </div>
              
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
</div>
@endsection